<template>
<ui-container
    class="app-container"
    :contain="true"
    v-if="this.app"
>
    <ui-app-folder :app="app" />
    <ui-container
        class="pt-4"
        :contain="true"
    >
        <ui-row :no-gutters="true">
            <ui-block
                :size="left"
                :full-height="true"
            >
                <slot name="left"></slot>
            </ui-block>
            <ui-block
                :size="right"
                :full-height="true"
            >
                <slot name="right"></slot>
            </ui-block>
        </ui-row>
        <slot></slot>
    </ui-container>
</ui-container>
</template>

<script>
import {
    UiBlock,
    UiButton,
    UiContainer,
    UiRow
}
from '../../ui'
import {
    UiAppFolder
}
from '../../uiapp'
export default {
    name: 'AppTemplate',
    components: {
        UiAppFolder,
        UiBlock,
        UiContainer,
        UiRow,
    },
    props: {
        app: {
            type: Object,
            default: function () {},
        },
        left: {
            type: Number,
            default: 8,
        },
        right: {
            type: Number,
            default: 4,
        }
    },
    watch: {
        'app': function (app) {
            // console.log(app);
        }
    },
    created: function () {
        this.$root.isApp = true
    },
    mounted: function () {},
    beforeDestroy: function () {
        this.$root.isApp = false
        // this.$root.session = null
        this.$root.isOpen = false
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.app-container {
    margin-top: $spacer * 5;

    &__row {
        width: 100%;
        height: 100%;
    }
}
</style>
