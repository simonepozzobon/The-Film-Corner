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
        goToPavilion: function (event, slug) {
            event.preventDefault()
            this.$root.goToWithParams('pavilion-home', {
                pavilion: slug
            })
        },
        goToCat: function (slug) {
            this.$root.goToWithParams('cat-home', {
                cat: slug
            })
        },
        goToApp: function (slug) {
            this.$root.goToWithParams('app-home', {
                app: slug
            })
        },
        goToPropaganda: function (slug) {
            this.$root.goTo('propaganda-intro')
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
