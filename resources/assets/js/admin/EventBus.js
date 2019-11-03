import Vue from 'vue'
import Utility from '../Utilities'
import {
    gsap,
}
from 'gsap/all'

const throttle = require('lodash.throttle')
const debounce = require('lodash.debounce')
const globalTime = 100

class Cache {
    constructor() {
        this.queue = []
    }

    add(item) {
        this.queue.push(item)
    }

    remove() {
        this.queue.shift()
    }
}

const EventBus = new Vue({
    render: h => h(),
    data: function () {
        return {
            cached: [],
            head: [],
            limit: 2,
            counter: 0,
            completed: 0,
            test: 0,
            running: false,
            wait: false,
            queue: [],
            playing: null,
        }
    },
    watch: {
        counter: function (c) {
            console.log('totale', c);
        },
        completed: function (c) {
            console.log('completate', c);
        },
        cached: function (cached) {
            this.filterCache()
        },
        head: function () {
            this.playNext()
        },
        queue: function (l) {
            this.fillHead()
        },
    },
    computed: {
        headHasSpace: function () {
            if (this.headIsEmpty || this.head.length < this.limit) {
                return true
            }
            return false
        },
        headIsEmpty: function () {
            return !this.head.length
        },
        queueIsEmpty: function () {
            return !this.queue.length
        },
        next: function () {
            if (this.queueIsEmpty) {
                return false
            }
            return this.queue[0]
        },
        peek: function () {
            return this.head.find(item => item.anim.isActive() == false)
        }
    },
    methods: {
        filterCache: debounce(function () {
            let cache = Object.assign([], this.cached)
            let addToQueue = true
            for (let i = 0; i < cache.length; i++) {
                let current = cache[i]
                let similar = cache.filter(item => item.uuid == current.uuid)
                if (similar.length > 1) {
                    console.log('abbiamo un dupplicato');
                    addToQueue = false
                }
            }

            if (addToQueue == true && cache.length > 0) {
                this.queue.push(cache[0])
                this.cached.shift()
            }
        }, 100),
        fillHead: debounce(function () {
            if (this.next && this.headHasSpace) {
                this.head.push(this.next)
                this.queue.shift()
            }
        }, 100),
        playNext: debounce(function () {
            if (this.peek) {
                let peek = Object.assign({}, this.peek)
                if (peek.direction == true) {
                    const onComplete = peek.anim.eventCallback('onComplete')

                    peek.anim.eventCallback('onComplete', () => {
                        this.removeCompleted(peek, onComplete, 'onComplete')
                    })

                    const onStart = peek.anim.eventCallback('onStart')
                    peek.anim.eventCallback('onStart', () => {
                        if (Utility.isFunction(peek.callback)) {
                            peek.callback()
                        }
                    })
                    console.log(peek.anim.progress());
                    peek.anim.play(0)
                }
                else if (peek.direction == false) {
                    const onReverseComplete = peek.anim.eventCallback('onReverseComplete')
                    peek.anim.eventCallback('onReverseComplete', () => {
                        this.removeCompleted(peek, onReverseComplete, 'onReverseComplete')
                    })


                    // onStart Reverse
                    let lastTime = 0
                    let forward = false
                    const onUpdate = peek.anim.eventCallback('onUpdate')
                    peek.anim.eventCallback('onUpdate', () => {
                        let newTime = peek.anim.time()
                        if ((forward && newTime < lastTime) || (!forward && newTime > lastTime)) {
                            forward = !forward;
                            if (!forward) {
                                if (Utility.isFunction(peek.callback)) {
                                    peek.callback()
                                }
                            }
                        }
                        lastTime = newTime;
                    })

                    console.log('reverse', peek.anim.progress());
                    peek.anim.reverse(1)
                }
            }
        }, 100),
        removeCompleted: function (item, callback, name) {
            if (Utility.isFunction(callback)) {
                callback()
            }

            item.anim.eventCallback(name, callback)

            let idx = this.head.findIndex(obj => obj.uuid == item.uuid)
            this.$nextTick(() => {
                if (idx > -1) {
                    this.head.splice(idx, 1)
                    this.fillHead()
                }
            })
        },
        addToCache: function (anim, direction, uuid, callback) {
            // if (gsap.isTweening(anim) == false) {
            const newAnim = {
                anim: anim,
                uuid: uuid,
                direction: direction,
                state: 0,
                callback: callback,
            }

            this.cached.push(newAnim)
        },
    },
    created: function () {
        this.$on('add-anim', (anim, direction, uuid, callback = null) => {
            this.addToCache(anim, direction, uuid, callback)
        })
    },
}).$mount('#bus')


export default EventBus
