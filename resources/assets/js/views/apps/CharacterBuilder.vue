<template>
<app-template :app="app">
    <template slot="left">
        <!-- <ui-app-preview
            ref="preview"
            title="Character"
        /> -->
        <ui-app-block
            :title="$root.getCmd('preview')"
            titleColor="white"
            color="dark"
            :size="12"
            ref="preview"
        >
            <ui-row ref="rowTop">
                <ui-block :size="6">
                    <ui-image
                        class="character-image"
                        :src="srcs.landscape"
                        @loaded="loaded"
                    />
                </ui-block>
                <ui-block :size="6">
                    <ui-image
                        class="character-image"
                        :src="srcs.objects"
                        @loaded="loaded"
                    />
                </ui-block>
            </ui-row>
            <ui-row ref="rowBottom">
                <ui-block :size="6">
                    <ui-image
                        class="character-image"
                        :src="srcs.clothes"
                        @loaded="loaded"
                    />
                </ui-block>
                <ui-block :size="6">
                    <ui-image
                        class="character-image"
                        :src="srcs.people"
                        @loaded="loaded"
                    />
                </ui-block>
            </ui-row>
        </ui-app-block>
    </template>
    <template
        slot="right"
        v-if="this.assets"
    >
        <ui-app-library
            ref="library"
            :hasSubLibraries="assets.hasSubLibraries"
            :type="assets.type"
            :items="assets.library"
            :color="color"
            @selected="selected"
        />
    </template>
    <template>
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
import {
    fabric
}
from 'fabric'
import AppTemplate from './AppTemplate.vue'
import SizeUtility from '../../Sizes'
import {
    UiAppBlock,
    UiAppLibrary,
    UiAppNote,
    UiAppPreview,
}
from '../../uiapp'

import {
    UiBlock,
    UiImage,
    UiRow,
}
from '../../ui'

import {
    TweenMax,
}
from 'gsap/all'

import {
    ScrollToPlugin
}
from 'gsap/ScrollToPlugin'

const plugins = [
    ScrollToPlugin
]
import Shared from './Shared'

export default {
    name: 'CharacterBuilder',
    mixins: [Shared],
    components: {
        AppTemplate,
        UiAppBlock,
        UiAppLibrary,
        UiAppNote,
        UiAppPreview,
        UiBlock,
        UiImage,
        UiRow,
    },
    data: function () {
        return {
            srcs: {
                landscape: null,
                objects: null,
                clothes: null,
                people: null,
            },
            isLoading: false,
        }
    },
    watch: {
        'size': function (size) {
            if (this.canvas) {
                this.resizeCanvas(size.wClean)
            }
        },
    },
    methods: {
        init: function () {
            let session = this.$root.session
            if (session && session.app_id === 13) {
                let content = session.content
                this.notes = content.notes
                let srcs = content.canvas ? JSON.parse(content.canvas) : null
                let count = 0
                if (srcs) {
                    Object.keys(srcs).forEach(key => {
                        if (srcs[key]) {
                            count++
                        }
                    })
                }
                if (count > 0) {
                    this.session = session
                    this.isLoading = true
                    this.$root.isOpen = true
                    this.$root.objectsToLoad = count
                    Object.keys(srcs).forEach(key => {
                        if (srcs[key]) {
                            this.srcs[key] = srcs[key]
                        }
                    })
                }
            }
        },
        selected: function (index, libraryID) {
            // this.addToCanvas(index, libraryID)
            let library, asset, url, idx
            library = this.assets.library.find(library => library.id === libraryID)
            asset = library.medias.find(asset => asset.id === index)
            idx = this.assets.library.findIndex(library => library.id === libraryID)
            url = '/storage/' + asset.src
            switch (library.name) {
            case 'Landscapes':
                this.srcs.landscape = url
                break;
            case 'Objects':
                this.srcs.objects = url
                break;
            case 'Clothes':
                this.srcs.clothes = url
                break;
            case 'People':
                this.srcs.people = url
                break;
            }
            this.saveContent()
        },
        setNotes: function (notes) {
            this.notes = notes
            this.saveContent()
        },
        loaded: function () {
            let rowTop = SizeUtility.get(this.$refs.rowTop.$el)
            let rowBottom = SizeUtility.get(this.$refs.rowBottom.$el)
            let height = rowTop.hClean + rowBottom.hClean + 48
            this.$refs.library.setLibraryHeight(height)

            if (this.isLoading) {
                this.$root.objectsLoaded++
            }
        },
        saveContent: _.debounce(function () {
            let content = this.$root.session.content
            let newContent = {
                canvas: JSON.stringify(this.srcs),
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
            // console.log(this.$root.session);
        }, 500)
    },
    created: function () {
        this.$root.isApp = true
        this.getData()
    },
    mounted: function () {},
    beforeDestroy: function () {
        this.$root.isApp = false
    }
}
</script>

<style lang="scss">
@import '~styles/shared';

.character-image {
    padding: $spacer;
    border: 2px dashed $white;
}
</style>
