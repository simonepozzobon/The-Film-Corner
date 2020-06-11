<template>
    <ui-container>
        <ui-hero-banner
            image="/img/grafica/propaganda/bg-home-80.jpg"
            :full-width="true"
        >
            <ui-row align="center" ver-align="center">
                <ui-block size="8">
                    <ui-title
                        color="white"
                        font-size="h1"
                        align="center"
                        :uppercase="true"
                        :has-container="false"
                    >
                        Propagand<span class="text-red">app</span>
                    </ui-title>

                    <ui-title
                        :title="$root.getCmd('the_project')"
                        color="white"
                        font-size="h4"
                        align="center"
                        :uppercase="true"
                        :has-container="false"
                    />

                    <ui-paragraph
                        color="white"
                        align="center"
                        size="lg"
                        v-html="catDescription"
                    />

                    <ui-button color="red" @click="goToHome">
                        {{ this.$root.getCmd("enter") }}
                    </ui-button>
                </ui-block>
            </ui-row>
        </ui-hero-banner>
    </ui-container>
</template>

<script>
import {
    UiBlock,
    UiButton,
    UiContainer,
    UiHeroBanner,
    UiHeroImage,
    UiLink,
    UiParagraph,
    UiSpecialText,
    UiTitle,
    UiRow
} from "../../../ui";

import TranslationFilter from "../../../TranslationFilter";

export default {
    name: "PropagandaIntro",
    mixins: [TranslationFilter],
    components: {
        UiBlock,
        UiButton,
        UiContainer,
        UiHeroBanner,
        UiHeroImage,
        UiLink,
        UiParagraph,
        UiSpecialText,
        UiTitle,
        UiRow
    },
    data: function() {
        return {
            cat: null
        };
    },
    computed: {
        catTitle: function() {
            if (this.cat) {
                return this.$options.filters.translate(
                    this.cat,
                    "name",
                    this.$root.locale
                );
            }
            return null;
        },
        catDescription: function() {
            if (this.cat) {
                return this.$options.filters.translate(
                    this.cat,
                    "description",
                    this.$root.locale
                );
            }
            return null;
        }
    },
    methods: {
        goToHome: function() {
            this.$root.goTo("propaganda-home");
        },
        leave: function() {},
        getData: function() {
            this.$http.get("/api/v2/get-cat/propagandapp").then(response => {
                if (response.data.success) {
                    this.cat = response.data.pavilion;
                    if (this.cat.img) {
                        this.image = this.cat.img;
                    }
                }
            });
        }
    },
    created: function() {
        this.getData();
    }
};
</script>

<style lang="scss" scoped>
@import "~styles/shared";
</style>
