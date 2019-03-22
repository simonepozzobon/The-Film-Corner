<template lang="html">
    <div class="tfc-news">
        <ui-container class="tfc-news__container">
            <ui-row>
                <ui-block
                    v-for="item in news"
                    :key="item.id"
                    :size="4"
                    class="tfc-news__item">
                    <ui-image :src="item.img"/>
                    <ui-title
                        tag="h2"
                        font-size="h5"
                        :title="item.title"
                        align="center"/>
                    <ui-paragraph align="center">
                        {{ item.content }}
                    </ui-paragraph>
                    <ui-link align="center">{{ item.linkText }}</ui-link>
                </ui-block>
            </ui-row>
        </ui-container>
    </div>
</template>

<script>
import News from '../dummies/news'
import { UiBlock, UiContainer, UiHeroImage, UiImage, UiLink, UiParagraph, UiRow, UiTitle } from '../ui'
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
    data: function() {
        return {
            news: News,
        }
    }
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
