<template>
<div
    class="toast"
    :class="[statusClass]"
    role="alert"
    aria-live="assertive"
    aria-atomic="true"
    data-animation="true"
>
    <div class="toast-header">
        <svg
            class="toast__status"
            viewBox="0 0 32 32"
        >
            <rect
                class="toast__color"
                fill-rule="nonzero"
                x="0"
                y="0"
                width="32"
                height="32"
                rx="5"
            />
        </svg>
        <strong class="mr-auto">{{ title }}</strong>
        <small class="text-muted">{{ date }}</small>
        <button
            type="button"
            class="ml-2 mb-1 close"
            data-dismiss="toast"
            aria-label="Close"
        >
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="toast-body">
        Hello, world! This is a toast message.
    </div>
</div>
</template>

<script>
import moment from 'moment'
export default {
    name: 'Toast',
    props: {
        title: {
            type: String,
            default: 'Titolo',
        },
        message: {
            type: String,
            default: 'Message',
        },
        status: {
            type: String,
            default: 'success',
        }
    },
    data: function () {
        return {
            date: moment()
                .fromNow()
        }
    },
    computed: {
        statusClass: function () {
            if (this.status) {
                return 'toast--' + this.status
            }
        },
    },
    methods: {
        updateTime: function () {
            this.date = moment()
                .fromNow()
        }
    },
}
</script>

<style lang="scss">
@import '~styles/shared';
.toast {
    $self: &;

    &__status {
        margin-right: $spacer;
        width: $spacer;
    }

    &--success & {
        &__color {
            fill: $success;
        }
    }
}
</style>
