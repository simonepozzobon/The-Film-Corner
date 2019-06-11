<template lang="html">
<div class="toasts">
    <!-- <toast
        v-for="(toast, i) in cache"
        ref="toast"
        :key="i"/> -->
</div>
</template>

<script>
import Toast from '../components/Toast.vue'
import VueNotifications from 'vue-notifications'
export default {
    name: 'Toasts',
    components: {
        Toast,
    },
    props: {
        notifications: {
            type: Array,
            default: function () {
                return []
            },
        },
    },
    data: function () {
        return {}
    },
    methods: {
        updateTimers: function () {
            setInterval(() => {
                this.$refs.toast.forEach(toast => {
                    toast.updateTime()
                })
            }, 1000)
        },
    },
    mounted: function () {
        // this.$swal('showSuccessMsghhello', 'contenuto', 'goo')
    },
}
</script>

<style lang="scss">
@import '~styles/shared';

.toasts {
    position: fixed;
    background-color: $green;
    z-index: $zindex-fixed;
    right: 0;
    top: 0;
}
</style>
