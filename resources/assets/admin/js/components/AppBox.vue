<template>
<div :class="'box '+color">
    <div class="box-header">
        <div>{{title}}</div>
        <div class="box-tools">
            <slot name="tools" class="slot-tools"></slot>
        </div>
    </div>
    <div class="box-body">
        <slot></slot>
    </div>
</div>
</template>
<script>
export default {
    props: {
        title: {
            type: String,
            default: 'Title'
        },
        color: {
            type: String,
            default: 'gray'
        }
    },
    data: function() {
        return {

        }
    }
}
</script>
<style lang="scss" scoped>
    .box-header {
        align-items: center;

        .box-tools {
            margin-left: auto;

            > .slot-tools {
                display: flex;
            }
        }
    }
</style>
