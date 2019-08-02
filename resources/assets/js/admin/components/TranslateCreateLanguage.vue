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
        language: {
            type: Object,
            default: function () {
                return {}
            },
        },
        initial: {
            type: Object,
            default: function () {
                return {}
            },
        },
        option: {
            type: Object,
            default: function () {
                return {}
            },
        },
        // value: [Number, String, Object],
    },
    data: function () {
        return {
            value: null
        }
    },
    watch: {
        language: {
            handler: function (lang) {
                // console.log('cambiato');
                this.setInitial()
            },
            deep: true,
        },
        initial: function (value) {
            this.setInitial()
        },
        value: function (value) {
            this.$emit('update', value, this.language.short, this.option.title)
        },
    },
    methods: {
        setInitial: function () {
            if (this.option && this.language.initial) {
                let key = this.option.title
                if (this.language.initial.hasOwnProperty(key)) {
                    // console.log(this.language.initial, key);
                    this.value = this.language.initial[key]
                }
            }
        },
    },
    mounted: function () {
        this.$emit('load')
        this.$nextTick(() => {
            this.setInitial()
        })
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
