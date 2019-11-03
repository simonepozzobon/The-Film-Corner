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
        idx: {
            type: Number,
            default: 0,
        },
        title: {
            type: String,
            default: 'titolo',
        },
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
