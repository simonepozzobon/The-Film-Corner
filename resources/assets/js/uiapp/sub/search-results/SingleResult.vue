<template>
<div class="ua-single-res">
    <div class="ua-single-res__container">
        <div class="ua-single-res__thumb">
            <ui-image
                :src="content.image.thumb"
                :alt="content.title"
            />
        </div>
        <div class="ua-single-res__details">
            <div class="ua-single-res__title">
                <ui-title
                    :title="content.title"
                    :has-container="false"
                    :has-padding="false"
                    :has-margin="false"
                    tag="h3"
                    font-size="h6"
                />
            </div>
            <div class="ua-single-res__year">
                {{ content.year }}
            </div>
            <div class="ua-single-res__director">
                {{ content.director }}
            </div>
            <div class="ua-single-res__country">
                <span v-if="content.duration">
                    {{ content.country }}, {{ content.duration }}'
                </span>
                <span v-else>
                    {{ content.country }}
                </span>
            </div>
            <div class="ua-single-res__attributes">
                <div
                    class="ua-single-res__attribute"
                    v-for="(attribute, i) in content.attributes"
                    :key="attribute.id"
                >
                    <span v-if="i != content.attributes.length - 1 ">
                        {{ attribute.value }},&nbsp;
                    </span>
                    <span v-else>
                        {{ attribute.value }}
                    </span>

                </div>
            </div>
            <div class="ua-single-res__tags">
                <div
                    class="ua-single-res__tag"
                    v-for="(tag, i) in content.tags"
                    :key="tag.id"
                >
                    <span v-if="i != content.tags.length - 1 ">
                        {{ tag.title }},&nbsp;
                    </span>
                    <span v-else>
                        {{ tag.title }}
                    </span>

                </div>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import {
    UiImage,
    UiTitle,
}
from '../../../ui'

export default {
    name: 'SingleResult',
    components: {
        UiImage,
        UiTitle,
    },
    props: {
        content: {
            type: Object,
            default: function () {
                return {}
            },
        },
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ua-single-res {
    margin-bottom: $spacer * 2;

    &__container {
        display: flex;
    }

    &__thumb {
        flex: 40% 1 1;
        max-width: 40%;
    }

    &__details {
        flex: 60% 1 1;
        max-width: 60%;
        margin-left: $spacer;
    }

    &__attributes,
    &__tags {
        display: flex;
        justify-content: flex-start;
    }

    &:hover & {
        }
}
</style>
