<template lang="html">
    <ui-row class="pb-4 ui-accordion-cols">
        <div class="col-md-6">
            <ui-accordion-single
                v-for="keyword in cols.left"
                :key="keyword.id"
                :idx="keyword.id"
                :title="keyword.name"
                :content="keyword.description"/>
        </div>
        <div class="col-md-6">
            <ui-accordion-single
                v-for="keyword in cols.right"
                :key="keyword.id"
                :idx="keyword.id"
                :title="keyword.name"
                :content="keyword.description"/>
        </div>
    </ui-row>
</template>

<script>
import UiAccordionSingle from './UiAccordionSingle.vue'
import UiBlock from './UiBlock.vue'
import UiRow from './UiRow.vue'

export default {
    name: 'UiAccordionCols',
    components: {
        UiAccordionSingle,
        UiBlock,
        UiRow,
    },
    props: {
        keywords: {
            type: Array,
            default: function() {}
        }
    },
    data: function() {
        return {
            isOpen: false,
            cols: {
                left: [],
                right: [],
            }
        }
    },
    watch: {
        'keywords': function(keywords) {

        }
    },
    methods: {
        split: function() {
            let half = Math.ceil(this.keywords.length / 2)
            this.cols = {
                left: this.keywords.slice(0, half),
                right: this.keywords.slice(half, this.keywords.length)
            }
            console.log(this.cols);
        }
    },
    mounted: function() {
        this.split()
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-accordion-cols {
    padding-left: $spacer * 4;
    padding-right: $spacer * 4;
}
</style>
