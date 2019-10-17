<template>
<div class="form-group row">
    <label
        for="name"
        class="col-md-2"
    >
        {{ title }}
    </label>
    <text-editor
        class="col-md-9"
        @update="updateContent"
        :initial="this.initialValue ? this.initialValue : null"
    />
</div>
</template>

<script>
import TextEditor from './TextEditor.vue'

export default {
    name: 'TranslateCreateLanguage',
    components: {
        TextEditor,
    },
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
            value: null,
            initialValue: null,
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
                    this.initialValue = this.language.initial[key]
                }
            }
        },
        updateContent: function (json, html) {
            this.value = html
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
