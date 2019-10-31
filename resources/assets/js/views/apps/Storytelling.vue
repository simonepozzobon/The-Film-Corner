<template>
<app-template :app="app">
    <template>
        <ui-app-block
            :has-title="false"
            :color="color"
        >
            <ui-row>
                <ui-block :size="2">
                    <ui-image
                        :src="srcs.slot_1"
                        @loaded="ready"
                    />
                </ui-block>
                <ui-block :size="2">
                    <ui-image
                        :src="srcs.slot_2"
                        @loaded="ready"
                    />
                </ui-block>
                <ui-block :size="2">
                    <ui-image
                        :src="srcs.slot_3"
                        @loaded="ready"
                    />
                </ui-block>
                <ui-block :size="2">
                    <ui-image
                        :src="srcs.slot_4"
                        @loaded="ready"
                    />
                </ui-block>
                <ui-block :size="2">
                    <ui-image
                        :src="srcs.slot_5"
                        @loaded="ready"
                    />
                </ui-block>
                <ui-block :size="2">
                    <ui-image
                        :src="srcs.slot_6"
                        @loaded="ready"
                    />
                </ui-block>
            </ui-row>
        </ui-app-block>
        <ui-app-block
            class="mt-4"
            :has-title="false"
            color="dark"
        >
            <ui-button
                color="white"
                :has-margin="false"
                align="center"
                @click.native="randomize"
            >
                Reload
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
    UiImage,
    UiTitle,
    UiRow
}
from '../../ui'
export default {
    name: 'Storytelling',
    components: {
        AppTemplate,
        UiAppBlock,
        UiAppFolder,
        UiAppLibrary,
        UiAppNote,
        UiBlock,
        UiButton,
        UiImage,
        UiTitle,
        UiRow,
    },
    data: function () {
        return {
            ...SharedData,
            srcs: {
                slot_1: null,
                slot_2: null,
                slot_3: null,
                slot_4: null,
                slot_5: null,
                slot_6: null,
            },
            isLoading: false,
        }
    },
    watch: {
        ...SharedWatch,
    },
    methods: {
        ready: function () {
            if (this.isLoading) {
                this.$root.objectsLoaded++
            }
        },
        init: function () {
            let session = this.$root.session
            if (session && session.app_id === 14) {
                this.notes = session.content.notes

                let slots = Object.assign({}, session.content)
                delete slots.notes

                let count = 0
                Object.keys(slots).forEach(key => {
                    if (slots[key]) {
                        count++
                    }
                })
                if (slots && count > 0) {
                    this.session = session
                    this.isLoading = true
                    this.$root.isOpen = true
                    this.$root.objectsToLoad = 6

                    Object.keys(slots).forEach(key => {
                        if (slots[key]) {
                            this.srcs[key] = slots[key]
                        }
                        else {
                            let libraries = this.assets.library
                            let id = Number(key.replace('slot_', '')) - 1
                            this.srcs[key] = '/storage/' + this.randomizeSingle(libraries[id].medias).src
                        }
                    })
                }
            }

            if (!this.isLoading) {
                this.randomize()

            }

        },
        randomize: function () {
            let libraries = this.assets.library
            for (let i = 0; i < libraries.length; i++) {
                let key = 'slot_' + (i + 1)
                this.srcs[key] = '/storage/' + this.randomizeSingle(libraries[i].medias).src
            }
            this.saveContent()
        },
        randomizeSingle: function (library) {
            let idx = Math.floor(Math.random() * library.length)
            return library[idx]
        },
        setNotes: function (notes) {
            this.notes = notes
            this.saveContent()
        },
        saveContent: _.debounce(function () {
            let content = this.$root.session.content
            let newContent = {
                'slot_1': this.srcs.slot_1,
                'slot_2': this.srcs.slot_2,
                'slot_3': this.srcs.slot_3,
                'slot_4': this.srcs.slot_4,
                'slot_5': this.srcs.slot_5,
                'slot_6': this.srcs.slot_6,
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
        }, 500),
    },
    created: function () {
        this.getData = SharedMethods.getData.bind(this)
        this.$root.isApp = true
        this.getData()
    },
    mounted: function () {},
    beforeDestroy: function () {
        this.$root.isApp = false
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
