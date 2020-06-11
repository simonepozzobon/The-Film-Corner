<template>
    <nav
        class="network-nav navbar navbar-dark navbar-expand-lg fixed-top"
        ref="menu"
    >
        <ul class="navbar-nav network-nav__nav">
            <li class="network-nav__item nav-item">
                <a
                    href="#"
                    @click.stop.prevent="sortByDate"
                    class="nav-link network-nav__link"
                    >{{ this.$root.getCmd("most_recent") }}</a
                >
            </li>
            <li class="network-nav__item nav-item">
                <a
                    href="#"
                    @click.stop.prevent="sortByLikes"
                    class="nav-link network-nav__link"
                    >{{ this.$root.getCmd("most_liked") }}</a
                >
            </li>
            <li class="network-nav__item nav-item">
                <a
                    href="#"
                    @click.stop.prevent="sortByApp"
                    class="nav-link network-nav__link"
                    >{{ this.$root.getCmd("filter_by_app") }}</a
                >
            </li>
        </ul>
    </nav>
</template>

<script>
import { TweenMax } from "gsap/all";

export default {
    name: "NetworkNav",
    methods: {
        goTo: function(event, name) {
            event.preventDefault();
            this.$router.push({
                name: name
            });
        },
        show: function() {
            let master = TweenMax.fromTo(
                this.$refs.menu,
                0.5,
                {
                    y: -150,
                    autoAlpha: 0
                },
                {
                    y: 0,
                    autoAlpha: 1,
                    onComplete: () => {
                        master.kill();
                    }
                }
            );
        },
        hide: function() {
            let master = TweenMax.fromTo(
                this.$refs.menu,
                0.5,
                {
                    y: 0,
                    autoAlpha: 1
                },
                {
                    y: -150,
                    autoAlpha: 0,
                    onComplete: () => {
                        master.kill();
                    }
                }
            );
        },
        sortByDate: function() {
            this.$root.$emit("sort-by-date");
        },
        sortByLikes: function() {
            this.$root.$emit("sort-by-likes");
        },
        sortByApp: function() {
            this.$root.$emit("sort-by-app");
        }
    },
    mounted: function() {
        this.show();
    },
    beforeDestroy: function() {
        this.hide();
    }
};
</script>

<style lang="scss" scoped>
@import "~styles/shared";

.network-nav {
    top: 107px;
    height: 48px;
    z-index: $zindex-fixed - 2;
    background-color: $dark-gray;

    &__nav {
        margin-left: auto;
        margin-right: $spacer * 2;
    }

    &__link {
        text-transform: uppercase;
        font-size: $font-size-sm;
        font-weight: $font-weight-bold;
        color: $white !important;

        &.disabled {
            color: rgba($white, 0.6) !important;
        }
    }
}
</style>
