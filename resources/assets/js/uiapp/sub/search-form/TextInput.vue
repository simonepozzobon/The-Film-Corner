<template>
<div class="form-group ua-text-input">
    <label :for="name">{{ title }}</label>
    <input
        type="text"
        :name="name"
        class="form-control"
        v-model="value"
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
