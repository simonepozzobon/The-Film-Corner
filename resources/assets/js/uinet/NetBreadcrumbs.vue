<template lang="html">
    <div class="net-breadcrumbs">
        <div class="net-breadcrumbs__studio">
            <a
                href="#"
                @click="$root.goTo('network-home')"
                class="net-breadcrumbs__link">
                Network
            </a>
        </div>
        <div class="net-breadcrumbs__divider">
            /
        </div>
        <div class="net-breadcrumbs__cat">
            <a
                href="#"
                @click="$root.goTo('network-home')"
                class="net-breadcrumbs__link">
                {{ cat }}
            </a>
        </div>
        <div class="net-breadcrumbs__divider">
            /
        </div>
        <div class="net-breadcrumbs__app">
            <a
                href="#"
                @click="$root.goTo('network-home')"
                class="net-breadcrumbs__nolink">
                {{ app }}
            </a>
        </div>
    </div>
</template>

<script>
export default {
    name: 'UiBreadcrumbs',
    props: {
        app: {
            type: String,
            default: 'Parallel Action',
            // required: true,
        },
        appPath: {
            type: String,
            default: null,
            // required: true,
        },
        cat: {
            type: String,
            default: 'Editing',
            // required: true,
        },
        catPath: {
            type: String,
            default: null,
            // required: true,
        },
    },
    methods: {
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.net-breadcrumbs {
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
