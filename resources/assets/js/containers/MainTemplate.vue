<template>
    <main class="main" :class="paddingClass">
        <main-nav></main-nav>
        <full-screen-message />
        <div class="main__content">
            <router-view></router-view>

            <div class="cookies-modal" v-if="hasCookieBanner">
                <div class="cookies-modal__container">
                    <ui-title title="Cookies and privacy" />
                    <ui-paragraph :has-padding="false">
                        We use cookies and similar methods to recognize visitors
                        and remember their preferences. We also use them to
                        measure ad campaign effectiveness, target ads and
                        analyze site traffic. To learn more about these methods,
                        including how to disable them, view our
                        <a href="/cookies">Cookie Policy</a>. Starting on July
                        20, 2020 we will show you ads we think are relevant to
                        your interests, based on the kinds of content you access
                        in our Services. For more info, see our privacy policy.
                        By tapping ‘accept,’ you consent to the use of these
                        methods by us and third parties. You can always change
                        your tracker preferences by visiting our
                        <a href="/cookies">Cookie Policy</a>.
                    </ui-paragraph>
                    <ui-button color="yellow" @click="closeCookieModal">
                        Accept
                    </ui-button>
                </div>
            </div>
        </div>
    </main>
</template>

<script>
import { gsap } from "gsap/all";
import FullScreenMessage from "./FullScreenMessage.vue";
import MainNav from "./MainNav.vue";
import { UiButton, UiTitle, UiParagraph } from "../ui";

export default {
    name: "MainTemplate",
    components: {
        FullScreenMessage,
        MainNav,
        UiButton,
        UiTitle,
        UiParagraph
    },
    data: function() {
        return {
            paddingClass: null,
            hasCookieBanner: false
        };
    },
    watch: {
        "$root.space": function(value) {
            this.setPadding();
        }
    },
    methods: {
        checkCookies: function() {
            let cookies = this.$cookie.get("tfc-cookies-accepted");
            if (cookies == "1" || cookies) {
                this.hasCookieBanner = false;
            } else {
                this.hasCookieBanner = true;
            }
        },
        setPadding: function() {
            this.checkCookies();
            if (!this.$root.space) {
                this.paddingClass = "main--no-padding";
            } else {
                this.paddingClass = null;
            }
        },
        closeCookieModal: function() {
            this.$cookie.set("tfc-cookies-accepted", 1);
            this.hasCookieBanner = false;
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
            padding: $spacer * 2;
            @include border-radius(5px);
            border: 2px solid $yellow;
            width: 100%;
            margin: $spacer;

            @include media-breakpoint-up(md) {
                width: 80%;
            }
        }
    }
}
</style>
