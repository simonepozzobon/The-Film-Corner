<template lang="html">
    <div class="pro-student">
        <div class="pro-student__badge">
            <div class="pro-student__initials">
                {{ initials }}
            </div>
        </div>
        <div class="pro-student__name">
            {{ name }}
        </div>
        <div class="pro-student__surname" v-if="surname">
            {{ surname }}
        </div>
    </div>
</template>

<script>
export default {
    name: 'ProStudent',
    props: {
        name: {
            type: String,
            default: null,
        },
        surname: {
            type: String,
            default: null,
        },
    },
    computed: {
        initials: function() {
            if (this.surname) {
                return this.name.substring(0, 1) + this.surname.substring(0, 1)
            }

            return this.name.substring(0, 2)
        },
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.pro-student {
    flex: 0 0 50%;
    max-width: 50%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    margin-top: $spacer * 1.618;

    &__name,
    &__surname {
        font-weight: 500;
    }

    &__badge {
        position: relative;
        width: $spacer * 3 * 1.618;
        height: $spacer * 3 * 1.618;
        background-color: $black;
        @include border-radius(50%);
        // position: absolute;
    }

    &__initials {
        color: $white;
        font-size: $h4-font-size;
        text-transform: uppercase;
        font-weight: $font-weight-bold;
        line-height: 1;
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
    }
}
</style>
