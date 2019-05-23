<template lang="html">
    <ui-app-block
        color="green"
        :title="idx | formatFrameTitle"
        class="mt-4">
        <div class="frame-crop">
            <div class="frame-crop__frame">
                <img :src="img" alt="" class="frame-crop__image"/>
            </div>
            <div class="frame-crop__form">
                <div class="form-group">
                    <textarea name="notes" rows="4" cols="80" class="form-control" v-model="value"></textarea>
                </div>
                <ui-button
                    title="Delete Frame"
                    align="center"
                    :has-margin="false"
                    color="dark"
                    @click="deleteFrame"/>
            </div>
        </div>
    </ui-app-block>
</template>

<script>
import UiAppBlock from '../../UiAppBlock.vue'
import { UiButton } from '../../../ui'

export default {
    name: 'SingleFrame',
    components: {
        UiAppBlock,
        UiButton,
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
        uuid: {
            type: String,
            default: null,
            required: true,
        },
    },
    data: function() {
        return {
            value: null,
        }
    },
    watch: {
        'value': function(value) {
            this.$nextTick(() => {
                this.$emit('changed', value, this.uuid)
            })
        }
    },
    methods: {
        deleteFrame: function() {
            this.$nextTick(() => {
                this.$emit('delete-frame', this.uuid)
            })
        }
    },
    filters: {
        formatFrameTitle: function(idx) {
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
