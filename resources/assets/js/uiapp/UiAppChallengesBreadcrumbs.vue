<template>
<div class="ui-breadcrumbs">
    <div class="ui-breadcrumbs__studio">
        <a
            href="#"
            @click.prevent="goToStudio"
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
            @click.prevent="goToPropaganda"
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
            @click.prevent="goToChallenges"
            class="ui-breadcrumbs__link"
        >
            Creative Challenges
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
    },
    methods: {
        goToStudio: function () {
            this.$root.goTo('apps-home')
        },
        goToPropaganda: function () {
            this.$root.goTo('propaganda-home')
        },
        goToChallenges: function () {
            this.$root.goTo('propaganda-challenges')
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
