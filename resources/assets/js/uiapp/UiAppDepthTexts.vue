<template>
<div class="ua-depth">
    <div class="ua-depth__top">
        <ui-title
            title="In-depth texts"
            :has-container="false"
        />
    </div>
    <div class="ua-depth__center">
        <sub-single
            v-for="sub in subs"
            :key="sub.id"
            :title="sub.title"
            :has-children="sub.hasChildren"
            :childrens="sub.childrens"
        />
    </div>
    <div class="ua-depth__bottom">
        <ui-button color="light-gray">
            Download all content
        </ui-button>
    </div>
</div>
</template>

<script>
import {
    subsTexts
}
from '../dummies/PropagandAppContent'

import SubSingle from './sub/propaganda/SubSingle.vue'

import {
    UiButton,
    UiTitle,
}
from '../ui'

export default {
    name: 'UiAppDepthTexts',
    components: {
        SubSingle,
        UiButton,
        UiTitle,
    },
    data: function () {
        return {
            subs: subsTexts
        }
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ua-depth {
    width: 100%;
    height: 100%;
    background-color: $yellow;
    overflow: hidden;
    @include border-radius(12px);
    padding: $spacer $app-padding-x;
    display: flex;
    flex-direction: column;

    &__top {}

    &__bottom {
        margin-top: auto;
        display: flex;
        justify-content: center;
        align-items: center;
    }
}
</style>
