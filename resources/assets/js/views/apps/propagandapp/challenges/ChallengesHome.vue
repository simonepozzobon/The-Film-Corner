<template>
<div class="prop-back">
    <div class="prop-back__container">
        <div class="prop-back__content">
            <ui-title
                title="Creative Challenges"
                align="center"
                tag="h1"
                font-size="h1"
            />
            <ui-container :contain="true">
                <ui-row>
                    <ui-block
                        :size="6"
                        :has-container="false"
                    >
                        <div class="prop-chlng-block">
                            <ui-title
                                :title="$root.getCmd('propaganda_ch_film')"
                                align="center"
                                color="white"
                            />

                            <ui-button
                                :title="$root.getCmd('open')"
                                color="yellow"
                                align="center"
                                :block="true"
                                @click="$root.goTo('propaganda-film')"
                            />
                        </div>
                    </ui-block>
                    <!-- <ui-block
                        :size="6"
                        :has-container="false"
                    >
                        <div class="prop-chlng-block">
                            <ui-title
                                title="Role Playing"
                                align="center"
                                color="white"
                            />
                            <ui-button
                                title="go"
                                color="yellow"
                                align="center"
                                :block="true"
                                @click="$root.goTo('propaganda-role-playing')"
                            />
                        </div>
                    </ui-block> -->
                    <ui-block
                        :size="6"
                        :has-container="false"
                    >
                        <div class="prop-chlng-block">
                            <ui-title
                                :title="$root.getCmd('propaganda_ch_interview')"
                                align="center"
                                color="white"
                            />
                            <ui-button
                                :title="$root.getCmd('open')"
                                color="yellow"
                                align="center"
                                :block="true"
                                @click="$root.goTo('propaganda-interview')"
                            />
                        </div>
                    </ui-block>
                    <ui-block
                        :size="6"
                        :has-container="false"
                    >
                        <div class="prop-chlng-block">
                            <ui-title
                                :title="$root.getCmd('propaganda_ch_affiche')"
                                align="center"
                                color="white"
                            />
                            <ui-button
                                :title="$root.getCmd('open')"
                                color="yellow"
                                align="center"
                                :block="true"
                                @click="
                                        $root.goTo('propaganda-your-affiches')
                                    "
                            />
                        </div>
                    </ui-block>
                </ui-row>
                <ui-button
                    :title="$root.getCmd('back')"
                    align="center"
                    color="yellow"
                    @click="$root.goTo('propaganda-home')"
                />
            </ui-container>
        </div>
    </div>
</div>
</template>

<script>
import {
    UiBlock,
    UiButton,
    UiContainer,
    UiRow,
    UiTitle
}
from "../../../../ui";
export default {
    name: "ChallengesHome",
    components: {
        UiBlock,
        UiButton,
        UiContainer,
        UiRow,
        UiTitle
    },
    methods: {
        getData: function () {}
    },
    created: function () {
        this.getData();
    }
};
</script>

<style lang="scss" scoped>
@import "~styles/shared";
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

.prop-chlng-block {
    padding: $spacer * 2;
    background-color: $dark-gray;
    @include border-radius(12px);
    margin-bottom: $spacer * 2;
}
</style>
