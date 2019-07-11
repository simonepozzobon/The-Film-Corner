<template lang="html">
    <div class="modal fade" ref="modal">
        <div :class="'modal-dialog modal-' + this.size" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" v-if="this.title">{{ title }}</h4>
                    <button type="button" class="close ml-auto" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <slot></slot>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" @click="sendBtn">{{ sendButton }}</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ cancelButton }}</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'UiModal',
    props: {
        title: {
            type: String,
            default: null,
        },
        size: {
            type: String,
            default: 'md'
        },
        sendButton: {
            type: String,
            default: 'Send'
        },
        cancelButton: {
            type: String,
            default: 'Cancel'
        },
    },
    methods: {
        show: function() {
            $(this.$refs.modal).modal('show')
        },
        hide: function() {
            $(this.$refs.modal).modal('hide')
        },
        sendBtn: function() {
            this.$emit('send')
        }
    }
}
</script>

<style lang="css" scoped>
</style>
