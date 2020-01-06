<template>
<div class="form-group ua-select-input">
    <label :for="name">{{ title }}</label>
    <select
        class="form-control"
        :name="name"
        v-model="value"
    >
        <option
            :value="null"
            disabled
            selected
        >
            {{ placeholder }}
        </option>
        <option
            v-for="opt in options"
            :key="opt.id"
            :value="opt.value"
        >
            {{ opt.title }}
        </option>
    </select>
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
        placeholder: {
            type: String,
            default: null,
        },
        value: {
            type: String,
            default: null,
        },
        options: {
            type: Array,
            default: function () {
                return []
            },
        },
    },
}
</script>

<style lang="scss" >
@import '~styles/shared';
</style>
