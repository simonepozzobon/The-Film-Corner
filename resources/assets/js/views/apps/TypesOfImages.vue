<template>
<app-template
    :app="app"
    :left="6"
    :right="6"
>
    <template slot="left">
        <ui-app-image
            v-if="media"
            title="first image"
            :src="media.leftSrc"
            @loaded="loaded"
        />
    </template>
    <template slot="right">
        <ui-app-image
            v-if="media"
            title="second image"
            :src="media.rightSrc"
            border-direction="right"
            @loaded="loaded"
        />
    </template>
    <template>
        <ui-app-block
            class="mt-4"
            :has-title="false"
            color="dark"
        >
            <ui-button
                color="white"
                :has-margin="false"
                align="center"
                @click="randomize"
            >
                Change Images
            </ui-button>
        </ui-app-block>
        <ui-app-note
            class="mt-4"
            :color="color"
            @changed="setNotes"
            :initial="notes"
        />
    </template>
</app-template>
</template>

<script>
import AppTemplate from './AppTemplate.vue'
import {
    UiAppBlock,
    UiAppFolder,
    UiAppImage,
    UiAppLibrary,
    UiAppNote
}
from '../../uiapp'
import {
    SharedData,
    SharedMethods,
    SharedWatch
}
from './Shared'
import {
    UiBlock,
    UiButton,
    UiTitle,
    UiRow
}
from '../../ui'
export default {
    name: 'TypesOfImages',
    components: {
        AppTemplate,
        UiAppBlock,
        UiAppFolder,
        UiAppImage,
        UiAppLibrary,
        UiAppNote,
        UiBlock,
        UiButton,
        UiTitle,
        UiRow,
    },
    data: function () {
        return {
            ...SharedData,
            media: null,
            isLoading: false,
        }
    },
    watch: {
        ...SharedWatch,
    },
    methods: {
        init: function () {
            let images
            let session = this.$root.session
            if (session && session.app_id === 3) {
                if (session.content && session.content.hasOwnProperty('images') && session.content.images) {

                    this.$root.isOpen = true
                    this.isLoading = true
                    this.$root.objectsToLoad = session.content.images.length

                    images = session.content.images
                    this.media = {
                        leftSrc: images[0],
                        rightSrc: images[1]
                    }

                    this.notes = session.content.notes
                }
            }
            if (this.assets && !this.isLoading) {
                this.media = this.assets.random
            }
            this.saveContent()
        },
        randomize: function () {
            let idx = Math.round(Math.random() * this.assets.library.length)
            this.media = this.assets.library[idx]
            this.saveContent()
        },
        selected: function () {},
        setNotes: function (notes) {
            this.notes = notes
            this.saveContent()
        },
        loaded: function () {
            if (this.isLoading) {
                this.$root.objectsLoaded++
            }
        },
        saveContent: _.debounce(function () {
            let content = this.$root.session.content
            let newContent = {
                images: [
                    this.media.leftSrc,
                    this.media.rightSrc,
                ],
                notes: this.notes
            }
            for (let key in content) {
                if (content.hasOwnProperty(key) && newContent.hasOwnProperty(key)) {
                    content[key] = newContent[key]
                }
            }
            this.$root.session = {
                ...this.$root.session,
                content: content
            }
        }, 500)
    },
    created: function () {
        this.getData = SharedMethods.getData.bind(this)
        // this.debug = SharedMethods.debug.bind(this)
        this.$root.isApp = true
        this.getData()
    },
    mounted: function () {
        // this.debug('types-of-images', '5cff960ceceb9')
    },
    beforeDestroy: function () {
        this.$root.isApp = false
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
