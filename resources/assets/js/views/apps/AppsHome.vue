<template>
<ui-container>
    <ui-hero-banner
        image="/img/grafica/bg.jpg"
        :full-width="true"
    >
        <ui-container :full-width="true">
            <ui-row
                align="center"
                ver-align="center"
            >
                <ui-title
                    :title="title"
                    color="white"
                    font-size="h1"
                    align="center"
                    :uppercase="false"
                    display="inline-block"
                    :has-container="false"
                />
                <ui-special-text
                    :has-padding="false"
                    color="white"
                    display="inline-block"
                    class="pl-2"
                    text="What do you want to do today?"
                />
            </ui-row>
            <ui-row justify="center">
                <studio-block
                    v-for="studio in this.studios"
                    :key="studio.id"
                    :studio="studio"
                />
                <!-- <ui-block
                    v-for="studio in this.studios"
                    :key="studio.id"
                    :size="4"
                    :color="studio.color_class"
                    :radius="true"
                    :transparent="true"
                    :full-height="true"
                >
                    <ui-title
                        :title="studio.name | translate('name', 'sections', $translations)"
                        align="center"
                        size="h4"
                        color="white"
                        :hoverable="true"
                        :x-padding="true"
                        @click.native="goToPavilion($event, studio.slug)"
                    />

                    <div v-if="studio.slug == 'cultural-approach'">
                        <ul class="block-menu block-menu--var">
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
                        <ul class="block-menu block-menu--var">
                            <li class="block-menu__menu-head">
                                Art<b>app</b>
                            </li>
                            <li class="block-menu__menu-item">
                                Go to the challenges
                            </li>
                        </ul>
                    </div>

                    <div v-else>
                        <ul
                            class="block-menu"
                            v-for="cat in studio.categories"
                        >
                            <li
                                class="block-menu__menu-head"
                                @click="goToCat(cat.slug)"
                            >
                                {{cat.name}}
                            </li>
                            <li
                                class="block-menu__menu-item"
                                v-for="app in cat.apps"
                                @click="goToApp(app.slug)"
                            >
                                {{ app.title }}
                            </li>
                        </ul>
                    </div>

                </ui-block> -->
            </ui-row>
        </ui-container>
    </ui-hero-banner>
</ui-container>
</template>

<script>
import StudioBlock from '../../components/StudioBlock.vue'

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
    name: 'AppsHome',
    components: {
        StudioBlock,
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
            studios: null,
            title: 'Welcome',
        }
    },
    watch: {
        '$root.user': function (user) {
            this.setWelcome()
        }
    },
    filters: {
        translate: function (defaultValue, key, section, translations) {
            return translations.getContent(defaultValue, key, section);
        }
    },
    methods: {
        getStudios: function () {
            this.$http.get('/api/v2/get-studios').then(response => {
                this.studios = response.data.studios
                // console.dir(this.studios[1].categories[0].apps[0].slug);
                // console.dir(this.studios);
            })
        },
        setWelcome: function () {
            // console.log(this.$root.user);
            this.title = 'Welcome ' + this.$root.user.name
        },

    },
    created: function () {
        this.$root.space = true
        this.getStudios()
    },
    mounted: function () {
        this.$nextTick(this.setWelcome)
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

    &--var & {
        &__menu-head {
            font-weight: 600;
        }
    }
}
</style>
