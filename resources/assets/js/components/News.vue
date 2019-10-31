<template>
<div class="tfc-news">
    <ui-container class="tfc-news__container">
        <ui-row>
            <ui-block
                v-for="item in news"
                :key="item.id"
                :size="4"
                class="tfc-news__item"
            >
                <ui-image :src="item.img" />
                <ui-title
                    tag="h2"
                    font-size="h5"
                    :title="item.title"
                    align="center"
                />
                <ui-paragraph
                    align="center"
                    :has-padding="false"
                >
                    {{ item.content | shortDescription }}
                </ui-paragraph>
                <ui-link
                    @click="$root.goToWithParams('news-single', {slug: item.slug})"
                    align="center"
                >{{ item.read_text }}</ui-link>
            </ui-block>
        </ui-row>
    </ui-container>
</div>
</template>

<script>
const striptags = require('striptags')
const clipper = require('text-clipper')
import News from '../dummies/news'
import {
    UiBlock,
    UiContainer,
    UiHeroImage,
    UiImage,
    UiLink,
    UiParagraph,
    UiRow,
    UiTitle
}
from '../ui'
export default {
    name: 'News',
    components: {
        UiBlock,
        UiContainer,
        UiHeroImage,
        UiImage,
        UiLink,
        UiParagraph,
        UiRow,
        UiTitle,
    },
    data: function () {
        return {
            news: [],
        }
    },
    methods: {
        getData: function () {
            this.$http.get('/api/v2/news').then(response => {
                if (response.data.success) {
                    this.news = response.data.news
                }
            })
        },
        goTo: function (event, name, id) {
            event.preventDefault()
            this.$router.push({
                name: 'news-single',
                params: {
                    slug: name,
                }
            })
        },
    },
    filters: {
        shortDescription: function (description) {
            let string = striptags(description)
            let short = clipper(string, 150, {
                html: true
            })
            return short
        },
    },
    mounted: function () {
        this.getData()
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.tfc-news {
    &__container {
        padding: $spacer;
    }

    &__item {
        margin-bottom: $spacer * 3;
    }

    @include media-breakpoint-up('sm') {
        &__container {
            padding: $spacer * 4;
        }
    }
}
</style>
