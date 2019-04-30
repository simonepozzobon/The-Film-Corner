<template lang="html">
    <div class="ui-breadcrumbs">
        <div class="ui-breadcrumbs__studio">
            <a
                href="#"
                @click="goToStudio"
                class="ui-breadcrumbs__link">
                Studios
            </a>
        </div>
        <div class="ui-breadcrumbs__divider">
            /
        </div>
        <div class="ui-breadcrumbs__pavilion">
            <a
                href="#"
                @click="goToPavilion"
                class="ui-breadcrumbs__link">
                {{ pavilion }}
            </a>
        </div>
        <div class="ui-breadcrumbs__divider">
            /
        </div>
        <div class="ui-breadcrumbs__cat">
            <a
                href="#"
                @click="goToCat"
                class="ui-breadcrumbs__link">
                {{ cat }}
            </a>
        </div>
        <div class="ui-breadcrumbs__divider">
            /
        </div>
        <div class="ui-breadcrumbs__app">
            <span
                class="ui-breadcrumbs__nolink">
                {{ app }}
            </span>
        </div>
    </div>
</template>

<script>
export default {
    name: 'UiBreadcrumbs',
    props: {
        app: {
            type: String,
            default: null,
            required: true,
        },
        appPath: {
            type: String,
            default: null,
            required: true,
        },
        cat: {
            type: String,
            default: null,
            required: true,
        },
        catPath: {
            type: String,
            default: null,
            required: true,
        },
        pavilion: {
            type: String,
            default: null,
            required: true,
        },
        pavilionPath: {
            type: String,
            default: null,
            required: true,
        },
    },
    methods: {
        goToStudio: function(e) {
            e.preventDefault()
            this.$root.goTo('apps-home')
        },
        goToPavilion: function(e) {
            e.preventDefault()
            this.$root.goToWithParams('pavilion-home', { pavilion: this.pavilionPath })
        },
        goToCat: function(e) {
            e.preventDefault()
            this.$root.goToWithParams('cat-home', { cat: this.catPath })
        }
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-breadcrumbs {
    width: 67%;
    padding-left: $spacer * 2;
    padding-bottom: $spacer / 2;

    &__divider,
    &__studio,
    &__pavilion,
    &__cat,
    &__app {
        display: inline-block;
    }

    &__divider {
        padding-right: $spacer / 8;
        padding-left: $spacer / 8;
    }

    &__link {
        color: $black;
        font-weight: 300;
    }

    &__nolink {
        color: $black;
        font-weight: 500;
    }
}
</style>
