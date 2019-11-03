<template lang="html">
    <div class="form-group row">
        <label :for="name" class="col-md-3 col-form-label">{{ title }}</label>
        <div class="col-md-9">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
    name: 'FormGroup',
    props: {
        name: {
            type: String,
            default: 'name'
        },
        title: {
            type: String,
            default: 'titolo'
        }
    }
}
</script>

<style lang="css" scoped>
</style>
