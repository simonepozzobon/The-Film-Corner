<template>
<div class="ua-depth-single">
    <sub-dropdown
        v-if="hasChildren"
        :title="title"
        :items="childrens"
    />
    <a
        v-else
        href="#"
        @click.prevent="openDepth"
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
