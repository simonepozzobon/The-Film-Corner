<template>
<ui-folder
    class="ua-folder"
    ref="folder"
    :title="app | translate( 'title', $root.locale )"
    :app="app | translate( 'title', $root.locale )"
    :appPath="app.slug"
    :cat="app.category | translate( 'name', $root.locale )"
    :catPath="app.category.slug"
    :pavilion="app.category.section | translate( 'name', $root.locale )"
    :pavilionPath="app.category.section.slug"
    :color="app.category.section.color_class"
    :has-times="isOpen"
    @click="toggleFolder"
>

    <div class="ua-folder__description">
        <p
            ref="description"
            class="ua-folder__content"
            v-html="description"
        >
        </p>
    </div>

    <ui-paragraph :full-width="true">
        <ui-button
            color="dark"
            align-self="start"
            :has-container="false"
            @click="toggleFolder"
        >
            {{ button }}
        </ui-button>
    </ui-paragraph>
</ui-folder>
</template>

<script>
const clipper = require('text-clipper')
import {
    UiButton,
    UiFolder,
    UiParagraph
}
from '../ui'
import TranslationFilter from '../TranslationFilter'

export default {
    name: 'UiAppFolder',
    mixins: [TranslationFilter],
    components: {
        UiButton,
        UiFolder,
        UiParagraph,
    },
    props: {
        app: {
            type: Object,
            default: function () {},
            required: true
        }
    },
    data: function () {
        return {
            isOpen: true,
            description: null,
            button: null,
        }
    },
    watch: {
        app: function (app) {
            this.setDescription()
        },
        '$root.locale': function (lang) {
            if (this.isOpen) {
                this.description = this.$options.filters.translate(this.app, 'description', this.$root.locale)
            }
            else {
                let description = this.$options.filters.translate(this.app, 'description', this.$root.locale)
                this.description = clipper(description, 150, {
                    html: true
                })
            }
        }
    },
    methods: {
        setDescription: function () {
            if (this.app.description) {
                this.close()
            }
        },
        toggleFolder: function () {
            if (this.isOpen) {
                this.close()
            }
            else {
                this.open()
            }
        },
        open: function () {
            this.button = this.$root.getCmd('close')
            this.isOpen = true
            this.$nextTick(() => {
                this.description = this.$options.filters.translate(this.app, 'description', this.$root.locale)
            })
        },
        close: function () {
            this.button = this.$root.getCmd('read_more')
            this.isOpen = false
            let description = this.$options.filters.translate(this.app, 'description', this.$root.locale)
            this.description = clipper(description, 150, {
                html: true
            })
        },
    },
    mounted: function () {
        this.$nextTick(this.setDescription)
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ua-folder {

    &__description {
        padding-left: $spacer * 4;
        padding-right: $spacer * 4;
        margin-bottom: $spacer * 1.5;
        z-index: 1;
    }

    &__content {
        padding: 0;
        margin: 0;
    }
}
</style>
