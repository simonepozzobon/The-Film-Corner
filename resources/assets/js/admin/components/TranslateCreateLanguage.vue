<template>
<div class="form-group row">
    <label
        for="name"
        class="col-md-2"
    >
        {{ title }}
    </label>
    <textarea
        type="text"
        name="name"
        class="form-control col-md-9"
        v-model="value"
    ></textarea>
</div>
</template>

<script>
export default {
    name: 'TranslateCreateLanguage',
    props: {
        title: {
            type: String,
            default: null,
        },
    },
    data: function () {
        return {
            value: null
        }
    },
    mounted: function () {
        this.$emit('load')
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
