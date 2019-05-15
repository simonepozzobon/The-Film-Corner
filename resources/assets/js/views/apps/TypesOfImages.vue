<template lang="html">
    <app-template :app="app" :left="6" :right="6">
        <template slot="left">
            <ui-app-image
                v-if="media"
                title="first image"
                :src="media.leftSrc"/>
        </template>
        <template slot="right">
            <ui-app-image
                v-if="media"
                title="second image"
                :src="media.rightSrc"
                border-direction="right"/>
        </template>
        <template>
            <ui-app-block
                class="mt-4"
                :has-title="false"
                color="dark">
                <ui-button
                    color="white"
                    :has-margin="false"
                    align="center"
                    @click.native="randomize">
                    Change Images
                </ui-button>
            </ui-app-block>
            <ui-app-note
                class="mt-4"
                :color="color"
                @changed="setNotes"/>
        </template>
    </app-template>
</template>

<script>
import AppTemplate from './AppTemplate.vue'
import { UiAppBlock, UiAppFolder, UiAppImage, UiAppLibrary, UiAppNote } from '../../uiapp'
import { SharedData, SharedMethods, SharedWatch } from './Shared'
import { UiBlock, UiButton, UiTitle, UiRow } from '../../ui'

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
    data: function() {
        return {
            ...SharedData,
            media: null,
        }
    },
    watch: {
        ...SharedWatch,
    },
    methods: {
        init: function() {
            this.media = this.assets.random
            this.saveContent()
        },
        randomize: function() {
            let idx = Math.round(Math.random() * this.assets.library.length)
            this.media = this.assets.library[idx]
            this.saveContent()
        },
        selected: function() {

        },
        setNotes: function(notes) {
            this.notes = notes
        },
        saveContent: _.debounce(function() {
            let content = this.$root.session.content
            let newContent = {
                images: [
                    this.media.leftSrc,
                    this.media.rightSrc,
                ],
                notes: 'no notes'
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
    created: function() {
        this.getData = SharedMethods.getData.bind(this)
        this.$root.isApp = true
        this.getData()
    },
    mounted: function() {
    },
    beforeDestroy: function() {
        this.$root.isApp = false
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
