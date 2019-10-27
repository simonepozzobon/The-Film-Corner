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
        }
    },
    watch: {
        counter: function (c) {
            console.log('totale', c);
        },
        completed: function (c) {
            console.log('completate', c);
        },
        // cached: function (cached) {
        //     if (cached.length > 0) {
        //         this.checkBuffer()
        //     }
        //     else {
        //         // console.log('fine cache');
        //     }
        // },
        toPlay: function (toPlay) {
            // console.log(toPlay.uuid, 'dentro');
            if (toPlay.length > 0) {
                let gonnaPlay = toPlay.find(item => item.state == 0)
                if (gonnaPlay) {
                    this.play(gonnaPlay)
                    console.log('gonnaPlay');
                }
                else {
                    console.log('nessuno in lista');
                }
            }
            else {
                console.log('buffer finito', this.toPlay.length);
            }
        }
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
        checkDuplicatesOnCache: function (next) {
            if (this.cached.length > 0) {
                // prova a cercare i dupplicati se si inceppa

                let similar = []

                for (let i = 0; i < this.cached.length; i++) {
                    let single = this.cached[i]

                    if (single.uuid == next.uuid) {
                        let idx = similar.findIndex(item => item.uuid == next.uuid)
                        if (idx == -1) {
                            similar.push({
                                uuid: next.uuid,
                                items: [next]
                            })
                        }
                    }
                }

                if (similar.length > 0) {
                    for (let j = 0; j < similar.length; j++) {
                        this.checkSameDirection(similar[j].items)
                    }
                }

                // similar.map(serie => {
                //     if (serie.items.length > 1) {
                //         // console.log('dupplicati', serie);
                //         let similarDirections = []
                //
                //         serie.items.map(single => {
                //             let idx = similarDirections.findIndex(item => item.direction == single.direction)
                //             if (idx == -1) {
                //                 similarDirections.push({
                //                     direction: single.direction,
                //                     items: [single]
                //                 })
                //             }
                //             else {
                //                 similarDirections[idx].items.push(single)
                //             }
                //         })
                //
                //         console.log(similarDirections);
                //     }
                // })

            }
            else {
                console.log('nuovo');
                this.cached.push(next)
                // this.checkBuffer()
            }
        },
        checkSameDirection: function (anims) {
            let similar = []

            for (let i = 0; i < anims.length; i++) {
                let anim = anims[i]
                let idx = similar.findIndex(item => item.direction == anim.direction)
                if (idx == -1) {
                    similar.push({
                        direction: anim.direction,
                        items: [anim]
                    })
                }
                else {
                    similar[idx].items.push(anim)
                }
            }
            console.log(similar);
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

            this.checkDuplicatesOnCache(newAnim)
        })
    },
}).$mount('#bus')


export default EventBus
