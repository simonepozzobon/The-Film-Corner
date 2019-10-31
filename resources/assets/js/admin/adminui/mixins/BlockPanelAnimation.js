import {
    TweenMax,
    TimelineMax,
    Power4,
    Power0,
    CSSPlugin,
    Elastic,
    Back,
    Sine,
}
from 'gsap/all'


import {
    GSDevTools
}
from 'gsap/GSDevTools'

const plugins = [
    CSSPlugin,
    Power4,
    Power0,
    Elastic,
    Back,
    Sine,
]

const BlockPanelAnimation = {
    methods: {
        initAnim: function () {
            let display = 'block'
            if (this.needsFlex == true) {
                display = 'flex'
            }
            let parent = this.$parent.$el
            let head = this.$refs.head
            let content = this.$refs.container
            let childs = content.children
            let childsVisible = []

            // console.log('initializin animation', this.title, parent);
            // parent = parent.parentNode
            // console.log(this.$children);
            for (let i = 0; i < childs.length; i++) {
                let child = childs[i]
                if (this.isVisible(child)) {
                    childsVisible.push(child)
                }
            }

            // console.log(childsVisible);

            this.master = gsap.timeline({
                paused: true,
                yoyo: true,
            })

            this.master.addLabel('start', 0)
            this.master.addLabel('setInitial', 'start')
            this.master.addLabel('setWidth', 'start+=0.1')
            this.master.addLabel('setHeight', 'start+=0.15')
            this.master.addLabel('revealFrame', 'start+=0.35')
            this.master.addLabel('revealContent', 'start+=0.45')

            this.master.fromTo(content, .1, {
                    display: 'none',
                }, {
                    display: 'block',
                }, 'start')
                .to(childsVisible, .1, {
                    opacity: '0',
                }, 'start')
                .to(this.$refs.parent, .1, {
                    display: 'flex',
                }, 'start')

                .to(content, 0, {
                    height: '1px',
                    paddingTop: '0',
                    paddingBottom: '0',
                    overflow: 'hidden',
                }, 'start')

                .fromTo(content, 0.1, {
                    width: '1px',
                    maxWidth: '0%',
                }, {
                    id: 'width',
                    width: '100%',
                    maxWidth: '100%',
                    ease: Sine.easeInOut,
                    yoyoEase: Sine.easeIn,
                    immediateRender: false,
                }, 'setWidth')

                .fromTo(content, .1, {
                    height: '1px',
                    paddingTop: '0',
                    paddingBottom: '0',
                }, {
                    height: 'auto',
                    paddingTop: '1.618rem',
                    paddingBottom: '1.618rem',
                    immediateRender: false,
                    ease: Sine.easeInOut,
                    yoyoEase: Sine.easeIn,
                }, 'setHeight')

                .fromTo(content, .2, {
                    opacity: '0',
                }, {
                    opacity: '1',
                    ease: Power4.easeInOut,
                    immediateRender: false,
                }, 'setInitial')

                .fromTo(head, .3, {
                    paddingBottom: '0',
                }, {
                    paddingBottom: '1.618rem',
                    immediateRender: false,
                }, 'start')

                .fromTo(parent, .1, {
                    paddingBottom: '2rem',
                }, {
                    paddingBottom: '1.618rem',
                    immediateRender: false,
                }, 'setHeight+=0.05')

                .fromTo(content, .1, {
                    borderWidth: '0',
                }, {
                    id: 'boders',
                    borderWidth: '3px',
                    ease: Power4.easeInOut,
                    immediateRender: false,
                }, 'revealFrame')

                .fromTo(content, .2, {
                    boxShadow: 'inset 0 0 8px rgba(159, 173, 186, 0)',
                }, {
                    boxShadow: 'inset 0 0 8px rgba(159, 173, 186, 0.2)',
                    immediateRender: false,
                    ease: Sine.easeInOut,
                }, 'revealFrame')

                .fromTo(childsVisible, .15, {
                    opacity: '0',
                    scaleX: 0.9,
                    scaleY: 1.1,
                }, {
                    opacity: '1',
                    scaleX: 1,
                    scaleY: 1,
                    stagger: {
                        amount: 0.1,
                        each: -1,
                        from: 'start',
                        ease: Sine.easeIn,
                    },
                    ease: Sine.easeOut,
                    immediateRender: false,
                }, 'revealContent')

            if (this.initialState == false) {
                this.master.progress(1)
            }
            // else {
            //     this.master.progress(1).progress(0)
            // }
            // this.master.progress(1)
            // .progress(0)

            this.isOpen = this.initialState

            // console.log(this.isOpen);
            this.togglePanel()

        },
    },
}

export default BlockPanelAnimation
