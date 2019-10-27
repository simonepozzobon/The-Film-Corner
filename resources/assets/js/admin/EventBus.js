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
                if (this.wait == false) {
                    this.wait = true
                    if (this.toPlay.length < this.limit) {
                        const next = this.cached[0]
                        if (next) {
                            this.toPlay.push(next)
                        }
                    }
                    else {
                        console.log('busy');
                    }
                }
            }
        },
        toPlay: function (toPlay) {
            // console.log(Object.assign([], toPlay));
            if (toPlay.length < this.limit) {

            }
        }
    },
    methods: {
        checkBuffer: function () {
            if (this.toPlay.length >= 0 && this.toPlay.length < this.limit) {
                return true
            }
            else {
                return false
            }
        },
        freeCache: function (timeline) {
            // console.log('qui');
            let idx = this.cached.findIndex(item => item.uuid == timeline.uuid)
            let cached = Object.assign([], this.cached)
            if (idx > -1) {
                cached.splice(idx, 1)
            }
            // console.log(cached.length, idx);
            this.wait = false
            this.cached = cached
        },
        setCompleted: function (timeline) {
            let idx = this.toPlay.findIndex(item => item.uuid == timeline.uuid)
            let toPlay = Object.assign([], this.toPlay)
            if (idx > -1) {
                toPlay.splice(idx, 1)
            }
            this.toPlay = toPlay

            console.log(timeline.uuid, 'completata', this.toPlay.length, this.wait);
        },
        play: function (timeline) {
            if (timeline.direction == true) {

                const onComplete = timeline.anim.eventCallback('onComplete')
                timeline.anim.eventCallback('onComplete', () => {
                    if (onComplete) {
                        onComplete()
                        timeline.anim.eventCallback('onComplete', onComplete)
                    }
                    else {
                        timeline.anim.eventCallback('onComplete', null)
                    }
                    this.setCompleted(timeline)
                })

                timeline.anim.eventCallback('onStart', () => {
                    timeline.state = 1
                })

                timeline.anim.play()
            }
            // else {
            //     // console.log('rovescio', timeline.debug);
            //
            //     let onReverseComplete = timeline.anim.eventCallback('onReverseComplete')
            //     timeline.anim.eventCallback('onReverseComplete', () => {
            //         if (onReverseComplete) {
            //             onReverseComplete()
            //             timeline.anim.eventCallback('onReverseComplete', onReverseComplete)
            //         }
            //         else {
            //             timeline.anim.eventCallback('onReverseComplete', null)
            //         }
            //
            //         this.setCompleted(timeline)
            //     })
            //
            //     timeline.anim.reverse()
            // }
        },
    },
    created: function () {
        this.$on('add-anim', (anim, direction, uuid, debug = null) => {
            let newAnim = {
                anim: anim,
                uuid: uuid,
                direction: direction,
                state: 0,
                debug: debug,
            }
            this.cached.push(newAnim)
        })
    },
}).$mount('#bus')


export default EventBus
