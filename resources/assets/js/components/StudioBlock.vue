<template>
    <ui-block
        :size="4"
        :color="studio.color_class"
        :radius="true"
        :transparent="true"
        :full-height="true"
    >
        <ui-title
            :title="nameTranslated"
            align="center"
            size="h4"
            color="white"
            :hoverable="true"
            :x-padding="true"
            @click.native="goToPavilion($event, studio.slug)"
        />

        <div v-if="studio.slug == 'cultural-approach'">
            <ul class="block-menu block-menu--var" v-if="curlturalApproach">
                <li
                    class="block-menu__menu-head"
                    @click="goToPropaganda(studio.slug)"
                >
                    Propagand<b>app</b>
                </li>
                <li
                    class="block-menu__menu-item"
                    @click="goToPropaganda(studio.slug)"
                >
                    Go to the challenges
                </li>
            </ul>
            <ul class="block-menu block-menu--var" v-else>
                <li class="block-menu__menu-head">Propagand<b>app</b></li>
                <li>
                    Under Construction
                </li>
            </ul>
            <ul class="block-menu block-menu--var" v-if="artApp">
                <li class="block-menu__menu-head">Art<b>app</b></li>
                <li>
                    Go to the challenges
                </li>
            </ul>
            <ul class="block-menu block-menu--var" v-else>
                <li class="block-menu__menu-head">Art<b>app</b></li>
                <li>
                    Under Construction
                </li>
            </ul>
        </div>

        <div v-else>
            <div v-for="cat in studio.categories">
                <ul class="block-menu" v-if="cat.active == 1">
                    <li
                        class="block-menu__menu-head"
                        @click="goToCat(cat.slug)"
                    >
                        {{ cat | translate("name", $root.locale) }}
                    </li>
                    <studio-block-app-loop :apps="cat.apps" />
                </ul>
            </div>
        </div>
    </ui-block>
</template>

<script>
import { UiBlock, UiTitle } from "../ui";
import StudioBlockAppLoop from "./StudioBlockAppLoop.vue";
import TranslationFilter from "../TranslationFilter";

export default {
    name: "StudioBlock",
    mixins: [TranslationFilter],
    components: {
        UiBlock,
        UiTitle,
        StudioBlockAppLoop
    },
    props: {
        studio: {
            type: Object,
            default: function() {
                return {};
            }
        }
    },
    data: function() {
        return {
            name: null,
            curlturalApproach: true,
            artApp: false
        };
    },
    watch: {
        "$root.locale": function(locale) {}
    },
    computed: {
        nameTranslated: function() {
            // return this.$translations.getContent(this.studio.name, 'name', 'sections')
            return this.$options.filters.translate(
                this.studio,
                "name",
                this.$root.locale
            );
        }
    },
    methods: {
        goToPavilion: function(event, slug) {
            event.preventDefault();
            if (slug != "cultural-approach") {
                this.$root.goToWithParams("pavilion-home", {
                    pavilion: slug
                });
            }
        },
        goToCat: function(slug) {
            this.$root.goToWithParams("cat-home", {
                cat: slug
            });
        },
        goToApp: function(slug) {
            this.$root.goToWithParams("app-home", {
                app: slug
            });
        },
        goToPropaganda: function(slug) {
            this.$root.goTo("propaganda-intro");
        }
    }
};
</script>

<style lang="scss" scoped>
@import "~styles/shared";
.block-menu {
    text-align: center;
    list-style-type: none;
    padding-inline-start: 0;
    color: $white;
    font-size: $font-size-base;

    &__menu-item {
        cursor: pointer;
    }

    &__menu-div {
        margin-bottom: $spacer;
    }

    &__menu-head {
        font-weight: $font-weight-bold;
        cursor: pointer;
    }

    &__menu-head,
    &__menu-item {
        &:hover {
            text-decoration: underline;
        }
    }

    &--var & {
        &__menu-head {
            font-weight: 600;
        }
    }
}
</style>
