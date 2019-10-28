<template>
<select
    ref="select"
    class="form-control"
    name="states[]"
    :multiple="isMultipleValue"
>
    <option value="">Seleziona Valore</option>
    <option
        v-for="option in this.cached"
        ref="item"
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
            // console.log('watch evebt', options);
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

            if (cache.length > 0) {
                if (this.cached.length > 0) {
                    this.updateOptions(cache)
                }
                else {
                    this.addOptions(cache)
                }
            }
        },
        addOptions: function (options) {
            this.cached = options
            options.map(option => {
                return new Object(option.title, option.id, false, false)
            }).map(option => {
                return $(this.$refs.select).append(option).trigger('change')
            })
            this.$nextTick(() => {
                this.$emit('ready')
            })
        },
        updateOptions: function (options) {
            this.removeOptions(options)
            this.createOptions(options)

            this.$nextTick(() => {
                this.cached = options
            })

        },
        createOptions: function (options) {
            let toCreate = options.filter(opt => {
                let exist = this.cached.find(cache => cache.id == opt.id)
                if (!exist) {
                    return opt
                }
            })

            if (toCreate.length > 0) {
                toCreate.map(opt => {
                    return new Object(opt.title, opt.id, false, false)
                }).map(option => {
                    return $(this.$refs.select).append(option).trigger('change')
                })
            }
        },
        removeOptions: function (options) {
            let toRemove = this.cached.filter(cache => {
                let exist = options.find(opt => opt.id == cache.id)
                if (!exist) {
                    return cache
                }
            })


            if (toRemove.length > 0) {
                for (let i = 0; i < toRemove.length; i++) {
                    let current = toRemove[i]
                    let opt = this.$refs.item.find(item => item.value == current.id)
                    if (opt) {
                        $(opt).remove()
                    }
                }
            }
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

            $(this.$refs.select).on('select2:unselect', e => {
                this.value = e.params.data
                this.$emit('remove', this.value)
            });

            this.$emit('update', this.value)
        },
    },
    mounted: function () {
        this.$nextTick(() => {
            if (this.options.length > 0) {
                this.setOptions(this.options)
            }

            this.init()
        })
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
