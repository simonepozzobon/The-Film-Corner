<template>
<block-panel
    title="Traduzioni Approfondimenti"
    :has-footer="true"
>
    <traduzioni
        ref="it"
        title="Italiano"
        class="mt-0"
        :initials="values.it"
        @update="update($event, 'it')"
    />
    <traduzioni
        ref="en"
        title="English"
        class="mt-4"
        :initials="values.en"
        @update="update($event, 'en')"
    />
    <traduzioni
        ref="fr"
        title="Francais"
        class="mt-4"
        :initials="values.fr"
        @update="update($event, 'fr')"
    />
    <traduzioni
        ref="sr"
        title="Serbian"
        class="mt-4"
        :initials="values.sr"
        @update="update($event, 'sr')"
    />
    <traduzioni
        ref="ka"
        title="Georgiano"
        class="mt-4"
        :initials="values.ka"
        @update="update($event, 'ka')"
    />
    <traduzioni
        ref="sl"
        title="Slovenian"
        class="mt-4"
        :initials="values.sl"
        @update="update($event, 'sl')"
    />

    <template v-slot:footer>
        <ui-button
            title="salva"
            color="green"
            theme="outline"
            :disable="isLoading"
            :has-spinner="isLoading"
            :has-margin="false"
            :has-container="false"
            @click="save"
        />
    </template>
</block-panel>
</template>

<script>
import {
    BlockPanel,
    Container,
    FileInput,
    ImagePreview,
    SwitchInput,
    TextEditor,
    TextInput,
    Select2Input,
}
from '../../adminui'


import {
    UiButton,
    UiTitle,
}
from '../../../ui'

import Traduzioni from './approfondimenti/Traduzioni.vue'

export default {
    name: 'TraduzioniApprofondimenti',
    components: {
        BlockPanel,
        Container,
        TextEditor,
        UiTitle,
        Traduzioni,
        UiButton,
    },
    props: {
        clip: {
            type: Object,
            default: function () {
                return {}
            },
        },
        initials: {
            type: Object,
            default: function () {
                return {}
            },
        },
        current: {
            type: Object,
            default: function () {
                return {}
            },
        },
    },
    data: function () {
        return {
            isLoading: false,
            values: {
                it: {},
                en: {},
                fr: {},
                sr: {},
                sl: {},
                ka: {},
            },
            languages: ['it', 'en', 'fr', 'sr', 'sl', 'ka'],
            keys: [
                'tech_info',
                'abstract',
                'historical_context',
                'foods',
            ],
        }
    },
    watch: {
        initials: function () {
            this.setInitials()
        },
        clip: function () {
            this.setClip()
        },
        current: function () {
            this.setCurrent()
        },
    },
    methods: {
        setCurrent: function () {
            let current = Object.assign({}, this.values.it)
            for (let i = 0; i < this.keys.length; i++) {
                let key = this.keys[i]
                if (this.current.hasOwnProperty(key)) {
                    current[key] = this.current[key]
                }
            }
            this.values.it = current
        },
        setInitials: function () {

        },
        setClip: function () {
            // console.log('clipì', this.clip);
            if (this.clip && this.clip.details && this.clip.details.hasOwnProperty('translations')) {
                let translations = this.clip.details.translations
                for (let i = 0; i < translations.length; i++) {

                    let current = translations[i]
                    let locale = current.locale

                    let cache = {}

                    for (let j = 0; j < this.keys.length; j++) {
                        let key = this.keys[j]
                        if (current.hasOwnProperty(key)) {
                            cache[key] = current[key]
                        }
                    }

                    this.values[locale] = cache
                    // console.log('clipì', this.values);
                }
            }
        },
        update: function (obj, locale) {
            this.values[locale] = Object.assign({}, obj)
        },
        save: function () {
            this.isLoading = true
            let data = new FormData()
            let translations = []

            data.append('id', this.clip.id)

            for (let key in this.values) {
                if (this.values.hasOwnProperty(key) && this.values[key] && Object.keys(this.values[key]).length > 0) {
                    translations.push({
                        locale: key,
                        value: this.values[key]
                    })
                }
            }
            data.append('translations', JSON.stringify(translations))

            this.$http.post('/api/v2/admin/clips/translations/details', data).then(response => {
                this.isLoading = false
                this.$emit('saved', response.data.clip)
            }).catch(() => {
                this.isLoading = false
            })
        },
    },
    mounted: function () {
        this.setClip()
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.content-block {
    $color: $gray-100;

    &__title {
        display: inline-block;
        color: darken($color, 50);
        letter-spacing: 12px;
        padding: 0;
        // @include title-text-shadow(12px, 1px, 1px, 2px, 0.33);
    }

    &__container {
        margin-top: $spacer * 2;
    }
}
</style>
