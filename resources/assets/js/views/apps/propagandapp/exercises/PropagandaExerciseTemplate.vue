<template>
<ui-container>
    <div class="prop-back">
        <div class="prop-back__container">
            <div class="prop-back__content">
                <app-folder
                    :content="content"
                    :clip="clip"
                />
                <ui-container
                    :contain="true"
                    class="prop-back__app-container"
                >
                    <ui-row>
                        <ui-block size="auto">
                            <div class="prop-back__app">
                                <ui-title
                                    title="Scene"
                                    :has-container="false"
                                    :has-margin="false"
                                    :has-padding="false"
                                />
                                <slot name="preview"></slot>
                            </div>
                        </ui-block>
                    </ui-row>
                </ui-container>
                <ui-container
                    :contain="true"
                    class="prop-back__app-container"
                >
                    <ui-row>
                        <ui-block size="auto">
                            <slot></slot>
                        </ui-block>
                    </ui-row>
                </ui-container>
            </div>
        </div>
    </div>
</ui-container>
</template>

<script>
import {
    UiBlock,
    UiContainer,
    UiRow,
    UiTitle,
}
from '../../../../ui'

import AppFolder from '../../../../uiapp/sub/propaganda/AppFolder.vue'


export default {
    name: 'PropagandExerciseTemplate',
    components: {
        AppFolder,
        UiBlock,
        UiContainer,
        UiRow,
        UiTitle,
    },
    props: {
        content: {
            type: Object,
            default: function () {
                return {}
            },
        },
        clip: {
            type: Object,
            default: function () {
                return {}
            },
        },
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.prop-back {
    padding-top: 90px;
    background-image: url("/img/grafica/propaganda/bg-app-80.jpg");
    background-position: top;
    background-size: cover;

    &__container {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    &__content {
        padding: $spacer * 2;
    }

    &__app-container {
        margin-top: $spacer;

    }

    &__app {
        width: 100%;
        height: 100%;
        padding: ($spacer * 2) $spacer * 4;
        background-color: $yellow;
        overflow: hidden;
        @include border-radius(12px);
    }
}
</style>
