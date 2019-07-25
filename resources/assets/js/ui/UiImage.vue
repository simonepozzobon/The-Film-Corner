<template>
<div
    class="ui-image"
    :class="[
        fullWidthClass,
        fullHeightClass,
        marginClass,
    ]"
    :title="alt"
    ref="container"
    @click.prevent="$emit('click')"
>
    <!-- <img
        :src="src"
        :alt="alt"
        class="ui-image__content"
    /> -->
</div>
</template>

<script>
export default {
    name: 'UiImage',
    props: {
        alt: {
            type: String,
            default: null
        },
        src: {
            type: String,
            default: null
        },
        fullWidth: {
            type: Boolean,
            default: false,
        },
        fullHeight: {
            type: Boolean,
            default: false,
        },
        hasMargin: {
            type: Boolean,
            default: true,
        },
    },
    data: function () {
        return {
            source: null,
            ready: false,
        }
    },
    watch: {
        src: function (src) {
            this.ready = false
            this.$emit('unload')
            this.loader()
        }
    },
    computed: {
        fullWidthClass: function () {
            if (this.fullWidth) {
                return 'ui-image--full-width'
            }
        },
        fullHeightClass: function () {
            if (this.fullHeight) {
                return 'ui-image--full-height'
            }
        },
        marginClass: function () {
            if (!this.hasMargin) {
                return 'ui-image--no-margin'
            }
        },
    },
    methods: {
        appendToDOM: function (img) {
            this.ready = true
            let container = this.$refs.container
            for (let i = 0; i < container.childNodes.length; i++) {
                container.removeChild(container.childNodes[i])
            }
            container.appendChild(img)
            this.$nextTick(() => {
                this.$emit('loaded')
            })
        },
        loader: function () {
            if (this.src) {
                let img = new Image()
                img.addEventListener('load', () => {
                    if (!this.ready) {
                        this.appendToDOM(img)
                    }
                })
                img.classList.add('ui-image__content')
                img.alt = this.alt
                img.src = this.src
            }
        }
    },
    created: function () {
        this.loader()
    }
}
</script>

<style lang="scss">
@import '~styles/shared';

.ui-image {
    $self: &;
    overflow: hidden;
    @include border-radius($spacer / 2.8);
    margin-bottom: $spacer;
    max-width: 100%;
    max-height: 100%;

    &__content {
        max-width: 100%;
    }

    &--full-width {
        width: 100%;
    }

    &--full-width & {
        &__content {
            width: 100%;
            height: auto;
        }
    }

    &--no-margin {
        margin-bottom: 0;
    }
}
</style>
