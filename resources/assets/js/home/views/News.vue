<template lang="html">
    <ui-container>
        <ui-hero-banner
            :image="this.item.img"
            :full-height="true">
            <ui-container :full-width="true">
                <ui-title
                    tag="h1"
                    font-size="h1"
                    :is-main="true"
                    :uppercase="false"
                    :title="item.title"
                    color="white"/>
            </ui-container>
        </ui-hero-banner>
        <ui-container :contain="true" class="py-5">
            <ui-paragraph :has-padding="false" v-html="item.content">
            </ui-paragraph>
        </ui-container>
        <ui-container :contain="true" class="pb-5" direction="row" align="around">
            <facebook width="48px" :hoverable="true"/>
            <twitter width="48px" />
            <mail width="48px" />
            <i-link width="48px" />
        </ui-container>
    </ui-container>
</template>

<script>
import news from '../dummies/news'
import { UiBlock, UiButton, UiContainer, UiHeroBanner, UiHeroImage, UiLink, UiParagraph, UiSpecialText, UiTitle, UiRow, } from '../ui'
import { Facebook, ILink, Mail, Twitter } from '../icons'

export default {
    name: 'NewsSingle',
    components: {
        Facebook,
        ILink,
        Mail,
        Twitter,
        UiBlock,
        UiButton,
        UiContainer,
        UiHeroBanner,
        UiHeroImage,
        UiLink,
        UiParagraph,
        UiSpecialText,
        UiTitle,
        UiRow,
    },
    data: function() {
        return {
            item: {
                img: null,
                title: null,
                content: null,
            },
        }
    },
    methods: {
        fetchData: function() {
            let slug = this.$route.params.slug
            let items = news.filter(item => item.link == slug)
            if (items.length > 0) {
                // articolo trovato
                this.item = items[0]
            } else {
                // articolo non trovato
            }
            console.log(this.item);
        }
    },
    created: function() {
        this.fetchData()
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
