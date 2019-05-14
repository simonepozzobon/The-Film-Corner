<template lang="html">
    <ui-container
        :contain="true"
        class="net-content"
        :class="colorClass">
        <ui-row
            ref="row">
            <ui-block
                v-if="this.notes && this.notes != ''"
                class="net-content__col"
                :size="colSize"
                :radius="true">
                <div class="net-content__head">
                    <ui-title
                        title="Notes"
                        :color="titleColor"
                        align="center"/>
                </div>
                <div class="net-content__content">
                    {{ notes }} {{ colSize }}
                </div>
            </ui-block>
            <ui-block
                class="net-content__col"
                :size="colSize"
                :radius="true">
                <div class="net-content__head">
                    <ui-title
                        title="Join The Discussion"
                        :color="titleColor"
                        align="center"/>
                </div>
                <div class="net-content__content">
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
                </div>
            </ui-block>
        </ui-row>
    </ui-container>
</template>

<script>
import { UiBlock, UiContainer, UiRow, UiTitle  } from '../ui'

export default {
    name: 'NetContent',
    components: {
        UiBlock,
        UiContainer,
        UiRow,
        UiTitle,
    },
    props: {
        hasComments: {
            type: Boolean,
            default: true,
        },
        color: {
            type: String,
            default: 'green',
        },
        notes: {
            type: String,
            default: null,
        },
    },
    computed: {
        colSize: function() {
            if (this.hasComments && this.notes != '') {
                return 6
            }
            else {
                return 12
            }
        },
        colorClass: function() {
            return 'net-content--' + this.color
        },
        titleColor: function() {
            if (this.color == 'yellow')
                return 'dark'

            return 'white'
        },
    },
    methods: {
        debug: function() {
            TweenMax.to(window, .2, {
                scrollTo: this.$refs.row.$el
            })
        },
    },
    mounted: function() {
        this.debug()
    },
}
</script>

<style lang="scss">
@import '~styles/shared';

.net-content {
    margin-top: $spacer * 1.618;

    &__head {
        width: 100%;
        text-align: center;
        @include border-radius(10px);
    }

    &__content {
        padding: $spacer * 1.618;
    }

    &--green & {
        &__col {
            .ui-block__container {
                background-color: lighten($green, 25) !important;
            }
        }
        &__head {
            background-color: $green;
        }
    }

    &--yellow & {
        &__col {
            .ui-block__container {
                background-color: lighten($yellow, 25) !important;
            }
        }
        &__head {
            background-color: $yellow;
        }
    }
}
</style>
