<template>
<div class="ui-breadcrumbs">
    <div class="ui-breadcrumbs__studio">
        <a
            href="#"
            @click.stop.prevent="goToStudio"
            class="ui-breadcrumbs__link"
        >
            Studios
        </a>
    </div>
    <div class="ui-breadcrumbs__divider">
        /
    </div>
    <div class="ui-breadcrumbs__pavilion">
        <a
            href="#"
            @click.stop.prevent="goToPropaganda"
            class="ui-breadcrumbs__link"
        >
            Propagandapp
        </a>
    </div>
    <div class="ui-breadcrumbs__divider">
        /
    </div>
    <div class="ui-breadcrumbs__cat">
        <a
            href="#"
            @click.stop.prevent="goToClip"
            class="ui-breadcrumbs__link"
        >
            {{ clipName }}
        </a>
    </div>
    <div class="ui-breadcrumbs__divider">
        /
    </div>
    <div class="ui-breadcrumbs__app">
        <span class="ui-breadcrumbs__nolink">
            {{ app }}
        </span>
    </div>
</div>
</template>

<script>
export default {
    name: 'UiAppPropagandaBreadcrumbs',
    props: {
        app: {
            type: String,
            default: null,
            required: true,
        },
        clipName: {
            type: String,
            default: 'Exercises',
        },
        clipId: {
            type: Number,
            default: 0,
        }
    },
    methods: {
        goToStudio: function () {
            this.$root.goTo('apps-home')
        },
        goToPropaganda: function () {
            this.$root.goTo('propaganda-home')
        },
        goToClip: function () {
            this.$root.goToWithParams('propaganda-single', {
                id: this.clipId
            })
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

    &__app,
    &__cat,
    &__divider,
    &__pavilion,
    &__studio {
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
