<template>
    <ui-container>
        <ui-hero-banner image="/img/grafica/bg.jpg" :full-width="true">
            <ui-container :full-width="true">
                <ui-row
                    align="center"
                    ver-align="center">
                    <ui-title
                        :title="title"
                        color="white"
                        font-size="h1"
                        align="center"
                        :uppercase="false"
                        display="inline-block"
                        :has-container="false"/>
                    <ui-special-text
                        :has-padding="false"
                        color="white"
                        display="inline-block"
                        class="pl-2"
                        text="What do you want to do today?" />
                </ui-row>
                <ui-row
                    justify="center">
                    <ui-block
                        v-for="studio in this.studios"
                        :key="studio.id"
                        :size="4"
                        :color="studio.color_class"
                        :radius="true"
                        :transparent="true"
                        :full-height="true">
                        <ui-title
                            :title="studio.name"
                            color="white"
                            size="h4"
                            :hoverable="true"
                            @click.native="goToPavilion($event, studio.slug)"/>

                        <div
                            v-if="studio.slug == 'cultural-approach'">
                            <ul
                                class="block-menu">
                                <li
                                    class="block-menu__menu-head"
                                    @click="goToPropaganda(studio.slug)">
                                    Propagandapp
                                </li>
                            </ul>
                        </div>

                        <div
                            v-else>
                            <ul
                                class="block-menu"
                                v-for="cat in studio.categories">
                                <li
                                    class="block-menu__menu-head"
                                    @click="goToCat(cat.slug)">
                                    {{cat.name}}
                                </li>
                                <li
                                    class="block-menu__menu-item"
                                    v-for="app in cat.apps"
                                    @click="goToApp(app.slug)">
                                    {{ app.title }}
                                </li>
                            </ul>
                        </div>

                    </ui-block>
                </ui-row>
            </ui-container>
        </ui-hero-banner>
    </ui-container>
</template>

<script>
import { UiBlock, UiButton, UiContainer, UiHeroBanner, UiList, UiListItem, UiParagraph, UiRow, UiSpecialText, UiTitle } from '../../ui'

export default {
    name: 'AppsHome',
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
            studios: null,
            title: 'Welcome',
        }
    },
    watch: {
        '$root.user': function(user) {
            this.setWelcome()
        }
    },
    methods: {
        getStudios: function() {
            this.$http.get('/api/v2/get-studios').then(response => {
                this.studios = response.data.studios
                // console.dir(this.studios[1].categories[0].apps[0].slug);
                // console.dir(this.studios);
            })
        },
        setWelcome: function() {
            // console.log(this.$root.user);
            this.title = 'Welcome ' + this.$root.user.name
        },
        goToPavilion: function(event, slug) {
            event.preventDefault()
            this.$root.goToWithParams('pavilion-home', { pavilion: slug })
        },
        goToCat: function(slug) {
            this.$root.goToWithParams('cat-home', { cat: slug })
        },
        goToApp: function(slug) {
            this.$root.goToWithParams('app-home', { app: slug })
        },
        goToPropaganda: function(slug) {
            this.$root.goTo('propaganda-intro')
        }
    },
    created: function() {
        this.$root.space = true
        this.getStudios()
    },
    mounted: function() {
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

    &__menu-item,
    &__menu-head {
        &:hover {
            text-decoration: underline;
        }
    }
}
</style>
