<template lang="html">
    <div class="row no-gutters">
        <div class="col">
            <div class="row pt-5" v-if="this.title">
                <div class="col pt-5 px-5">
                    <h1 align="center">{{ title }}</h1>
                </div>
            </div>
            <div class="row pb-5" v-if="this.title">
                <div class="col-6 offset-3">
                    <hr>
                </div>
            </div>
            <div class="row" v-if="this.title">
                <div class="col-md-10 offset-md-1">
                    <slot></slot>
                </div>
            </div>
            <div class="row pt-5 px-5" v-else>
                <div class="col-md-10 offset-md-1">
                    <slot></slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'UiBlock',
    props: {
        title: {
            type: String,
            default: null
        }
    }
}
</script>

<style lang="scss">
@import '~styles/shared';
</style>
