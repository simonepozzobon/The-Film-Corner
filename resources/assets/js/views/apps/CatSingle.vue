<template lang="html">
    <ui-container>
        <ui-hero-banner :image="this.image" :full-width="true">
            <ui-container :full-width="true" v-if="this.cat">
                <ui-row align="center">
                    <ui-block :size="4">
                        <ui-title
                            :title="this.cat.name"
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
                        v-for="app in this.cat.apps"
                        :key="app.id"
                        :size="4"
                        :color="cat.color_class"
                        :radius="true"
                        :transparent="false"
                        :full-height="true"
                        align="center">
                        <ui-title
                            :title="app.title"
                            color="black"
                            size="h4"
                            align="center"
                            @click.native="goToApp(app.slug)"/>

                        <ui-paragraph align="center" v-html="shortDescription(app.description)">
                        </ui-paragraph>
                        <div>
                            <ui-button color="black" display="inline-block" :has-container="false" @click.native="goToApp(app.slug)">Read More</ui-button>
                            <ui-button color="black" display="inline-block" :has-container="false" @click.native="startApp(app.slug)">New</ui-button>
                            <ui-button color="black" display="inline-block" :has-container="false" :disable="true">Open</ui-button>
                        </div>
                    </ui-block>
                </ui-row>
            </ui-container>
        </ui-hero-banner>
        <div class="bg-lightest-gray">
            <ui-container :contain="true" bg-color="lightest-gray" v-if="keywords && keywords.length > 0">
                <ui-title title="Glossary" align="center"/>
                <ui-accordion-cols :keywords="keywords"/>
            </ui-container>
        </div>
        <ui-container :contain="true" v-if="this.cat">
            <ui-paragraph
                class="pt-5"
                align="justify"
                v-html="cat.description" />
        </ui-container>
    </ui-container>
</template>

<script>
const clipper = require('text-clipper')
import { UiAccordionCols, UiBlock, UiButton, UiContainer, UiHeroBanner, UiList, UiListItem, UiParagraph, UiRow, UiSpecialText, UiTitle } from '../../ui'
export default {
    name: 'CatSingle',
    components: {
        UiAccordionCols,
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
            cat: null,
            keywords: null,
            image: '/img/grafica/bg.jpg',
        }
    },
    methods: {
        getData: function() {
            let slug = this.$route.params.cat
            this.$http.get('/api/v2/get-cat/' + slug).then(response => {
                if (response.data.success) {
                    this.cat = response.data.pavilion
                    this.keywords = this.cat.keywords
                    if (this.cat.img) {
                        this.image = this.cat.img
                    }
                }
            })
        },
        startApp: function(slug) {
            this.$root.goTo(slug)
        },
        goToApp: function(slug) {
            this.$root.goToWithParams('app-home', { app: slug })
        },
        shortDescription: function(value) {
            let short = clipper(value, 150, { html: true })
            return short
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

    &__menu-item,
    &__menu-head {
        &:hover {
            text-decoration: underline;
        }
    }
}
</style>
