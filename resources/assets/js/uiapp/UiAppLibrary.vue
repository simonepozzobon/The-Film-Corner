<template>
<div
    ref="container"
    class="ua-library"
    :class="colorClass"
>
    <div
        ref="head"
        class="ua-library__head"
    >
        <ui-title
            ref="title"
            :title="this.$root.getCmd(title)"
            :has-padding="false"
        />
        <div
            ref="select"
            class="ua-library__libraries row no-gutters"
            v-if="hasSubLibraries"
        >
            <label class="col-4">{{ this.$root.getCmd('select_from') }}</label>
            <select
                class="form-control ua-library__select col-8"
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
        class="ua-library__assets"
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
        class="ua-library__assets"
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
        class="ua-library__assets"
        v-else-if="mediaType == 'uploads'"
    >
        <upload-form
            :app-id="appId"
            :accept="accept"
            @uploaded="addToLibrary"
        />

        <transition-group
            tag="div"
            @enter="assetEnter"
            @leave="assetLeave"
        >
            <div
                v-for="(asset, i) in assets"
                :key="asset.id"
            >
                <library-item-audio
                    v-if="asset.type == 'audio'"
                    :delay="i"
                    :index="asset.id"
                    :title="asset.title"
                    @selected="selected"
                    @ready="ready"
                />
                <library-item-video
                    v-else
                    :delay="i"
                    :index="asset.id"
                    :title="asset.title"
                    :img="asset.img | fixImgPath"
                    @selected="selected"
                    @ready="ready"
                />
            </div>

        </transition-group>
    </div>

    <div
        ref="assets"
        class="ua-library__assets"
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
import UploadForm from './sub/library/UploadForm.vue'
import {
    UiTitle
}
from '../ui'

import {
    TweenMax
}
from 'gsap/all'

export default {
    name: 'UiAppLibrary',
    components: {
        LibraryItem,
        LibraryItemAudio,
        LibraryItemVideo,
        UploadForm,
        UiTitle,
    },
    props: {
        title: {
            type: String,
            default: 'library',
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
            default: function () {
                return []
            },
        },
        color: {
            type: String,
            default: 'green'
        },
        hasUpload: {
            type: Boolean,
            default: false,
        },
        appId: {
            type: Number,
            default: 0,
        },
        accept: {
            type: String,
            default: 'video/*',
        },
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
            return 'ua-library--' + this.color
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
            console.log('initialized', this.items, this.hasSubLibraries);
            if (this.hasSubLibraries) {
                this.libraries = this.items
                if (this.libraries.length > 0) {
                    this.currentLibrary = this.libraries[0].id
                }
            }
            else {
                this.assets = this.items
            }
        },
        setAssets: function (id) {
            let selected = this.libraries.filter(library => library.id == id)[0]
            let type = this.type != 'mix' ? this.type : selected.type
            this.mediaType = type
            this.counter = 0
            console.log('selected', selected);
            if (selected) {
                switch (type) {
                case 'videos':
                    // console.log(selected);
                    this.counter = selected.videos.length
                    this.assets = selected.videos
                    break;
                case 'audios':
                    this.counter = selected.audios.length
                    this.assets = selected.audios
                    break;
                case 'uploads':
                    // console.log(this.counter);
                    this.assets = selected.videos
                    break;
                default:
                    this.counter = selected.medias.length
                    this.assets = selected.medias

                    console.log('dentro', this.assets);
                }
            }
            this.counter = this.assets.length
        },
        selected: function (index) {
            if (this.hasSubLibraries) {
                console.log('has sub libraries');
                this.$emit('selected', index, this.currentLibrary)
            }
            else {
                console.log('no sub libraries');
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
            this.$nextTick(() => {
                let container, el, title, assets, titleSize, headSize,
                    containerSize, containerH, height, select, selectSize

                container = this.$refs.container
                el = this.$refs.head
                title = this.$refs.title.$refs.title
                assets = this.$refs.assets
                titleSize = SizeUtility.get(title)
                headSize = SizeUtility.get(el)
                containerSize = SizeUtility.get(container)
                containerH = containerSize.hClean
                // console.log(h, containerH);

                if (h && h > containerH) {
                    containerH = h
                }


                height = containerH - titleSize.h - titleSize.marginY

                if (this.hasSubLibraries) {
                    select = this.$refs.select
                    selectSize = SizeUtility.get(select)
                    // console.log('select', selectSize);
                    height = height - selectSize.h - (selectSize.marginY * 2) - 10
                }

                let startHeight = this.libraryHeight
                height = Math.round(height)
                // console.log('dentro', startHeight, height, h);

                if (startHeight != height) {
                    this.libraryHeight = height

                    TweenMax.fromTo(assets, .4, {
                        height: startHeight,
                        autoAlpha: 0,
                    }, {
                        height: height,
                        autoAlpha: 1,
                        onComplete: () => {
                            // console.log('dentro completp', this.libraryHeight, height);
                            // this.libraryHeight = height
                        }
                    })
                }
            })
            // console.log(container);
        },
        ready: function () {
            this.counter--
        },
        addToLibrary: function (file) {
            // console.log('uplaod', file);
            let newUpload = {
                id: this.assets.length,
                type: file.hasOwnProperty('type') ? file.type : 'video',
                title: file.title,
                img: file.img,
                duration: file.duration,
                videoSrc: file.src,
                src: file.src.replace('/storage/', '')
            }
            this.assets.push(newUpload)
            this.$emit('uploaded', newUpload)
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

.ua-library {
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
