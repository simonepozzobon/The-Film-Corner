<template>
<select
    ref="select"
    class="form-control"
    name="states[]"
    :multiple="isMultipleValue"
>
    <option
        v-for="option in this.cached"
        :key="option.id"
        :value="option.id"
    >
        {{ option.title }}
    </option>
</select>
</template>

<script>
import Select2 from 'v-select2-component';
export default {
    name: '',
    components: {
        Select2,
    },
    props: {
        multiple: {
            type: Boolean,
            default: true,
        },
        options: {
            type: Array,
            default: function () {
                return []
            }
        }
    },
    data: function () {
        return {
            cached: [],
            value: null,
        }
    },
    watch: {
        options: function (options) {
            this.setOptions(options)
        },
    },
    computed: {
        isMultipleValue: function () {
            if (this.multiple) {
                return 'multiple'
            }
            else {
                return false
            }
        },
    },
    methods: {
        setOptions: function (options) {
            let cache = options.map(option => {
                return {
                    id: option.id,
                    title: option.title ? option.title : option.name
                }
            })
            this.cached = cache
        },
        init: function () {
            $(this.$refs.select).select2({
                tags: true,
                tokenSeparators: [','],
                width: 'element'
            });

            $(this.$refs.select).on('select2:select', e => {
                this.value = e.params.data
                this.$emit('update', this.value)
            });
        },
    },
    mounted: function () {
        this.init()
    },
}
</script>

<style lang="scss">
@import '~styles/shared';

.select2-container--default .select2-selection--single,
.select2-container--focus .select2-selection--single {
    height: 100%;
    padding: $input-padding-y $input-padding-x;
    border: 1px solid #ced4da;
}

.select2-container--default .select2-selection--multiple,
.select2-container--focus .select2-selection--multiple,
.select2-selection {
    border: 1px solid #ced4da;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    top: 50%;
    transform: translateY(-50%);
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    padding: 0;
}
</style>
