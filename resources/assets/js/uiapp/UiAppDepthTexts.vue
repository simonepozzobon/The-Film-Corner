<template>
    <div class="ua-depth">
        <div class="ua-depth__top">
            <ui-title
                :title="$root.getCmd('in_depth_texts')"
                :has-container="false"
            />
        </div>
        <div class="ua-depth__center">
            <sub-single
                v-for="sub in subs"
                :key="sub.idx"
                :idx="sub.idx"
                :sub="sub"
                :has-children="sub.hasChildren"
                :childrens="sub.paratext"
                @open-modal="openModal"
            />
        </div>
        <div class="ua-depth__bottom">
            <ui-button color="light-gray" :disable="true" class="d-none">
                Download all content
            </ui-button>
        </div>
    </div>
</template>

<script>
import SubSingle from "./sub/propaganda/SubSingle.vue";

import { UiButton, UiTitle } from "../ui";

export default {
    name: "UiAppDepthTexts",
    components: {
        SubSingle,
        UiButton,
        UiTitle
    },
    props: {
        subs: {
            type: Array,
            default: function() {
                return [];
            }
        }
    },
    data: function() {
        return {};
    },
    methods: {
        openModal: function(idx, subId = null) {
            this.$emit("open-modal", idx, subId);
        }
    },
    mounted: function() {
        // console.log(this.subs);
    }
};
</script>

<style lang="scss" scoped>
@import "~styles/shared";

.ua-depth {
    width: 100%;
    height: 100%;
    background-color: $yellow;
    overflow: hidden;
    @include border-radius(12px);
    padding: $spacer $app-padding-x;
    display: flex;
    flex-direction: column;

    &__top {
    }

    &__bottom {
        margin-top: auto;
        display: flex;
        justify-content: center;
        align-items: center;
    }
}
</style>
