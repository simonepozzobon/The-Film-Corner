<template lang="html">
    <div
        class="ui-form-group"
        :class="[
            alignClass,
            colorClass,
            ]">
        <label
            :for="nameToLowerCase"
            class="ui-form-group__label">
            {{ name }}
        </label>
        <ui-input
            :name="nameToLowerCase"
            :type="type"
            :default-value="defaultValue"
            @changed="changed"/>
    </div>
</template>

<script>
import UiInput from './UiInput.vue'
import UiRow from './UiRow.vue'

export default {
    name: 'UiFormGroup',
    components: {
        UiInput,
        UiRow,
    },
    props: {
        name: {
            type: String,
            default: 'name'
        },
        type: {
            type: String,
            default: 'text'
        },
        align: {
            type: String,
            default: null,
        },
        color: {
            type: String,
            default: null,
        },
        defaultValue: {
            type: String,
            default: null,
        }
    },
    computed: {
        nameToLowerCase: function() {
            return this.name.toString().toLowerCase()
            .replace(/\s+/g, '-')           // Replace spaces with -
            .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
            .replace(/\-\-+/g, '-')         // Replace multiple - with single -
            .replace(/^-+/, '')             // Trim - from start of text
            .replace(/-+$/, '')
        },
        alignClass: function() {
            if (this.align == 'left') {
                return 'ui-form-group--align-left'
            }
        },
        colorClass: function() {
            if (this.color) {
                return 'ui-form-group--' + this.color
            }
        }
    },
    methods: {
        changed: function(v, name) {
            this.$emit('changed', v, name)
        }
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-form-group {
    min-width: 100%;
    margin-bottom: $spacer;

    &__label {
        display: block;
        color: $white;
        text-align: center;
        font-size: $font-size-base * 1.15;
        font-weight: 200;
    }

    &--black &__label {
        color: $black;
    }

    &--align-left &__label {
        text-align: left;
    }
}
</style>
