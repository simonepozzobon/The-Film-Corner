<template lang="html">
    <ui-row :no-gutters="true">
        <ui-block :size="size">
            <div
                class="ui-app-block"
                :class="[
                    colorClass
                ]">

                <ui-title
                    v-if="hasTitle"
                    :title="title"
                    :has-padding="false"
                    :color="titleColor"/>

                <div class="ui-app-block__field">
                    <slot></slot>
                </div>
            </div>
        </ui-block>
    </ui-row>
</template>

<script>
import { UiBlock, UiTitle, UiRow } from '../ui'
export default {
    name: 'UiAppBlock',
    components: {
        UiBlock,
        UiTitle,
        UiRow,
    },
    props: {
        hasTitle: {
            type: Boolean,
            default: true,
        },
        title: {
            type: String,
            default: 'title',
        },
        size: {
            type: Number,
            default: 12,
        },
        color: {
            type: String,
            default: 'green'
        },
        titleColor: {
            type: String,
            default: null,
        }
    },
    computed: {
        colorClass: function() {
            if (this.color != 'green') {
                return 'ui-app-block--' + this.color
            }
        }
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-app-block {
    width: 100%;
    height: 100%;
    background-color: $green;
    @include border-radius($custom-border-radius);
    @include app-block-padding;

    &__text {
        @include border-radius(10px);
    }

    &--dark {
        background-color: $dark-gray;
    }
}
</style>
