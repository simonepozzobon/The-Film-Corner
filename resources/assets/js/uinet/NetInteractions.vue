<template>
<div
    class="net-actions"
    :class="colorClass"
>
    <div class="net-actions__action">
        <span class="net-actions__count">
            {{ views }}
        </span>
        <i
            class="fa fa-eye net-actions__icon"
            aria-hidden="true"
        />
    </div>
    <div
        class="net-actions__action"
        @click.stop.prevent="addLike"
    >
        <span class="net-actions__count">
            {{ likes }}
        </span>
        <i
            class="fa fa-heart net-actions__icon"
            aria-hidden="true"
        />
    </div>
    <!-- <div class="net-actions__action">
        <span class="net-actions__count">
            {{ comments }}
        </span>
        <i
            class="fa fa-comment net-actions__icon"
            aria-hidden="true"
        />
    </div> -->
</div>
</template>

<script>
export default {
    name: 'NetInteractions',
    props: {
        views: {
            type: Number,
            default: 0,
        },
        likes: {
            type: Number,
            default: 0,
        },
        comments: {
            type: Number,
            default: 0,
        },
        color: {
            type: String,
            default: 'white'
        },
        itemId: {
            type: Number,
            default: 0,
        },
    },
    computed: {
        colorClass: function () {
            return 'net-actions--' + this.color
        }
    },
    methods: {
        addLike: function () {
            let url = '/api/v2/like-network/' + this.itemId
            this.$http.get(url).then(response => {
                if (response.data.success) {
                    this.$emit('update:likes', response.data.likes)
                }
            })
        },
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.net-actions {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    padding: $spacer * 1.618 $spacer * 1.618 $spacer;
    font-size: $font-size-lg;

    &__action {
        display: flex;
        align-items: center;
        cursor: pointer;
    }

    &__count {
        padding-right: $spacer / 1.618;
    }

    &--white &__action {
        color: $white;
        transition: $transition-base;

        &:hover {
            color: $black;
            transition: $transition-base;
        }
    }

    &--dark &__action {
        color: $dark;
        transition: $transition-base;

        &:hover {
            color: $white;
            transition: $transition-base;
        }
    }
}
</style>
