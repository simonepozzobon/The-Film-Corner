<template>
<ui-container>
    <ui-hero-banner
        :image="this.image"
        :full-width="true"
    >
        <ui-container
            :full-width="true"
            v-if="this.cat"
        >
            <ui-row align="center">
                <ui-block :size="4">
                    <ui-title
                        :title="this.catTitle"
                        :uppercase="false"
                        tag="h1"
                        font-size="h1"
                        align="center"
                        color="white"
                    />
                </ui-block>
            </ui-row>
            <ui-row justify="center">
                <ui-block
                    v-for="app in this.cat.apps"
                    :key="app.id"
                    :size="4"
                    :color="cat.color_class"
                    :radius="true"
                    :transparent="false"
                    :full-height="true"
                    align="center"
                >
                    <ui-title
                        :title="app | translate('title', $root.locale)"
                        color="black"
                        size="h4"
                        align="center"
                        @click.native="goToApp(app.slug)"
                    />

                    <ui-paragraph
                        align="center"
                        v-html="shortDescription(app)"
                    />
                    <div>
                        <ui-button
                            color="black"
                            display="inline-block"
                            :has-container="false"
                            @click.native="goToApp(app.slug)"
                        >Read More</ui-button>
                        <ui-button
                            color="black"
                            display="inline-block"
                            :has-container="false"
                            @click.native="startApp(app.slug)"
                        >New</ui-button>
                        <ui-button
                            color="black"
                            display="inline-block"
                            :has-container="false"
                            :disable="true"
                        >Open</ui-button>
                    </div>
                </ui-block>
            </ui-row>
            <ui-row justify-content="center">
                <ui-block
                    :size="12"
                    align="center"
                >
                    <svg
                        class="arrow"
                        width="64"
                        xmlns="http://www.w3.org/2000/svg"
                        xmlns:xlink="http://www.w3.org/1999/xlink"
                        viewBox="0 0 22.29 22.29"
                    >
                        <defs>
                            <clipPath id="a">
                                <rect
                                    x="4.76"
                                    y="0.5"
                                    width="12.77"
                                    height="21.29"
                                    style="fill: none"
                                />
                            </clipPath>
                        </defs>
                        <g style="clip-path: url(#a)">
                            <polyline
                                class="arrow__path"
                                points="5.82 20.73 15.41 11.14 5.82 1.56"
                            />
                        </g>
                    </svg>
                </ui-block>
            </ui-row>
        </ui-container>
    </ui-hero-banner>
    <div class="bg-lightest-gray">
        <ui-container
            :contain="true"
            bg-color="lightest-gray"
            v-if="keywords && keywords.length > 0"
        >
            <ui-title
                title="Glossary"
                align="center"
            />
            <ui-accordion-cols :keywords="keywords" />
        </ui-container>
    </div>
    <ui-container
        :contain="true"
        v-if="this.cat"
    >
        <ui-paragraph
            class="pt-5"
            align="justify"
            v-html="cat.description"
        />
    </ui-container>
</ui-container>
</template>

<script>
const clipper = require('text-clipper')
import TranslationFilter from '../../TranslationFilter'

import {
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
    UiTitle
}
from '../../ui'

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
    data: function () {
        return {
            slug: null,
            cat: null,
            keywords: null,
            image: '/img/grafica/bg.jpg',
        }
    },
    computed: {
        catTitle: function () {
            return this.$options.filters.translate(this.cat, 'name', this.$root.locale)
        }
    },
    methods: {
        getData: function () {
            let slug = this.$route.params.cat
            this.$http.get('/api/v2/get-cat/' + slug)
                .then(response => {
                    if (response.data.success) {
                        this.cat = response.data.pavilion
                        this.keywords = this.cat.keywords
                        if (this.cat.img) {
                            this.image = this.cat.img
                        }
                    }
                })
        },
        startApp: function (slug) {
            this.$root.goTo(slug)
        },
        goToApp: function (slug) {
            this.$root.goToWithParams('app-home', {
                app: slug
            })
        },
        shortDescription: function (app) {
            let description = this.$options.filters.translate(app, 'description', this.$root.locale)
            let short = clipper(description, 150, {
                html: true
            })
            return short
        }
    },
    filters: {
        ...TranslationFilter,
    },
    created: function () {
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

    &__menu-head,
    &__menu-item {
        &:hover {
            text-decoration: underline;
        }
    }
}

.arrow {
    margin-top: $spacer * 1.618;
    transform: rotate(90deg);

    &__path {
        fill: none;
        stroke: $white;
        stroke-width: 3px;
    }
}
</style>
