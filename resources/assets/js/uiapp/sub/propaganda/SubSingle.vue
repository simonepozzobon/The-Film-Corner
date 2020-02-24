<template>
<div class="ua-depth-single">
    <sub-dropdown
        v-if="hasChildren"
        :title="title"
        :items="childrens"
        @open-sub="openSub"
    />
    <a
        v-else
        href="#"
        @click.stop.prevent="openDepth"
        class="ua-depth-single__link"
    >
        {{ title }}
    </a>

</div>
</template>

<script>
import SubDropdown from './SubDropdown.vue'

export default {
    name: 'SubSingle',
    components: {
        SubDropdown,
    },
    props: {
        idx: [Number, String],
        hasChildren: {
            type: Boolean,
            default: false,
        },
        childrens: {
            type: Array,
            default: function () {
                return []
            },
        },
        sub: {
            type: Object,
            default: function () {
                return {}
            }
        }
    },
    data: function () {
        return {}
    },
    computed: {
        title: function () {
            let keys = ['tech_info', 'abstract', 'historical_context', 'foods']
            let titles = [{
                    key: 'tech_info',
                    title: 'Tecnical Informations'
                },
                {
                    key: 'abstract',
                    title: 'Abstract'
                },
                {
                    key: 'historical_context',
                    title: 'Historical Context'
                },
                {
                    key: 'foods',
                    title: 'Foods for thoughts'
                }
            ]

            if (this.sub && this.sub.hasOwnProperty('title')) {
                return this.sub.title
            }
            else if (this.sub && keys.includes(this.sub.key)) {
                let obj = titles.find(title => title.key == this.sub.key)
                if (obj) {
                    return obj.title
                }

                return 'not-found'
            }

            return 'no-title'
        },
    },
    methods: {
        openDepth: function () {
            this.$emit('open-modal', this.idx, null)
        },
        openSub: function (id) {
            console.log('dentro', this.idx, id);
            this.$emit('open-modal', this.idx, id)
        }
    },
    // mounted: function () {
    //     console.log('sub', this.sub);
    // },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ua-depth-single {
    &__link {
        font-size: $font-size-lg;
        font-weight: bold;
        color: $black;
    }
}
</style>
