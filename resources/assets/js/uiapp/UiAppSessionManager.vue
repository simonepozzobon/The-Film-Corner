<template>
<ui-container
    :contain="true"
    ref="container"
    class="app-sessions"
>
    <ui-row justify="center">
        <ui-block-head
            class="app-container__list"
            :size="12"
            title="Open Existing Session"
            :color="colorClass"
            :radius="true"
            radius-size="md"
        >
            <transition-group
                tag="div"
                name="app-session-list"
            >
                <ui-app-session
                    v-for="(session, i) in sessions"
                    :key="session.id"
                    :counter="i"
                    :idx="session.id"
                    :title="session.title"
                    :token="session.token"
                    :is-shared="session.teacher_shared"
                    @open-session="openSession"
                    @delete-session="deleteSession"
                    @share-session="shareSession"
                />
            </transition-group>
        </ui-block-head>
    </ui-row>
</ui-container>
</template>

<script>
import UiAppSession from './UiAppSession.vue'
import {
    UiBlock,
    UiBlockHead,
    UiBreadcrumbs,
    UiButton,
    UiContainer,
    UiFolderCorner,
    UiHeroBanner,
    UiList,
    UiListItem,
    UiParagraph,
    UiRow,
    UiSpecialText,
    UiTitle
}
from '../ui'

import {
    TimelineMax,
}
from 'gsap/all'
export default {
    name: 'UiAppSessionManager',
    components: {
        UiAppSession,
        UiBlock,
        UiBlockHead,
        UiBreadcrumbs,
        UiButton,
        UiContainer,
        UiFolderCorner,
        UiHeroBanner,
        UiList,
        UiListItem,
        UiParagraph,
        UiRow,
        UiSpecialText,
        UiTitle
    },
    props: {
        app: {
            type: Object,
            default: function () {
                return {}
            },
        },
        appSessions: {
            type: Array,
            default: function () {
                return []
            },
        },
        open: {
            type: Boolean,
            default: false,
        },
    },
    data: function () {
        return {
            sessions: [],
            master: null,
            colorClass: null,
        }
    },
    watch: {
        app: function (app) {
            this.setDefault()
        },
        appSessions: function (sessions) {
            this.sessions = sessions
        },
        open: function (status) {
            if (status) {
                this.play()
            }
            else {
                this.reverse()
            }
        },
    },
    methods: {
        setDefault: function () {
            this.colorClass = this.app.category.color_class ? this.app.category.color_class : 'gray-dark'
        },
        deleteSession: function (idx) {
            let url = '/api/v2/session/' + idx + '/false'
            this.$http.delete(url)
                .then(response => {
                    if (response.data.success) {
                        this.sessions = this.sessions.filter(session =>
                            session.token != idx)
                    }
                })
        },
        openSession: function (idx) {
            let session = this.sessions.filter(session => session.token == idx)[0]
            session.content = JSON.parse(session.content)
            this.$root.session = session
            this.$root.isOpen = true
            this.$nextTick(() => {
                this.$emit('open-session')
            })
        },
        shareSession: function (token) {
            console.log(token);

            let data = new FormData()
            data.append('token', token)
            this.$root.fullMessage = 'Shared with your teacher'

            this.$http.post('/api/v2/session/share-to-teacher', data).then(response => {
                this.$root.showMessage()
            })
        },
        init: function () {
            this.master = new TimelineMax({
                paused: true,
                yoyo: true
            })
            this.master.fromTo(this.$refs.container.$el, .3, {
                autoAlpha: 0,
                overflow: 'hidden',
                height: 0,
                // className: '-=app-sessions--visible'
            }, {
                autoAlpha: 1,
                height: '100%',
                overflow: 'visible',
                immediateRender: false,
                // className: '+=app-sessions--visible'
            })
            this.master.progress(1).progress(0)
        },
        play: function () {
            if (this.master) {
                this.master.play()
            }
        },
        reverse: function () {
            if (this.master) {
                this.master.reverse()
            }
        }
    },
    mounted: function () {
        this.init()
        this.sessions = this.appSessions
    },
    beforeDestroy: function () {
        if (this.master) {
            this.master.kill()
        }
    }
}
</script>

<style lang="scss">
@import '~styles/shared';

.app-sessions {
    margin-top: $spacer * 1.618;
    margin-bottom: $spacer * 1.618 * 2;
    overflow: hidden;
    transition: $transition-base;

    &--visible {
        transition: $transition-base;
    }
}

.app-session-list-enter-active,
.app-session-list-leave-active {
    transition: $transition-base;
}
.app-session-list-enter,
.app-session-list-leave-to {
    height: 0;
    position: relative;
    overflow: hidden;
    opacity: 0;
}

.app-session-list-enter-active {
    transition-delay: 0.2s;
}
</style>
