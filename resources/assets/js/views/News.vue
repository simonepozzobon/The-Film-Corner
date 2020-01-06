<template>
<ui-container class="news-single">
    <ui-hero-banner
        :image="this.item.img"
        :full-height="true"
    >
        <ui-container :full-width="true">
            <ui-title
                tag="h1"
                font-size="h1"
                :is-main="true"
                :uppercase="false"
                :title="item.title"
                color="white"
            />
        </ui-container>
    </ui-hero-banner>
    <ui-container
        :contain="true"
        class="py-5"
    >
        <ui-compless-paragraph
            v-if="item.content"
            class="news-single__content"
            :has-padding="false"
            :html="item.content"
        />
    </ui-container>
    <ui-container
        :contain="true"
        class="pb-5"
        direction="row"
        align="around"
    >
        <facebook
            width="48px"
            :hoverable="true"
        />
        <twitter width="48px" />
        <mail width="48px" />
        <i-link width="48px" />
    </ui-container>
</ui-container>
</template>

<script>
import news from '../dummies/news'
import {
    UiBlock,
    UiButton,
    UiComplessParagraph,
    UiContainer,
    UiHeroBanner,
    UiHeroImage,
    UiLink,
    UiParagraph,
    UiSpecialText,
    UiTitle,
    UiRow,
}
from '../ui'
import {
    Facebook,
    ILink,
    Mail,
    Twitter
}
from '../icons'

export default {
    name: 'NewsSingle',
    components: {
        Facebook,
        ILink,
        Mail,
        Twitter,
        UiBlock,
        UiButton,
        UiComplessParagraph,
        UiContainer,
        UiHeroBanner,
        UiHeroImage,
        UiLink,
        UiParagraph,
        UiSpecialText,
        UiTitle,
        UiRow,
    },
    data: function () {
        return {
            item: {
                img: null,
                title: null,
                content: null,
            },
        }
    },
    methods: {
        fetchData: function () {
            let slug = this.$route.params.slug
            // let items = news.filter(item => item.link == slug)
            // if (items.length > 0) {
            //     // articolo trovato
            //     this.item = items[0]
            // } else {
            //     // articolo non trovato
            // }
            let url = '/api/v2/news/' + slug
            this.$http.get(url).then(response => {
                if (response.data.success) {
                    this.item = response.data.news
                    // console.log(this.item);
                }
            })
        }
    },
    created: function () {
        this.fetchData()
    }
}
</script>

<style lang="scss">
@import '~styles/shared';

.news-single {
    &__content {
        img {
            max-width: 100%;
        }
    }
}
</style>
