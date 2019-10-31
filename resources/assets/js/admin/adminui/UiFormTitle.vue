<template lang="html">
    <div class="form-group mb-4">
        <h5>{{ title }}</h5>
    </div>
</template>

<script>
export default {
    name: 'UiFormTitle',
    props: {
        title: {
            type: String,
            default: 'Titolo'
        }
    }
}
</script>

<style lang="css" scoped>
</style>
