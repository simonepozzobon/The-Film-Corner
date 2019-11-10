<template>
<div
    ref="container"
    class="pro-activity"
    :class="[
            colorClass,
        ]"
    @mouseover="showHover"
    @mouseleave="hideHover"
>
    <div class="pro-activity__container">
        <div class="pro-activity__icon">
            <div class="pro-activity__figure">
                <i class="fa fa-exclamation"></i>
            </div>
        </div>
        <div class="pro-activity__icon">
            <div class="pro-activity__figure">
                <i class="fa fa-eye"></i>
            </div>
        </div>
        <div class="pro-activity__name">
            {{ name }}&nbsp;
        </div>
        <div class="pro-activity__app">
            - {{ app }}
        </div>
        <div class="pro-activity__app">
            - {{ senderName }}
        </div>
        <div class="pro-activity__delete">
            <ui-button
                title="open"
                color="black"
                size="sm"
                :has-margin="false"
                display="inline-block"
                @click="openSession"
            />
            <ui-button
                title="delete"
                color="black"
                size="sm"
                :has-margin="false"
                display="inline-block"
                @click="deleteActivity"
            />
        </div>
    </div>
</div>
</template>

<script>
import {
    UiButton
}
from '../ui'
import Utility from '../Utilities'

import {
    TimelineMax,

}
from 'gsap/all'

export default {
    name: 'ProActivity',
    components: {
        UiButton,
    },
    props: {
        idx: {
            type: String,
            default: 'no-idx',
        },
        counter: {
            type: Number,
            default: 0,
        },
        // name: {
        //     type: String,
        //     default: 'name',
        // },
        // app: {
        //     type: String,
        //     default: 'app',
        // },
        activity: {
            type: Object,
            default: function () {
                return {}
            },
        },
    },
    data: function () {
        return {
            selected: false,
        }
    },
    computed: {
        colorClass: function () {
            let odd = Boolean((this.counter) % 2)

            if (odd) {
                return 'pro-activity--light'
            }
        },
        isOdd: function () {
            return Boolean((this.counter) % 2)
        },
        name: function () {
            if (this.activity.data && this.activity.data.session) {
                if (this.activity.data.session.title) {
                    return this.activity.data.session.title
                }
            }
            return 'no title'
        },
        app: function () {
            if (this.activity.data && this.activity.data.session) {
                if (this.activity.data.session.app.title) {
                    return this.activity.data.session.app.title
                }
            }
            return 'no name'
        },
        senderName: function () {
            if (this.activity.data && this.activity.data.sender) {
                if (this.activity.data.sender.name) {
                    return this.activity.data.sender.name
                }
            }
            return null
        },
    },
    methods: {
        init: function () {
            let el = this.$refs.container
            let gray = getComputedStyle(document.documentElement).getPropertyValue('--gray-dark')
            let rgbaObj = Utility.hexToRgbA(gray)
            let rgba = 'rgba(' + rgbaObj.r + ',' + rgbaObj.g + ',' + rgbaObj.a + ', .18)'
            let transparent = 'rgba(' + rgbaObj.r + ',' + rgbaObj.g + ',' + rgbaObj.a + ', 0)'

            if (this.isOdd) {
                let white = getComputedStyle(document.documentElement).getPropertyValue('--white')
                rgbaObj = Utility.hexToRgbA(white)
                transparent = 'rgba(' + rgbaObj.r + ',' + rgbaObj.g + ',' + rgbaObj.a + ', .28)'
            }

            this.master = new TimelineMax({
                paused: true,
                yoyo: true
            })

            this.master.fromTo(el, .3, {
                backgroundColor: transparent
            }, {
                backgroundColor: rgba,
            })

            this.master.progress(1).progress(0)
        },
        showHover: function () {
            if (this.master) {
                this.master.play()
            }
        },
        hideHover: function () {
            if (this.master) {
                this.master.reverse()
            }
        },
        deleteActivity: function () {
            this.$emit('delete-activity', this.activity.id)
        },
        openSession: function () {
            let session = this.activity.data.session
            // console.log(session);
            session.content = JSON.parse(session.content)

            let appSlug = this.activity.data.session.app.slug

            this.$root.session = session
            this.$root.isOpen = true
            this.$root.isTeacherCheck = true
            this.$root.notificationId = this.activity.id

            // console.log(session, this.activity);

            this.$root.goTo(appSlug)
        },
    },
    mounted: function () {
        this.$nextTick(() => {
            this.init()
        })
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.pro-activity {
    width: 100%;
    padding: $spacer * 1.618 / 2 $spacer * 1.618;

    &__container {
        display: flex;
        align-items: center;
        justify-content: flex-start;
    }

    &__title {
        font-weight: 600;
        text-transform: capitalize;
    }

    &__info {
        text-transform: capitalize;
    }

    &__tools {
        display: flex;
        align-items: center;
    }

    &__icon {
        display: flex;
        align-items: center;
        padding-right: $spacer * 1.618 / 2;
    }

    &__delete {
        margin-left: auto;
    }

    &__figure {
        font-size: $h6-font-size;
        color: $black;
        line-height: 1;
    }

    &--light {
        background-color: rgba($white, .28);
    }
}
</style>
