<template lang="html">
    <div class="ui-app-library">
        <ui-title :title="title" :has-padding="false"/>
        <div class="ui-app-library__libraries" v-if="hasSubLibraries">
            <select class="form-control ui-app-library__select" v-model="currentLibrary">
                <option
                    v-for="library in liraries"
                    :key="library.id"
                    :value="library.id">
                    {{ library.name }}
                </option>
            </select>
        </div>
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
</template>

<script>
import LibraryItem from './sub/library/LibraryItem.vue'
import { UiTitle } from '../ui'

export default {
    name: 'UiAppLibrary',
    components: {
        LibraryItem,
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
            liraries: [],
            currentLibrary: 0,
            assets: [],
            animationsController: [],
            animationsCache: [],
        }
    },
    watch: {
        'currentLibrary': function(id) {
            let selected = this.liraries.filter(library => library.id == id)[0]
            if (selected) {
                this.assets = selected.medias
            }
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
                this.liraries = this.items
                if (this.liraries.length > 0) {
                    this.assets = this.liraries[0].medias
                    this.currentLibrary = this.liraries[0].id
                }
            } else {
                this.assets = this.items
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
        }
    },
    created: function() {
        this.init()
    },
    mounted: function() {
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
}
</style>
