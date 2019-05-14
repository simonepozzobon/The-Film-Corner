<template lang="html">
    <ui-container class="network-container" :contain="true">
        <ui-row>
            <net-item
                v-for="item in items"
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
                    // this.$nextTick(this.debug)
                }
            })
        },
        debug: function() {
            console.log('qui', this.items);
            for (var key in this.items) {
                if (this.items.hasOwnProperty(key)) {
                    console.log(key, this.items[key].content.media_type, this.items[key].content.thumb);
                }
            }
        }
    },
    created: function() {
        this.getData()
        this.$root.space = true
        this.$root.isNetwork = true
    },
    mounted: function() {
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
