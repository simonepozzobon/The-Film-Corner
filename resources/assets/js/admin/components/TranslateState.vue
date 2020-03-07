<template>
<div class="translate-state">
    <div
        class="translate-state__lang"
        v-for="language in languages"
        :class="getState(language, item)"
        :key="language.id"
    >
        <div class="translate-state__text">
            {{ language.short }}
        </div>
    </div>
</div>
</template>

<script>
export default {
    name: 'TranslateState',
    props: {
        languages: {
            type: Array,
            default: function () {
                return []
            },
        },
        item: {
            type: Object,
            default: function () {
                return {}
            },
        },
    },
    data: function () {
        return {

        }
    },
    computed: {

    },
    methods: {
        getState: function (language, item) {
            let lang = language.short
            let translation = item.translations.find(translation => translation.locale == lang)

            let values = ['name', 'title', 'description']

            if (translation) {
                let check = true

                // verifica se almeno una delle proprietà da tradurre manca, la segna come non completa
                for (let i = 0; i < values.length; i++) {
                    if (translation.hasOwnProperty(values[i])) {
                        let value = translation[values[i]]
                        if (!value || value == '' || value == '<p></p>') {
                            check = false
                        }
                    }
                }

                if (check == false) {
                    return null
                }
                else {
                    return 'active'
                }

            }
            return null
        }
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.translate-state {
    display: flex;

    &__lang {
        position: relative;
        background-color: $danger;
        width: $spacer * 2;
        height: $spacer * 2;
        margin-right: $spacer / 2;
        @include border-radius(50%);
        @include custom-inner-shadow(darken($red, 25));

        &.active {
            background-color: $success;
            @include custom-inner-shadow(darken($green, 35));
        }
    }

    &__text {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        text-transform: uppercase;
        font-size: $font-size-sm;
        color: $white;
        font-weight: bold;
        letter-spacing: 1px;
    }
}
</style>
