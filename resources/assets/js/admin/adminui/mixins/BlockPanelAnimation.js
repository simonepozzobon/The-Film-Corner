import {
    gsap
}
from 'gsap'

import {
    CSSPlugin
}
from 'gsap/CSSPlugin'

import {
    GSDevTools
}
from 'gsap/GSDevTools'

gsap.registerPlugin(CSSPlugin)

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

            for (let i = 0; i < childs.length; i++) {
                let child = childs[i]
                if (this.isVisible(child)) {
                    childsVisible.push(child)
                }
            }

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

            this.master.fromTo(content, {
                display: 'none',
            }, {
                display: 'block',
                duration: 0.1,
            }, 'start')

            this.master.to(childsVisible, {
                opacity: '0',
                duration: 0.1,
            }, 'start')

            this.master.to(this.$refs.parent, {
                display: 'flex',
                duration: 0.1,
            }, 'start')

            this.master.to(content, {
                height: '1px',
                maxHeight: 0,
                paddingTop: '0',
                paddingBottom: '0',
                overflow: 'hidden',
                duration: 0,
            }, 'start')

            this.master.fromTo(content, {
                width: '1px',
                maxWidth: '0%',
            }, {
                id: 'width',
                width: '100%',
                maxWidth: '100%',
                ease: 'sine.inOut',
                yoyoEase: 'sine.in',
                immediateRender: false,
                duration: 0.1,
            }, 'setWidth')

            this.master.fromTo(content, {
                height: '1px',
                maxHeight: 0,
                paddingTop: '0',
                paddingBottom: '0',
            }, {
                height: 'auto',
                maxHeight: '100%',
                paddingTop: '1.618rem',
                paddingBottom: '1.618rem',
                immediateRender: false,
                ease: 'sine.inOut',
                yoyoEase: 'sine.in',
                duration: 0.1,
            }, 'setHeight')

            this.master.fromTo(content, {
                opacity: '0',
            }, {
                opacity: '1',
                ease: 'power4.inOut',
                immediateRender: false,
                duration: 0.2,
            }, 'setInitial')

            this.master.fromTo(head, {
                paddingBottom: '0',
            }, {
                paddingBottom: '1.618rem',
                immediateRender: false,
                duration: 0.3,
            }, 'start')

            this.master.fromTo(parent, {
                paddingBottom: '2rem',
            }, {
                paddingBottom: '1.618rem',
                immediateRender: false,
                duration: 0.1,
            }, 'setHeight+=0.05')

            this.master.fromTo(content, {
                borderWidth: '0',
            }, {
                id: 'boders',
                borderWidth: '3px',
                ease: 'power4.inOut',
                immediateRender: false,
                duration: 0.1,
            }, 'revealFrame')

            this.master.fromTo(content, {
                boxShadow: 'inset 0 0 8px rgba(159, 173, 186, 0)',
            }, {
                boxShadow: 'inset 0 0 8px rgba(159, 173, 186, 0.2)',
                immediateRender: false,
                ease: 'sine.inOut',
                duration: 0.2,
            }, 'revealFrame')

            if (childsVisible) {
                this.master.fromTo(childsVisible, {
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
                        ease: 'sine.in',
                    },
                    ease: 'sine.out',
                    immediateRender: false,
                    duration: 0.15,
                }, 'revealContent')
            }

            this.master.progress(1)
            this.toggleAnim()
        },
    },
}

export default BlockPanelAnimation
