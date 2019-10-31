<template lang="html">
    <table class="table table-hover my-5">
        <thead>
            <tr>
                <td v-for="(title, key, i) in table.heading"
                    :key="key">
                    <b>{{ title }}</b>
                </td>
                <td></td>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(row, key, i) in table.rows" :key="key">
                <td v-for="idx in colsNumber" :key="idx">
                    {{ row[idx] }}
                    <!--  with id should be [idx-1] -->
                </td>
                <td>
                    <button class="btn btn-sm btn-outline-danger" @click="destroy(row)">Remove</button>
                </td>
            </tr>
        </tbody>
    </table>
</template>

<script>
export default {
    name: 'UiTable',
    props: {
        table: {
            type: Object,
            default: function() {}
        }
    },
    computed: {
        colsNumber: function() {
            if (this.table.hasOwnProperty('heading')) {
                return this.table.heading.length
            }
            return 0
        }
    },
    methods: {
        destroy: function(row) {
            console.log(row);
            this.$emit('destroy', row)
        }
    },
    mounted: function() {
    }
}
</script>

<style lang="css" scoped>
</style>
