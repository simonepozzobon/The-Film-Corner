<template>
<ui-folder class="ua-folder"
    ref="folder"
    :title="app.title"
    :app="app.title"
    :appPath="app.slug"
    :cat="app.category.name"
    :catPath="app.category.slug"
    :pavilion="app.category.section.name"
    :pavilionPath="app.category.section.slug"
    :color="app.category.section.color_class"
    :has-times="isOpen"
    @click="toggleFolder">

    <div class="ua-folder__description">
        <p ref="description"
            class="ua-folder__content"
            v-html="description">
        </p>
    </div>

    <ui-paragraph :full-width="true">
        <ui-button color="dark"
            align-self="start"
            :has-container="false"
            @click="toggleFolder">
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
} from '../ui'
export default {
    name: 'UiAppFolder',
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
            } else {
                this.open()
            }
        },
        open: function () {
            this.button = 'Close'
            this.isOpen = true
            this.$nextTick(() => {
                this.description = this.app.description
            })
        },
        close: function () {
            this.button = 'Read More'
            this.isOpen = false
            this.description = clipper(this.app.description, 150, {
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
