<template lang="html">
    <div class="ui-hero-banner" ref="bg">
        <img :src="image" alt="" class="ui-hero-banner__bg" ref="image">
        <div class="ui-hero-banner__container">
            <div class="ui-hero-banner__content">
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'UiHeroBanner',
    props: {
        image: {
            type: String,
            default: null
        }
    },
    watch: {
        '$root.isMobile': function(value) {
            console.log(value);
            if (value) {
                this.$refs.bg.style.backgroundImage = 'url('+ this.image +')'
            } else {
                this.$refs.bg.style.backgroundImage = null
            }
        }
    },
    mounted: function() {
    }
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.ui-hero-banner {
    min-width: 100vw;
    height: 100%;
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;

    &__bg {
        display: none;
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
        padding-top: $spacer * 2;
        padding-bottom: $spacer * 2;
    }


    @include media-breakpoint-up('sm'){
        position: relative;

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
            padding-top: $spacer * 2;
            padding-bottom: $spacer * 2;
        }
    }
}
</style>
