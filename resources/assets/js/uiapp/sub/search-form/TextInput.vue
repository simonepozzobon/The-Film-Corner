<template>
<div class="form-group ua-text-input">
    <label :for="name">{{ title }}</label>
    <input
        type="text"
        :name="name"
        class="form-control"
        v-model="textValue"
        :placeholder="placeholder"
    />
</div>
</template>

<script>
export default {
    name: 'TextInput',
    props: {
        name: {
            type: String,
            default: 'name',
        },
        title: {
            type: String,
            default: 'Titolo',
        },
        value: {
            type: String,
            default: null,
        },
        placeholder: {
            type: String,
            default: null,
        },
    },
    data: function () {
        return {
            textValue: null
        }
    },
    watch: {
        textValue: function (value) {
            this.$emit('update:value', value)
        },
    },
}
</script>

<style lang="scss" >
@import '~styles/shared';

.ua-text-input {
    label {
        font-weight: bold;
    }
}
</style>
