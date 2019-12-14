<template>
<div
    class="modal fade"
    ref="modal"
>
    <div
        class="modal-dialog"
        :class="modalSizeClass"
        role="document"
    >
        <div class="modal-content">
            <div
                class="modal-header"
                v-if="!hideHeader"
            >
                <h4
                    class="modal-title"
                    v-if="this.title"
                >
                    {{ title }}
                </h4>
                <button
                    type="button"
                    class="close ml-auto"
                    data-dismiss="modal"
                    aria-label="Close"
                >
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <slot></slot>
            </div>
            <div
                class="modal-footer"
                v-if="!hideFooter"
            >
                <button
                    type="button"
                    class="btn btn-primary"
                    @click="sendBtn"
                >
                    {{ sendButton }}
                </button>
                <button
                    type="button"
                    class="btn btn-secondary"
                    data-dismiss="modal"
                >
                    {{ cancelButton }}
                </button>
            </div>
        </div>
    </div>
</div>
</template>

<script>
import $ from 'jquery'
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
        hideFooter: {
            type: Boolean,
            default: false,
        },
        hideHeader: {
            type: Boolean,
            default: false,
        },
    },
    computed: {
        modalSizeClass: function () {
            return 'modal-' + this.size
        },
    },
    methods: {
        show: function () {
            $(this.$refs.modal).modal('show')
        },
        hide: function () {
            $(this.$refs.modal).modal('hide')
        },
        sendBtn: function () {
            this.$emit('send')
        }
    },
    mounted: function () {
        $(this.$refs.modal).on('hide.bs.modal', () => {
            this.$emit('hidden')
        })
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.modal-content {
    background: none;
    border: none;
}
.modal-body {
    padding: 0;
}
</style>
