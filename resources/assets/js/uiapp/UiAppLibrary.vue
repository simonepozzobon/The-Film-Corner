<template>
<div
    ref="container"
    class="ui-app-library"
    :class="colorClass"
>
    <div
        ref="head"
        class="ui-app-library__head"
    >
        <ui-title
            ref="title"
            :title="title"
            :has-padding="false"
        />
        <div
            ref="select"
            class="ui-app-library__libraries row no-gutters"
            v-if="hasSubLibraries"
        >
            <label class="col-4">Select From</label>
            <select
                class="form-control ui-app-library__select col-8"
                v-model="currentLibrary"
            >
                <option
                    v-for="library in libraries"
                    :key="library.id"
                    :value="library.id"
                >
                    {{ library.name }}
                </option>
            </select>
        </div>
    </div>
    <div
        ref="assets"
        class="ui-app-library__assets"
        v-if="mediaType == 'videos'"
    >
        <transition-group
            tag="div"
            @enter="assetEnter"
            @leave="assetLeave"
        >
            <library-item-video
                v-for="(asset, i) in assets"
                :key="asset.id"
                :delay="i"
                :index="asset.id"
                :title="asset.title"
                :img="asset.img | fixImgPath"
                @selected="selected"
                @ready="ready"
            />
        </transition-group>
    </div>

    <div
        ref="assets"
        class="ui-app-library__assets"
        v-else-if="mediaType == 'audios'"
    >
        <transition-group
            tag="div"
            @enter="assetEnter"
            @leave="assetLeave"
        >
            <library-item-audio
                v-for="(asset, i) in assets"
                :key="asset.id"
                :delay="i"
                :index="asset.id"
                :title="asset.title"
                @selected="selected"
                @ready="ready"
            />
        </transition-group>
    </div>

    <div
        ref="assets"
        class="ui-app-library__assets"
        v-else
    >
        <transition-group
            tag="div"
            @enter="assetEnter"
            @leave="assetLeave"
        >
            <library-item
                v-for="(asset, i) in assets"
                :key="asset.id"
                :delay="i"
                :index="asset.id"
                :title="asset.title"
                :img="asset.landscape | fixImgPath"
                @selected="selected"
                @ready="ready"
            />
        </transition-group>
    </div>
</div>
</template>

<script>
import LibraryItem from './sub/library/LibraryItem.vue'
import LibraryItemAudio from './sub/library/LibraryItemAudio.vue'
import LibraryItemVideo from './sub/library/LibraryItemVideo.vue'
import SizeUtility from '../Sizes'
import {
    UiTitle
} from '../ui'
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
            default: function () {},
        },
        color: {
            type: String,
            default: 'green'
        }
    },
    data: function () {
        return {
            libraryHeight: 0,
            libraries: [],
            currentLibrary: 0,
            assets: [],
            animationsController: [],
            animationsCache: [],
            mediaType: null,
            counter: 0,
        }
    },
    watch: {
        'currentLibrary': function (id) {
            this.setAssets(id)
        },
        counter: function (count) {
            if (count == 0) {
                this.setLibraryHeight()
            }
        }
    },
    computed: {
        colorClass: function () {
            return 'ui-app-library--' + this.color
        },
    },
    filters: {
        fixImgPath: function (path) {
            return '/storage/' + path
        },
    },
    methods: {
        beforeInit: function () {},
        init: function () {
            if (this.hasSubLibraries) {
                this.libraries = this.items
                if (this.libraries.length > 0) {
                    this.currentLibrary = this.libraries[0].id
                }
            } else {
                this.assets = this.items
            }
        },
        setAssets: function (id) {
            let selected = this.libraries.filter(library => library.id ==
                id)[0]
            let type = this.type != 'mix' ? this.type : selected.type
            this.mediaType = type
            this.counter = 0
            if (selected) {
                switch (type) {
                case 'videos':
                    this.counter = selected.videos.length
                    this.assets = selected.videos
                    break;
                case 'audios':
                    this.counter = selected.audios.length
                    this.assets = selected.audios
                    break;
                default:
                    this.counter = selected.medias.length
                    this.assets = selected.medias
                }
            }
            this.counter = this.assets.length
        },
        selected: function (index) {
            if (this.hasSubLibraries) {
                this.$emit('selected', index, this.currentLibrary)
            } else {
                this.$emit('selected', index)
            }
        },
        assetEnter: function (el, done) {
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
        assetLeave: function (el, done) {
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
        setLibraryHeight: function (h = false) {
            let container, el, title, assets, titleSize, headSize,
                containerH, height
            container = this.$refs.container
            el = this.$refs.head
            title = this.$refs.title.$refs.title
            assets = this.$refs.assets
            titleSize = SizeUtility.get(title)
            headSize = SizeUtility.get(el)
            containerH = SizeUtility.get(container)
                .hClean
            console.log('inside library', containerH);
            if (h && h > containerH) {
                containerH = h
            }
            height = containerH - titleSize.h - titleSize.marginY
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
            // console.log(container);
        },
        ready: function () {
            this.counter--
        }
    },
    created: function () {
        this.mediaType = this.type
        this.init()
    },
    mounted: function () {
        this.$nextTick(this.setLibraryHeight)
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-app-library {
    width: 100%;
    min-height: 100%;
    min-height: 450px;
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

    &--green {
        background-color: $green;
    }

    &--yellow {
        background-color: $yellow;
    }

    &--red {
        background-color: $red;
    }
}
</style>
