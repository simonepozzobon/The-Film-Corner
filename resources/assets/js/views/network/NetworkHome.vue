<template lang="html">
    <ui-container class="network-container" :contain="true">
        <ui-row>
            <net-item
                v-for="item in this.sorted"
                :key="item.id"
                :idx="item.id"
                :title="item.title"
                :color="item.app.category.color_class"
                :category="item.app.category.name"
                :category-slug="item.app.category.slug"
                :app-name="item.app.title"
                :comments="item.comments.length"
                :likes="item.likes.length"
                :views="item.views"
                :preview-type="item.content.media_type"
                :preview-src="item.content.thumb"/>
        </ui-row>
    </ui-container>
</template>

<script>
import { UiContainer, UiRow } from '../../ui'
import { NetItem } from '../../uinet'
export default {
    name: 'NewtworkHome',
    components: {
        UiContainer,
        NetItem,
        UiRow,
    },
    data: function() {
        return {
            items: [],
            sorted: []
        }
    },
    methods: {
        getData: function() {
            this.$http.get('/api/v2/get-network').then(response => {
                if (response.data.success) {
                    this.items = response.data.items
                    this.sorted = this.items
                    // this.$nextTick(this.debug)
                }
            })
        },
        sortByDate: function() {
            this.sorted = Object.keys(this.items).map(key => this.items[key]).sort((a,b) => {
                return new Date(b.created_at) - new Date(a.created_at)
            })
        },
        sortByLikes: function() {
            this.sorted = Object.keys(this.items).map(key => this.items[key]).sort((a,b) => {
                return new Date(b.likes.length) - new Date(a.likes.length)
            })
        },
        debug: function() {
            this.sortByLikes()
        }
    },
    created: function() {
        this.getData()
        this.$root.space = true
        this.$root.isNetwork = true
    },
    mounted: function() {
        this.$root.$on('sort-by-date', () => {
            this.sortByDate()
        })
        this.$root.$on('sort-by-likes', () => {
            this.sortByLikes()
        })
    },
    beforeDestroy: function() {
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
