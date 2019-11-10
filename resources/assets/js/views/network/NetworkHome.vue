<template>
<ui-container
    class="network-container"
    :contain="true"
>
    <ui-row>
        <net-item
            v-for="item in this.sorted"
            :key="item.id"
            :idx="item.id"
            :title="item.title"
            :color="item.app.category | getColorClass"
            :category="item.app.category | translate('name', $root.locale)"
            :category-slug="item.app.category | getSlug"
            :app-name="item.app | translate('title', $root.locale)"
            :comments="item.comments.length"
            :likes="item.likes.length"
            :views="item.views"
            :preview-type="item.content.media_type"
            :preview-src="item.content.thumb"
        />
    </ui-row>
</ui-container>
</template>

<script>
import {
    UiContainer,
    UiRow
}
from '../../ui'
import {
    NetItem
}
from '../../uinet'

import TranslationFilter from '../../TranslationFilter'

export default {
    name: 'NewtworkHome',
    mixins: [TranslationFilter],
    components: {
        UiContainer,
        NetItem,
        UiRow,
    },
    data: function () {
        return {
            items: [],
            sorted: []
        }
    },
    methods: {
        getData: function () {
            this.$http.get('/api/v2/get-network').then(response => {
                let itemsArr = Object.assign([], response.data.items)
                let filtered = itemsArr.filter(item => item != null)

                if (response.data.success) {
                    this.items = filtered
                    this.sorted = filtered
                    this.$nextTick(this.debug)
                }
            })
        },
        sortByDate: function () {
            console.log('sorting by date');
            this.sorted = Object.keys(this.items).map(key => this.items[key]).sort((a, b) => {
                return new Date(b.created_at) - new Date(a.created_at)
            })
        },
        sortByLikes: function () {
            console.log('sorting by likes');
            this.sorted = Object.keys(this.items).map(key => this.items[key]).sort((a, b) => {
                return new Date(b.likes.length) - new Date(a.likes.length)
            })
        },
        debug: function () {
            this.sortByLikes()
        }
    },
    filters: {
        getColorClass: function (category) {
            if (category.hasOwnProperty('color_class')) {
                return category.color_class
            }
            return 'green'
        },
        getName: function (category) {
            if (category.hasOwnProperty('name')) {
                return category.name
            }
            return 'no category'
        },
        getSlug: function (category) {
            if (category.hasOwnProperty('slug')) {
                return category.slug
            }
            return 'no-slug'
        },
    },
    created: function () {
        this.getData()
        this.$root.space = true
        this.$root.isNetwork = true
    },
    mounted: function () {
        this.$root.$on('sort-by-date', () => {
            this.sortByDate()
        })
        this.$root.$on('sort-by-likes', () => {
            this.sortByLikes()
        })
    },
    beforeDestroy: function () {
        this.$root.space = false
        this.$root.isNetwork = false
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.network-container {
    padding-top: $spacer * 8;
}
</style>
