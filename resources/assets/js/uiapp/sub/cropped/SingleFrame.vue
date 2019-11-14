<template>
<ui-app-block
    :color="color"
    :title="idx | formatFrameTitle"
    class="mt-4"
>
    <div class="frame-crop">
        <div
            class="frame-crop__frame"
            ref="imageContainer"
        >
            <ui-image
                :src="img"
                @loaded="$emit('loaded')"
            />
        </div>
        <div class="frame-crop__form">
            <div class="form-group">
                <textarea
                    name="notes"
                    rows="4"
                    cols="80"
                    class="form-control"
                    v-model="value"
                ></textarea>
            </div>
            <ui-button
                :title="$root.getCmd('delete_frame')"
                align="center"
                :has-margin="false"
                color="dark"
                @click="deleteFrame"
            />
        </div>
    </div>
</ui-app-block>
</template>

<script>
import UiAppBlock from '../../UiAppBlock.vue'
import {
    UiButton,
    UiImage
}
from '../../../ui'
export default {
    name: 'SingleFrame',
    components: {
        UiAppBlock,
        UiButton,
        UiImage,
    },
    props: {
        idx: {
            type: Number,
            default: 0
        },
        img: {
            type: String,
            default: null,
            required: true,
        },
        text: {
            type: String,
            default: null,
        },
        uuid: {
            type: String,
            default: null,
            required: true,
        },
        color: {
            type: String,
            default: 'green',
        },
    },
    data: function () {
        return {
            value: null,
            ready: false,
        }
    },
    watch: {
        'value': function (value) {
            this.$nextTick(() => {
                this.$emit('changed', value, this.uuid)
            })
        }
    },
    methods: {
        deleteFrame: function () {
            this.$nextTick(() => {
                this.$emit('delete-frame', this.uuid)
            })
        },
        loadImage: function () {
            if (this.img) {
                let img = new Image()
                img.addEventListener('load', () => {
                    if (!this.ready) {
                        this.appendToDOM(img)
                    }
                })
                img.src = this.src
                img.alt = this.alt
                img.classList.add('img-fluid', 'ui-image__content')
                if (img.complete) {
                    this.$nextTick(() => {
                        this.appendToDOM(img)
                    })
                }
            }
        }
    },
    created: function () {
        if (this.text) {
            this.value = this.text
        }
    },
    filters: {
        formatFrameTitle: function (idx) {
            return 'Frame ' + (idx + 1)
        }
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.frame-crop {
    display: flex;
    flex-wrap: wrap;
    width: 100%;

    &__image {
        max-width: 100%;
        height: auto;
        overflow: hidden;
        @include border-radius(10px);
    }

    &__frame {
        flex: 0 0 25%;
        max-width: 25%;
    }

    &__form {
        padding-left: $spacer * 1.618;
    }

}
</style>
