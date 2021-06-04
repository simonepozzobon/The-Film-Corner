<template>
    <ui-container>
        <ui-hero-banner image="/img/grafica/bg.jpg">
            <ui-container :full-width="true">
                <ui-title
                    tag="h1"
                    font-size="h1"
                    :is-main="true"
                    :uppercase="false"
                    title="The Film Corner International Online Conference"
                    color="white"
                />
            </ui-container>
        </ui-hero-banner>
        <ui-container class="py-5" :contain="true">
            <div v-if="content" v-html="translateContent"></div>
            <div
                v-else
                class="d-flex justify-content-center align-items-center w-100"
            >
                <span
                    class="spinner-border spinner-border-xl text-green w-16 h-16"
                    ref="spinner"
                    role="status"
                    aria-hidden="true"
                ></span>
            </div>
        </ui-container>
    </ui-container>
</template>
<script>
import {
    UiBlock,
    UiContainer,
    UiHeroBanner,
    UiImage,
    UiList,
    UiListItem,
    UiParagraph,
    UiRow,
    UiTeam,
    UiTitle
} from "../ui";

import TranslationFilter from "../TranslationFilter";

export default {
    name: "ConferenceOnline",
    mixins: [TranslationFilter],
    components: {
        UiBlock,
        UiContainer,
        UiHeroBanner,
        UiImage,
        UiList,
        UiListItem,
        UiParagraph,
        UiRow,
        UiTeam,
        UiTitle
    },
    data: function() {
        return {
            content: null
        };
    },
    computed: {
        translateContent: function() {
            return this.$options.filters.translate(
                this.content,
                "content",
                this.$root.locale
            );
        }
    },
    methods: {
        getData: function() {
            this.$http.get("/api/v2/conference").then(response => {
                this.content = response.data.text;
            });
        }
    },
    created: function() {
        this.getData();
    }
};
</script>
<style lang="scss"></style>
