import Vue from 'vue'
import Utility from '../Utilities'
import {
    gsap,
}
from 'gsap/all'

const throttle = require('lodash.throttle')
const debounce = require('lodash.debounce')
const globalTime = 100

const EventBus = new Vue({
    render: h => h(),
    data: function () {
        return {
            cached: [],
            toPlay: [],
            limit: 2,
            counter: 0,
            completed: 0,
            test: 0,
            initialized: false,
            wait: false,
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
            // this.throttleCache()
            if (cached.length > 0) {
                this.checkBuffer()
            }
            else {
                // console.log('fine cache');
            }
        },
        toPlay: function (toPlay) {
            if (toPlay.length > 0) {
                let gonnaPlay = toPlay.find(item => item.state == 0)
                if (gonnaPlay) {
                    this.play(gonnaPlay)
                }
                else {
                    // console.log('nessuno in lista');
                }
            }
            else {
                if (this.cached.length > 0) {
                    // console.log('da svuotare la cache', this.cached.length);
                    // this.$nextTick(() => {
                    this.checkBuffer('qui')
                    // })
                }
                else {
                    this.$emit('buffer-free')
                    // console.log('buffer finito', this.cached.length);
                }
            }
        }
    },
    methods: {
        checkBuffer: throttle(function (debug = null) {
            if (debug) {
                console.log(debug);
            }
            let buffer = this.toPlay.length
            let queue = this.cached.length

            if (buffer >= 0 && buffer < this.limit) {
                // c'è spazio

                if (buffer == 0) {
                    // è il primo play
                    // console.log('prima', gsap.isTweening(this.toPlay[0].anim));
                    // console.log('primo');
                    this.firstCached()
                }
                else if (buffer > 0 && buffer < this.limit) {
                    // ci sono degli slot liberi
                    // console.log('abbiamo slot liberi');
                    this.firstCached()
                }
                else if (queue > 0 && buffer < (this.limit - 1)) {
                    // ce almeno uno slot libero e la cache piena
                    console.log('la cache è ancora piena', buffer, queue);
                }
                else {
                    // c'è un problema
                    console.log('deve vomitare', buffer < this.limit, queue, buffer);
                }
            }
            else if (buffer > 0) {
                // deve sbloccare la cache
                console.log('deve sbloccare');
                let toUnlock = this.toPlay.find(item => gsap.isTweening(item.anim) == false)
                if (toUnlock) {
                    toUnlock.state = 0
                    this.$nextTick(() => {
                        this.play(toUnlock)
                    })
                }
            }
            else {
                console.log('terzo caso');
            }
        }, globalTime),
        firstCached: throttle(function () {
            let next = this.cached.find(item => item.state == 0)
            if (next) {
                let check = gsap.isTweening(next.anim)
                if (!next.anim.isActive()) {
                    let idx = this.cached.indexOf(next)
                    if (idx > -1) {
                        this.cached.splice(idx, 1)
                        return this.toPlay.push(next)
                    }
                    else {
                        console.log('non trovata');
                        return false
                    }
                }
                else {
                    console.log('abbiamo');
                }

            }
            else {
                if (this.cached.length > 0 && this.toPlay.length == 0) {
                    if (gsap.isTweening(this.cached[0])) {
                        this.cached[0].state = 0
                    }
                }

                return false
            }
        }, globalTime),
        freeBuffer: function (timeline, callback) {
            this.runCallback(timeline, callback)

            let idx = this.toPlay.indexOf(timeline)
            if (idx > -1) {
                this.toPlay.splice(idx, 1)
                this.checkBuffer()
            }
            else {}
            return true
        },
        runCallback: function (timeline, callback, onStart = false) {
            if (onStart == true && Utility.isFunction(timeline.callback)) {
                timeline.callback()
            }

            if (callback) {
                callback()
            }

            this.restoreCallback(timeline, callback ? callback : null, onStart)


            return true
        },
        restoreCallback: function (timeline, callback, onStart) {
            if (onStart == true) {
                if (timeline.direction) {
                    timeline.anim.eventCallback('onStart', callback)
                }
                else {
                    timeline.anim.eventCallback('onUpdate', callback)
                }
            }
            else {
                if (timeline.direction) {
                    timeline.anim.eventCallback('onComplete', callback)
                }
                else {
                    timeline.anim.eventCallback('onReverseComplete', callback)
                }
            }

            return true
        },
        play: function (timeline) {
            if (timeline.state == 0) {
                if (timeline.direction == true) {
                    // play
                    const onComplete = timeline.anim.eventCallback('onComplete')

                    timeline.anim.eventCallback('onComplete', () => {
                        this.freeBuffer(timeline, onComplete)
                    })

                    const onStart = timeline.anim.eventCallback('onStart')
                    timeline.anim.eventCallback('onStart', () => {
                        timeline.state = 1
                        this.runCallback(timeline, onStart, true)
                    })


                    // if (timeline.anim.isActive()) {
                    //     console.log('attiva', timeline.anim.reversed());
                    // }
                    // else {
                    timeline.anim.progress(0).play()
                    // }
                }
                else if (timeline.direction == false) {
                    // reverse
                    const onReverseComplete = timeline.anim.eventCallback('onReverseComplete')
                    timeline.anim.eventCallback('onReverseComplete', () => {
                        this.freeBuffer(timeline, onReverseComplete)
                    })


                    // onStart Reverse
                    let lastTime = 0
                    let forward = false
                    const onUpdate = timeline.anim.eventCallback('onUpdate')
                    timeline.anim.eventCallback('onUpdate', () => {
                        let newTime = timeline.anim.time()
                        if ((forward && newTime < lastTime) || (!forward && newTime > lastTime)) {
                            forward = !forward;
                            if (!forward) {
                                timeline.state = 1

                                this.runCallback(timeline, onUpdate, true)
                            }
                        }
                        lastTime = newTime;
                    })

                    // if (timeline.anim.isActive()) {
                    //     console.log('attiva');
                    // }
                    // else {
                    timeline.anim.progress(1).reverse()
                    // }
                }
            }
        },
        addToCache: throttle(function (anim, direction, uuid, callback) {
            // if (gsap.isTweening(anim) == false) {
            // console.log('dentro', i);
            const newAnim = {
                anim: anim,
                uuid: uuid,
                direction: direction,
                state: 0,
                callback: callback,
            }

            this.$nextTick(() => {
                this.cached.push(newAnim)
            })

        }, globalTime),
    },
    created: function () {
        this.$on('add-anim', (anim, direction, uuid, callback = null) => {
            this.addToCache(anim, direction, uuid, callback)
        })
    },
}).$mount('#bus')


export default EventBus
