import {
    gsap,
}
from 'gsap/'

import {
    CSSPlugin
}
from 'gsap/CSSPlugin'

import {
    GSDevTools
}
from 'gsap/GSDevTools'

gsap.registerPlugin(CSSPlugin, GSDevTools)

const ParatextAnimation = {
    computed: {
        uuid: function () {
            return this.$util.uuid()
        },
    },
    methods: {
        initAnim: function () {
            let container = this.$refs.container
            let content = this.$refs.element
            this.master = gsap.timeline({
                paused: true,
                yoyo: true,
            })

            this.master.addLabel('start', 0)
            this.master.addLabel('setInitial', 'start')
            this.master.addLabel('setWidth', 'start+=0.1')
            this.master.addLabel('setHeight', 'start+=0.2')
            this.master.addLabel('revealFrame', 'start+=0.35')

            this.master.fromTo(content, .1, {
                    display: 'none',
                }, {
                    display: 'block'
                }, 'start')
                .to(container, .05, {
                    display: 'flex',
                    opacity: '0',
                    marginBottom: '0rem',
                }, 'start')

                .to(content, .05, {
                    height: '1px',
                    paddingTop: '0',
                    paddingBottom: '0',
                    opacity: '0',
                    overflow: 'hidden',
                    boxShadow: '1px 1px 1px 0 rgba(59, 66, 72, 0), 1px 1px 1px 0 rgba(59, 66, 72, 0)',
                }, 'start')

                .fromTo(content, 0.1, {
                    width: '1px',
                    maxWidth: '0%',
                }, {
                    id: 'width',
                    width: '100%',
                    maxWidth: '100%',
                    ease: 'sine.inOut',
                    yoyoEase: 'sine.in',
                    immediateRender: false,
                }, 'setWidth')

                .fromTo(content, .1, {
                    height: '1px',
                    paddingTop: '0',
                    paddingBottom: '0',
                }, {
                    id: 'height',
                    height: '100%',
                    paddingTop: '0.5rem',
                    paddingBottom: '2rem',
                    immediateRender: false,
                    ease: 'sine.inOut',
                    yoyoEase: 'sine.in',
                }, 'setHeight')

                .fromTo(content, .3, {
                    opacity: '0',
                }, {
                    opacity: '1',
                    ease: 'sine.inOut',
                    immediateRender: false,
                }, 'start')

                .fromTo(container, .3, {
                    opacity: '0',
                }, {
                    opacity: '1',
                    ease: 'sine.inOut',
                    immediateRender: false,
                }, 'start')


                .fromTo(container, .1, {
                    marginBottom: '0rem',
                }, {
                    marginBottom: '2.5rem',
                    immediateRender: false,
                }, 'setHeight')

                .fromTo(content, .2, {
                    boxShadow: '2px 4px 12px 0 rgba(59, 66, 72, 0), 4px 8px 24px 0 rgba(59, 66, 72, 0)',
                }, {
                    boxShadow: '2px 4px 12px 0 rgba(59, 66, 72, 0.04), 4px 8px 24px 0 rgba(59, 66, 72, 0.02)',
                    immediateRender: false,
                    ease: 'power0.none',
                }, 'revealFrame')

            this.master.progress(1).progress(0)

            this.$nextTick(() => {
                this.master.play()
            })
        },
    }
}

export default ParatextAnimation
