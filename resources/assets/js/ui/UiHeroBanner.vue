<template>
    <div
        class="ui-hero-banner"
        :class="[fullHeightClass, fullWidthClass]"
        ref="bg"
    >
        <img :src="image" alt="" class="ui-hero-banner__bg" ref="image" />
        <div class="ui-hero-banner__container">
            <div class="ui-hero-banner__content">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "UiHeroBanner",
    props: {
        image: {
            type: String,
            default: null
        },
        fullHeight: {
            type: Boolean,
            default: false
        },
        fullWidth: {
            type: Boolean,
            default: false
        },
        relative: {
            type: Boolean,
            default: false
        }
    },
    watch: {
        "$root.isMobile": function(value) {
            if (value) {
                this.$refs.bg.style.backgroundImage = "url(" + this.image + ")";
            } else {
                this.$refs.bg.style.backgroundImage = null;
            }
        }
    },
    computed: {
        fullHeightClass: function() {
            if (this.fullHeight) {
                return "ui-hero-banner--full-height";
            }
        },
        fullWidthClass: function() {
            if (this.fullWidth) {
                return "ui-hero-banner--full-width";
            }
        },
        relativeClass: function() {
            if (this.relative) {
                return "ui-hero-banner__content--relative";
            }
        }
    },
    mounted: function() {}
};
</script>

<style lang="scss" scoped>
@import "~styles/shared";

.ui-hero-banner {
    $self: &;
    min-width: 100vw;
    height: 100%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;

    &__bg {
        display: none;
        // position: absolute;
    }

    &__container {
        width: 100%;
        height: 100%;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }

    &__content {
        padding: $spacer * 2;

        &--relative {
            position: relative;
        }
    }

    &--full-height {
        max-height: 40vh;
        min-height: 200px;
        // overflow: hidden;
    }

    @include media-breakpoint-up("sm") {
        position: relative;

        &--full-height {
            max-height: 40vh;
            min-height: 400px;
            // overflow: hidden;
        }

        &#{$self}--full-height &__bg {
            transform: translateY(-50%);
        }

        &__bg {
            display: block;
            width: 100%;
            height: 100%;
        }

        &__container {
            position: absolute;
            left: 0;
            top: 0;
        }

        &__content {
            padding: $spacer * 2;
        }

        &#{$self}--full-width &__content {
            width: 100%;
        }
    }
}
</style>
