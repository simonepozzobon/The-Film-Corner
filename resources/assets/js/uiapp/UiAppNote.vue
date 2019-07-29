<template>
<ui-row
    :no-gutters="true"
    :full-width="fullWidth"
>
    <ui-block :size="sizeValue">
        <div
            class="ua-note"
            :class="colorClass"
        >
            <ui-title
                :title="title"
                :has-padding="false"
            />
            <div class="ua-note__field">
                <textarea
                    name="name"
                    rows="8"
                    cols="80"
                    class="form-control ua-note__text"
                    v-model="notes"
                >
                    </textarea>
            </div>
        </div>
    </ui-block>
</ui-row>
</template>

<script>
import {
    UiBlock,
    UiTitle,
    UiRow
}
from '../ui'
export default {
    name: 'UiAppNote',
    components: {
        UiBlock,
        UiTitle,
        UiRow,
    },
    props: {
        title: {
            type: String,
            default: 'Notes',
        },
        color: {
            type: String,
            default: 'green'
        },
        initial: {
            type: String,
            default: null,
        },
        fullWidth: {
            type: Boolean,
            default: false,
        },
        size: [Number, String],
    },
    data: function () {
        return {
            notes: null,
            initialized: false,
        }
    },
    watch: {
        initial: function (notes) {
            if (!this.initialized) {
                this.notes = notes
                this.initialized = true
            }
        },
        notes: function (notes) {
            this.$emit('changed', notes)
        }
    },
    computed: {
        colorClass: function () {
            return 'ua-note--' + this.color
        },
        sizeValue: function () {
            if (this.size) {
                return this.size
            }

            return 12
        }
    },
    mounted: function () {
        // console.log(this.initial);
        if (this.initial) {
            this.notes = this.initial
        }
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ua-note {
    width: 100%;
    height: 100%;
    @include border-radius($custom-border-radius);
    @include app-block-padding;

    &__text {
        @include border-radius(10px);
    }

    &--green {
        background-color: $green;
    }

    &--yellow {
        background-color: $yellow;
    }

    &--red {
        background-color: $red;
    }
}
</style>
