<template lang="html">
    <div class="ui-form-group">
        <label
            :for="nameToLowerCase"
            class="ui-form-group__label">
            {{ name }}
        </label>
        <ui-input
            :name="nameToLowerCase"
            :type="type"
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
}
</style>
