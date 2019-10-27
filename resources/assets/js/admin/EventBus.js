import Vue from 'vue'
import Utility from '../Utilities'

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
                    console.log('nessuno in lista');
                }
            }
            else {
                console.log('buffer finito', this.cached.length);
            }
        }
    },
    methods: {
        checkBuffer: function () {
            if (this.toPlay.length >= 0 && this.toPlay.length < this.limit) {
                // c'è spazio
                this.firstCached()
                return true
            }
            else {
                // deve riprovare
                // console.log(false);
                return false
            }
        },
        firstCached: function () {
            let next = this.cached.find(item => item.state == 0)
            if (next) {
                let idx = this.cached.indexOf(next)
                if (idx > -1) {
                    this.toPlay.push(next)
                }
                else {
                    console.log('non trovata');
                }
                // this.cached.splice(idx, 1)
            }
            else {
                console.log('no next');
            }
        },
        freeBuffer: function (timeline, callback) {
            // console.log(timeline.uuid, 'complete');
            this.runCallback(timeline, callback)

            let idx = this.toPlay.indexOf(timeline)
            if (idx > -1) {
                this.toPlay.splice(idx, 1)
                this.checkBuffer()
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
    },
    created: function () {
        this.$on('add-anim', (anim, direction, uuid, callback = null) => {
            let newAnim = {
                anim: anim,
                uuid: uuid,
                direction: direction,
                state: 0,
                callback: callback,
            }
            this.cached.push(newAnim)
        })
    },
}).$mount('#bus')


export default EventBus
