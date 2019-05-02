<template lang="html">
    <div
        ref="container"
        class="ui-app-library">
        <div
            ref="head"
            class="ui-app-library__head">
            <ui-title
                ref="title"
                :title="title"
                :has-padding="false"/>
            <div
                ref="select"
                class="ui-app-library__libraries"
                v-if="hasSubLibraries">
                <select
                    class="form-control ui-app-library__select"
                    v-model="currentLibrary">
                    <option
                        v-for="library in libraries"
                        :key="library.id"
                        :value="library.id">
                        {{ library.name }}
                    </option>
                </select>
            </div>
        </div>
        <div
            ref="assets"
            class="ui-app-library__assets"
            v-if="type == 'videos'">
            <transition-group
                tag="div"
                @enter="assetEnter"
                @leave="assetLeave">
                <library-item-video
                    v-for="(asset, i) in assets"
                    :key="asset.id"
                    :delay="i"
                    :index="asset.id"
                    :title="asset.title"
                    :img="asset.img | fixImgPath"
                    @selected="selected"/>
            </transition-group>
        </div>

        <div
            ref="assets"
            class="ui-app-library__assets"
            v-else-if="type == 'audios'">
            <transition-group
                tag="div"
                @enter="assetEnter"
                @leave="assetLeave">
                <library-item-audio
                    v-for="(asset, i) in assets"
                    :key="asset.id"
                    :delay="i"
                    :index="asset.id"
                    :title="asset.title"
                    @selected="selected"/>
            </transition-group>
        </div>

        <div
            ref="assets"
            class="ui-app-library__assets"
            v-else>
            <transition-group
                tag="div"
                @enter="assetEnter"
                @leave="assetLeave">
                <library-item
                    v-for="(asset, i) in assets"
                    :key="asset.id"
                    :delay="i"
                    :index="asset.id"
                    :title="asset.title"
                    :img="asset.landscape | fixImgPath"
                    @selected="selected"/>
            </transition-group>
        </div>
    </div>
</template>

<script>
import LibraryItem from './sub/library/LibraryItem.vue'
import LibraryItemAudio from './sub/library/LibraryItemAudio.vue'
import LibraryItemVideo from './sub/library/LibraryItemVideo.vue'
import SizeUtility from '../Sizes'
import { UiTitle } from '../ui'

export default {
    name: 'UiAppLibrary',
    components: {
        LibraryItem,
        LibraryItemAudio,
        LibraryItemVideo,
        UiTitle,
    },
    props: {
        title: {
            type: String,
            default: 'Library',
        },
        hasSubLibraries: {
            type: Boolean,
            default: false,
        },
        type: {
            type: String,
            default: 'images'
        },
        items: {
            type: Array,
            default: function() {},
        },
    },
    data: function() {
        return {
            libraryHeight: 0,
            libraries: [],
            currentLibrary: 0,
            assets: [],
            animationsController: [],
            animationsCache: [],
        }
    },
    watch: {
        'currentLibrary': function(id) {
            this.setAssets(id)
        },
    },
    filters: {
        fixImgPath: function(path) {
            return '/storage/' + path
        },
    },
    methods: {
        init: function() {
            if (this.hasSubLibraries) {
                this.libraries = this.items
                if (this.libraries.length > 0) {
                    this.currentLibrary = this.libraries[0].id
                }
            } else {
                this.assets = this.items
            }
        },
        setAssets: function(id) {
            let selected = this.libraries.filter(library => library.id == id)[0]
            if (selected) {
                switch (this.type) {
                    case 'videos':
                        this.assets = selected.videos
                        break;
                    case 'audios':
                        this.assets = selected.audios
                        break;
                    default:
                        this.assets = selected.medias
                }
            }
        },
        selected: function(index) {
            if (this.hasSubLibraries) {
                this.$emit('selected', index, this.currentLibrary)
            } else {
                this.$emit('selected', index)
            }
        },
        assetEnter: function(el, done) {
            let delay = el.dataset.delay * 0.1
            let master = TweenMax.fromTo(el, .3, {
                autoAlpha: 0,
                scaleY: 0,
                yPercent: 100,
                transformOrigin: '50% 100%',
            }, {
                // delay: delay,
                autoAlpha: 1,
                scaleY: 1,
                yPercent: 0,
                transformOrigin: '50% 100%',
                onComplete: () => {
                    master.kill()
                    this.$nextTick(done)
                }
            })
        },
        assetLeave: function(el, done) {
            let delay = el.dataset.delay * 0.1
            let master = TweenMax.fromTo(el, .3, {
                autoAlpha: 1,
                scaleY: 1,
                yPercent: 0,
                transformOrigin: '50% 0%',
            }, {
                // delay: delay,
                scaleY: 0,
                autoAlpha: 0,
                yPercent: 100,
                transformOrigin: '50% 0%',
                onComplete: () => {
                    master.kill()
                    this.$nextTick(done)
                }
            })
        },
        setLibraryHeight: function() {
            let container = this.$refs.container
            let el = this.$refs.head
            let title = this.$refs.title.$refs.title
            let assets = this.$refs.assets

            let titleSize = SizeUtility.get(title)
            let headSize = SizeUtility.get(el)
            let containerH = SizeUtility.get(container).hClean

            let height = containerH - titleSize.h - titleSize.marginY

            if (this.hasSubLibraries) {
                let select = this.$refs.select
                let selectSize = SizeUtility.get(select)
                height = height - selectSize.h - selectSize.marginY

            }

            height = Math.round(height)

            TweenMax.fromTo(assets, .4, {
                height: this.libraryHeight,
                autoAlpha: 0,
            }, {
                height: height,
                autoAlpha: 1,
                onStart: () => {
                    this.libraryHeight = height
                }
            })
        }
    },
    created: function() {
        this.init()
    },
    mounted: function() {
        this.setLibraryHeight()
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-app-library {
    background-color: $green;
    width: 100%;
    min-height: 100%;
    padding: $spacer;
    @include border-right-radius(24px);
    @include app-block-padding;

    &__libraries {
        margin-bottom: $spacer;
    }

    &__assets {
        height: 0;
        opacity: 0;
        visibility: hidden;
        overflow-y: scroll;
        overflow-x: hidden;
    }
}
</style>
