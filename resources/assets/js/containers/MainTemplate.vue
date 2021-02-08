<template>
    <main class="main" :class="paddingClass">
        <main-nav></main-nav>
        <full-screen-message />
        <div class="main__content">
            <router-view></router-view>

            <!-- <div class="cookies-modal">
                <div class="cookies-modal__container">
                    <ui-title title="Cookies and privacy" />

                </div>
            </div> -->
        </div>
    </main>
</template>

<script>
import { gsap } from "gsap/all";
import FullScreenMessage from "./FullScreenMessage.vue";
import MainNav from "./MainNav.vue";
import { UiTitle } from "../ui";

export default {
    name: "MainTemplate",
    components: {
        FullScreenMessage,
        MainNav,
        UiTitle
    },
    data: function() {
        return {
            paddingClass: null
        };
    },
    watch: {
        "$root.space": function(value) {
            this.setPadding();
        }
    },
    methods: {
        setPadding: function() {
            if (!this.$root.space) {
                this.paddingClass = "main--no-padding";
            } else {
                this.paddingClass = null;
            }
        }
        // conferenceMenuEnter: function(el, done) {
        //     TweenMax.fromTo(el, .5, {
        //         y: -100,
        //         autoAlpha: 0,
        //     }, {
        //         y: 0,
        //         autoAlpha: 1,
        //         onComplete: () => {
        //             done()
        //         }
        //     })
        // },
        // conferenceMenuLeave: function (el, done) {
        //     TweenMax.fromTo(el, .5, {
        //         y: 0,
        //         autoAlpha: 1,
        //     }, {
        //         y: -100,
        //         autoAlpha: 0,
        //         onComplete: () => {
        //             done()
        //         }
        //     })
        // }
    },
    mounted: function() {
        this.$nextTick(this.setPadding);
    }
};
</script>

<style lang="scss" scoped>
@import "~styles/shared";
.main {
    &__content {
        padding-top: 60px;
    }

    &--no-padding {
        padding-bottom: 0;
    }

    .cookies-modal {
        position: fixed;
        bottom: $spacer;
        left: 0;
        right: 0;
        display: flex;
        justify-content: center;
        z-index: 10000;

        &__container {
            background-color: $white;
            padding: $spacer;
            @include border-radius(5px);
        }
    }
}
</style>
