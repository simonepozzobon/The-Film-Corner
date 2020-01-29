<template>
<div
    class="modal fade"
    ref="modal"
    data-backdrop="false"
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
            <div
                class="modal-footer"
                v-if="simpleFooter"
            >
                <ui-button
                    title="chiudi"
                    color="red"
                    theme="outline"
                    size="sm"
                    @click="hide"
                />
            </div>
        </div>
    </div>
</div>
</template>

<script>
import $ from 'jquery'
import UiButton from '../../ui/UiButton.vue'

export default {
    name: 'UiModal',
    components: {
        UiButton,
    },
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
        simpleFooter: {
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

<style lang="scss">
@import '~styles/shared';

.modal {
    position: fixed;
}

.modal-backdrop.show {
    z-index: 1040;
}

.modal-content {
    background: none;
    border: none;
    z-index: 1050;
    box-shadow: none;
}
.modal-body {
    padding: 0;
}
.modal-footer {
    justify-content: space-around;
    background-color: $white;

}
</style>
