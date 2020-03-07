<template>
<p v-html="description">

</p>
</template>

<script>
export default {
    name: 'ModalPanelText',
    props: {
        content: {
            type: Object,
            default: function () {
                return {}
            },
        },
    },
    data: function () {
        return {
            description: null,
        }
    },
    watch: {
        '$root.locale': function (locale) {
            this.translateContent()
        }
    },
    methods: {
        translateContent: function () {
            let locale = this.$root.locale
            let description = this.content.translations.find(translation => translation.locale == locale)

            if (description) {
                this.description = description.content
            }
            else {
                this.description = this.content.content
            }
        }
    },
    mounted: function () {
        this.translateContent()
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
