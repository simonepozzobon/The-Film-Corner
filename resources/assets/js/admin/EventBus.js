import Vue from 'vue'
import Utility from '../Utilities'

const EventBus = new Vue({
    render: h => h(),
    data: function () {
        return {
            pool: [],
            cached: [],
            toPlay: [],
            limit: 4,
            counter: 0,
            completed: 0,
            test: 0,
            initialized: false,
            wait: false,
            isReady: true,
        }
    },
    watch: {
        counter: function (c) {
            console.log('totale', c);
        },
        completed: function (c) {
            console.log('completate', c);
        },
        toPlay: function (toPlay) {
            if (toPlay.length >= this.limit) {
                console.log('sopra il limiter');
                let gonnaPlay = toPlay.find(item => item.state == 0)
                console.log(gonnaPlay);
                if (gonnaPlay) {
                    this.$nextTick(() => {
                        this.play(gonnaPlay)
                        console.log('gonnaPlay');
                    })
                }
            }
            else if (toPlay.length >= 0 && toPlay.length < this.limit) {
                let gonnaPlay = toPlay.find(item => item.state == 0)
                if (gonnaPlay) {
                    this.$nextTick(() => {
                        this.play(gonnaPlay)
                        console.log('gonnaPlay');
                    })
                }
                else {
                    console.log('nessuno in lista');
                }
            }
            else {
                console.log('buffer finito', this.toPlay.length);
            }
        },
        pool: function (pool) {
            if (pool.length > 0 && this.isReady == true) {
                this.isReady = false
                this.$nextTick(() => {
                    this.checkDuplicatesOnCache(pool[0])
                })
            }
        },
        isReady: function (value) {
            if (value == true && this.bufferIsFree) {
                console.log(this.bufferIsFree);
                this.checkQueue()
            }
        }
    },
    computed: {
        bufferIsFree: function () {
            if (this.toPlay.length >= 0 && this.toPlay.length < this.limit) {
                return true
            }
            return false
        },
    },
    methods: {
        checkBuffer: function () {
            if (this.toPlay.length >= 0 && this.toPlay.length < this.limit) {
                // c'è spazio
                return this.checkQueue()
            }
            else {
                // console.log('busy');
                return false
            }
        },
        checkQueue: function () {
            let next = this.cached.find(item => item.state == 0)
            if (next) {
                let idx = this.cached.indexOf(next)
                if (idx > -1) {
                    this.toPlay.push(next)
                    // console.log(this.cached[idx].uuid, 'fuori');
                    this.cached.splice(idx, 1)
                }
                else {
                    console.log('non trovata');
                }
            }
            else {
                // console.log('no next', this.cached.length);
            }
            return true
        },
        freeBuffer: function (timeline, callback) {
            timeline.completed = 1
            // console.log(timeline.uuid, 'complete');
            this.runCallback(timeline, callback)

            let idx = this.toPlay.indexOf(timeline)
            if (idx > -1) {
                this.toPlay.splice(idx, 1)
                // this.checkBuffer()
            }
            return true
        },
        runCallback: function (timeline, callback, onStart = false) {
            if (Utility.isFunction(timeline.callback)) {
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

                    timeline.anim.play()
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
                        let newTime = timeline.anim.time();
                        if ((forward && newTime < lastTime) || (!forward && newTime > lastTime)) {
                            forward = !forward;
                            if (!forward) {
                                timeline.state = 1

                                this.runCallback(timeline, onUpdate, true)
                            }
                        }
                        lastTime = newTime;
                    })

                    timeline.anim.progress(1)
                    timeline.anim.reverse()
                }
            }

        },
        checkDuplicatesOnCache: function (next) {
            if (this.cached.length > 0) {
                // prova a cercare i dupplicati se si inceppa

                let hasDuplicate = false
                for (let i = 0; i < this.cached.length; i++) {
                    let single = this.cached[i]

                    if (single.uuid == next.uuid && single.direction == next.direction) {
                        hasDuplicate = true
                    }
                }

                if (hasDuplicate == false) {
                    this.cached.push(next)
                }
            }
            else {
                this.cached.push(next)
            }

            // let test = this.checkBuffer()
            // console.log(test);

            let idx = this.pool.indexOf(next)
            if (idx > -1) {
                this.pool.splice(idx, 1)
                this.$nextTick(() => {
                    this.isReady = true
                })
            }
        },
        bufferPool: function (newAnim) {
            this.pool.push(newAnim)
        },
    },
    created: function () {
        this.$on('add-anim', (anim, direction, uuid, callback = null) => {
            let newAnim = {
                id: Utility.uuid(),
                anim: anim,
                uuid: uuid,
                direction: direction,
                state: 0,
                completed: 0,
                callback: callback,
            }

            this.bufferPool(newAnim)
        })
    },
}).$mount('#bus')


export default EventBus
