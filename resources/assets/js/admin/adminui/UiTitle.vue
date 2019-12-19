<template>
<div class="row no-gutters">
    <div
        class="col ui-title"
        :class="[paddingTopClass, hasBreadcrumbsClass]"
    >
        <div class="ui-title__head">
            <h1 align="center">{{ title }}</h1>
        </div>
        <div class="ui-title__divider">
            <hr>
        </div>
        <div
            class="ui-title__image"
            ref="container"
            v-if="image && !this.$root.videoHead"
        >
            <div
                class="ui-title__image-overlay"
                ref="overlay"
                v-if="this.imageOverlay"
            >
                <img
                    class="ui-title__image-subject img-fluid mx-auto w-100"
                    :src="imageOverlay"
                    alt="First slide"
                >
            </div>
            <div
                class="ui-title__image-bg"
                v-if="this.image"
            >
                <img
                    class="img-fluid mx-auto w-100"
                    :src="image"
                    alt="First slide"
                >
            </div>
        </div>
        <div
            class="ui-title__video"
            ref="container"
            v-else-if="this.$root.videoHead"
        >
            <div class="embed-responsive embed-responsive-16by9 ui-title__video-wrapper">
                <iframe
                    class="embed-responsive-item ui-title__video-iframe"
                    :src="this.$root.videoHead.url | setUri"
                    allowfullscreen
                ></iframe>
            </div>
        </div>
    </div>
</div>
</template>

<script>
export default {
    name: 'UiTitle',
    components: {},
    props: {
        title: {
            type: String,
            default: 'Titolo'
        },
        hasPaddingTop: {
            type: Boolean,
            default: true,
        },
        image: {
            type: String,
            default: null,
        },
        imageOverlay: {
            type: String,
            default: null,
        },
    },
    watch: {
        '$root.videoHead': function (video) {
            // console.log(video);
        }
    },
    computed: {
        hasBreadcrumbs: function () {
            if (this.$route.name == 'home') {
                return false
            }

            return true
        },
        hasBreadcrumbsClass: function () {
            if (!this.hasBreadcrumbs) {
                return 'ui-title--no-bread'
            }
        },
        paddingTopClass: function () {
            if (this.hasPaddingTop) {
                return 'pt-5'
            }
            return null
        },
        paddingMdTopClass: function () {
            if (this.hasPaddingTop) {
                return 'pt-md-5'
            }
            return null
        }
    },
    filters: {
        setUri: function (url) {
            if (url) {
                url.match(/(http:|https:|)\/\/(player.|www.)?(vimeo\.com|youtu(be\.com|\.be|be\.googleapis\.com))\/(video\/|embed\/|watch\?v=|v\/)?([A-Za-z0-9._%-]*)(\&\S+)?/);

                if (RegExp.$3.indexOf('youtu') > -1) {
                    return 'https://www.youtube.com/embed/' + RegExp.$6
                }
                else if (RegExp.$3.indexOf('vimeo') > -1) {
                    return 'https://player.vimeo.com/video/' + RegExp.$6
                }
                return null
            }
        }
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-title {
    display: flex;
    flex-direction: column;
    height: 100%;
    transition: $transition-base;

    &__bread {
        padding-top: $spacer * 3;

        @include media-breakpoint-up('md') {
            padding-top: $spacer * 6;
        };
    }

    &--no-bread &__head {
        padding-top: $spacer * 3;

        @include media-breakpoint-up('md') {
            padding-top: $spacer * 6;
        };
    }

    &__divider {
        flex: 0 0 50%;
        max-width: 50%;
        margin-left: 25%;
    }

    &__video {
        flex: 0 0 83.33333333%;
        max-width: 83.33333333%;
        margin-left: 8.33333333%;
        position: relative;
        height: 100%;
    }

    &__bread {
        flex: 0 0 83.33333333%;
        max-width: 83.33333333%;
        margin-left: 8.33333333%;
        position: relative;
        height: 100%;
    }

    &__image {
        flex: 0 0 83.33333333%;
        max-width: 83.33333333%;
        margin-left: 8.33333333%;
        position: relative;
        height: 100%;
    }

    &__image-overlay {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 100%;
    }

    &__image-overlay {}
}
</style>
