<template>
<div class="para-table-single">
    id
</div>
</template>

<script>
export default {
    name: 'ParatextTableSingle',
    props: {
        paratext: {
            type: Object,
            default: function () {
                return {}
            },
        },
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.para-table-single {
    display: flex;
}
</style>
