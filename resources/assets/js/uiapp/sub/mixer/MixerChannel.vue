<template>
<div class="mixer-channel">
    <vue-slider
        ref="slider"
        direction="btt"
        v-model="volume"
        :height="100"
        :width="8"
        :dotSize="18"
        :value="0"
        :disabled="isDisable"
    />
    <div
        v-if="!isDisable"
        class="mixer-channel__delete"
    >
        <ui-button
            :title="$root.getCmd('clear')"
            color="white"
            :has-container="false"
            :has-margin="false"
            @click="removeTrack"
        />
    </div>
</div>
</template>

<script>
import VueSlider from 'vue-slider-component/dist-css/vue-slider-component.umd'
import {
    UiButton
}
from '../../../ui'
export default {
    name: 'MixerCannel',
    components: {
        VueSlider,
        UiButton,
    },
    props: {
        color: {
            type: String,
            default: 'green'
        },
        idx: {
            type: Number,
            default: 0,
        },
        src: [Object, String],
        vol: [Number, String],
    },
    data: function () {
        return {
            volume: 0,
            isDisable: true,
        }
    },
    watch: {
        src: function (src) {
            if (src && src != null) {
                this.isDisable = false
            }
            else {
                this.isDisable = true
            }
        },
        vol: function (vol) {
            this.volume = vol
        },
        volume: function (volume) {
            if (this.src) {
                this.$emit('volume', volume, this.idx)
            }
        },
    },
    methods: {
        removeTrack: function () {
            this.volume = 0
            this.$nextTick(() => {
                this.$emit('remove-track', this.idx)
            })
        }
    }
}
</script>

<style lang="scss">
@import '~styles/shared';

$themeColor: $green;
$dotBgColor: $green;
$bgColor: $light-gray;

@import 'vue-slider-component/lib/styles/dot.scss';
@import 'vue-slider-component/lib/styles/mark.scss';
@import 'vue-slider-component/lib/styles/slider.scss';
@import 'vue-slider-component/lib/theme/default.scss';

.mixer-channel {
    &__delete {
        margin-top: $spacer * 1.618;
    }
}
</style>
