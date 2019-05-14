<template lang="html">
    <ui-container>
        <ui-hero-banner :image="image" :full-width="true">
            <ui-container :full-width="true" v-if="this.studio">
                <ui-row align="center">
                    <ui-block :size="4">
                        <ui-title
                            :title="this.studio.name"
                            :uppercase="false"
                            tag="h1"
                            font-size="h1"
                            align="center"
                            color="white"/>
                    </ui-block>
                </ui-row>
                <ui-row
                    justify="center">
                    <ui-block
                        v-for="cat in this.studio.categories"
                        :key="cat.id"
                        :size="4"
                        :color="cat.color_class"
                        :radius="true"
                        :transparent="false"
                        :full-height="true">
                        <ui-title
                            :title="cat.name"
                            size="h4"
                            align="center"
                            :hoverable="true"
                            @click.native="goToCat(cat.slug)"/>
                        <ul
                            class="block-menu"
                            >
                            <li
                                class="block-menu__menu-item"
                                v-for="app in cat.apps"
                                @click="goToApp(app.slug)">
                                {{app.title}}
                            </li>
                        </ul>
                    </ui-block>
                </ui-row>
            </ui-container>
        </ui-hero-banner>
        <ui-container :contain="true" v-if="this.studio">
            <ui-paragraph
                class="pt-5"
                align="justify"
                v-html="studio.description" />
        </ui-container>
    </ui-container>
</template>

<script>
import { UiBlock, UiButton, UiContainer, UiHeroBanner, UiList, UiListItem, UiParagraph, UiRow, UiSpecialText, UiTitle } from '../../ui'
export default {
    name: 'StudioSingle',
    components: {
        UiBlock,
        UiButton,
        UiContainer,
        UiHeroBanner,
        UiList,
        UiListItem,
        UiParagraph,
        UiRow,
        UiSpecialText,
        UiTitle,
    },
    data: function() {
        return {
            slug: null,
            studio: null,
            image: '/img/grafica/bg.jpg',
        }
    },
    methods: {
        getData: function() {
            let slug = this.$route.params.pavilion
            this.$http.get('/api/v2/get-studio/' + slug).then(response => {
                if (response.data.success) {
                    this.studio = response.data.studio
                    console.dir(this.studio);
                    if (this.studio.img) {
                        this.image = this.studio.img
                    }
                }
            })
        },
        goToCat: function(slug) {
            // console.log(slug);
            this.$root.goToWithParams('cat-home', { cat: slug })
        },
        goToApp: function(slug) {
            // console.log(slug);
            this.$root.goToWithParams('app-home', { app: slug })
        }
    },
    created: function() {
        this.getData()
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.block-menu {
    text-align: center;
    list-style-type: none;
    padding-inline-start: 0;
    color: $black;
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

    &__menu-item,
    &__menu-head {
        &:hover {
            text-decoration: underline;
        }
    }
}
</style>
