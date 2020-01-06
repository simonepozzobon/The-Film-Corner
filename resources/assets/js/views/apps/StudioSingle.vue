<template>
<ui-container>
    <ui-hero-banner
        :image="image"
        :full-width="true"
    >
        <ui-container
            :full-width="true"
            v-if="this.studio"
        >
            <ui-row align="center">
                <ui-block :size="4">
                    <ui-title
                        :title="this.studio | translate('name', $root.locale)"
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
                    v-for="cat in this.studio.categories"
                    :key="cat.id"
                    :size="4"
                    :color="cat.color_class"
                    :radius="true"
                    :transparent="false"
                    :full-height="true"
                >
                    <ui-title
                        :title="cat | translate('name', $root.locale)"
                        size="h4"
                        align="center"
                        :hoverable="true"
                        @click.native="goToCat(cat.slug)"
                    />
                    <ul class="block-menu">
                        <li
                            class="block-menu__menu-item"
                            v-for="app in cat.apps"
                            @click="goToApp(app.slug)"
                        >
                            {{app | translate('title', $root.locale)}}
                        </li>
                    </ul>
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
    <ui-container
        :contain="true"
        v-if="this.studio"
    >
        <ui-paragraph
            class="pt-5"
            align="justify"
            v-html="this.studioDescription"
        />
    </ui-container>
</ui-container>
</template>

<script>
import TranslationFilter from '../../TranslationFilter'
import {
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
    name: 'StudioSingle',
    mixins: [TranslationFilter],
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
    data: function () {
        return {
            slug: null,
            studio: null,
            image: '/img/grafica/bg.jpg',
        }
    },
    computed: {
        studioDescription: function () {
            return this.$options.filters.translate(this.studio, 'description', this.$root.locale)
        },
    },
    methods: {
        getData: function () {
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
        goToCat: function (slug) {
            // console.log(slug);
            this.$root.goToWithParams('cat-home', {
                cat: slug
            })
        },
        goToApp: function (slug) {
            // console.log(slug);
            this.$root.goToWithParams('app-home', {
                app: slug
            })
        }
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
