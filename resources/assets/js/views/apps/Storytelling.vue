<template>
<app-template :app="app">
    <template>
        <ui-app-block
            :has-title="false"
            :color="color"
        >
            <ui-row>
                <ui-block
                    :size="2"
                    v-if="srcs.src1"
                >
                    <ui-image :src="srcs.src1" />
                </ui-block>
                <ui-block
                    :size="2"
                    v-if="srcs.src2"
                >
                    <ui-image :src="srcs.src2" />
                </ui-block>
                <ui-block
                    :size="2"
                    v-if="srcs.src3"
                >
                    <ui-image :src="srcs.src3" />
                </ui-block>
                <ui-block
                    :size="2"
                    v-if="srcs.src4"
                >
                    <ui-image :src="srcs.src4" />
                </ui-block>
                <ui-block
                    :size="2"
                    v-if="srcs.src5"
                >
                    <ui-image :src="srcs.src5" />
                </ui-block>
                <ui-block
                    :size="2"
                    v-if="srcs.src6"
                >
                    <ui-image :src="srcs.src6" />
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
} from '../../uiapp'
import {
    SharedData,
    SharedMethods,
    SharedWatch
} from './Shared'
import {
    UiBlock,
    UiButton,
    UiImage,
    UiTitle,
    UiRow
} from '../../ui'
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
                src1: null,
                src2: null,
                src3: null,
                src4: null,
                src5: null,
                src6: null,
            }
        }
    },
    watch: {
        ...SharedWatch,
    },
    methods: {
        init: function () {
            this.randomize()
        },
        randomize: function () {
            let libraries = this.assets.library
            for (let i = 0; i < libraries.length; i++) {
                let key = 'src' + (i + 1)
                this.srcs[key] = '/storage/' + this.randomizeSingle(
                        libraries[i].medias)
                    .src
            }
            this.saveContent()
        },
        randomizeSingle: function (library) {
            let idx = Math.floor(Math.random() * library.length)
            return library[idx]
        },
        setNotes: function (notes) {
            this.notes = notes
        },
        saveContent: _.debounce(function () {
            let content = this.$root.session.content
            let newContent = {
                'slot_1': this.srcs.src1,
                'slot_2': this.srcs.src2,
                'slot_3': this.srcs.src3,
                'slot_4': this.srcs.src4,
                'slot_5': this.srcs.src5,
                'slot_6': this.srcs.src6,
                notes: 'no notes'
            }
            for (let key in content) {
                if (content.hasOwnProperty(key) && newContent.hasOwnProperty(
                        key)) {
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
