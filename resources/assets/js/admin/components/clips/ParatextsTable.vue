<template>
<div class="para-table">
    <paratext-table-single
        v-for="paratext in paratexts"
        :key="paratext.id"
        :paratext="paratext"
    />
</div>
</template>

<script>
import ParatextTableSingle from './ParatextTableSingle.vue'

export default {
    name: 'ParatextsTable',
    components: {
        ParatextTableSingle,
    },
    props: {
        paratexts: {
            type: Array,
            default: function () {
                return []
            },
        },
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
