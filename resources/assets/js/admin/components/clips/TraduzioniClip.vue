<template>
<block-panel
    title="Traduzioni Titolo"
    :has-footer="true"
>
    <text-input
        ref="it"
        label="Italiano"
        name="it"
        :initial="values.it"
        @update="updateValue($event, 'it')"
    />

    <text-input
        ref="en"
        label="English"
        name="en"
        :initial="values.en"
        @update="updateValue($event, 'en')"
    />

    <text-input
        ref="fr"
        label="Francais"
        name="fr"
        :initial="values.fr"
        @update="updateValue($event, 'fr')"
    />

    <text-input
        ref="sr"
        label="Serbian"
        name="sr"
        :initial="values.sr"
        @update="updateValue($event, 'sr')"
    />

    <text-input
        ref="ka"
        label="Georgiano"
        name="ka"
        :initial="values.ka"
        @update="updateValue($event, 'ka')"
    />

    <text-input
        ref="sl"
        label="Slovenian"
        name="sl"
        :initial="values.sl"
        @update="updateValue($event, 'sl')"
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
    UiButton
}
from '../../../ui'

export default {
    name: 'TraduzioniClip',
    components: {
        BlockPanel,
        TextInput,
        UiButton,
    },
    props: {
        title: {
            type: String,
            default: null,
        },
        initials: {
            type: Object,
            default: function () {
                return {}
            },
        },
        clip: {
            type: Object,
            default: function () {
                return {}
            },
        },
    },
    data: function () {
        return {
            values: {
                it: null,
                en: null,
                fr: null,
                sr: null,
                sl: null,
                ka: null,
            },
            languages: ['it', 'en', 'fr', 'sr', 'sl', 'ka'],
            isLoading: false,
        }
    },
    watch: {
        title: function (title) {
            this.values.it = title
        },
        initials: function () {
            this.setInitials()
        },
        clip: function (clip) {
            this.setClip()
        },
    },
    methods: {
        setInitials: function () {
            if (this.initials && this.initials.hasOwnProperty('translations')) {
                let translations = this.initials.translations

                for (let i = 0; i < translations.length; i++) {
                    let current = translations[i]
                    let locale = current.locale

                    this.values[locale] = current.title
                }
            }
        },
        setClip: function () {
            if (this.clip && this.clip.hasOwnProperty('translations')) {
                let translations = this.clip.translations

                for (let i = 0; i < translations.length; i++) {
                    let current = translations[i]
                    let locale = current.locale

                    this.values[locale] = current.title
                }
            }
        },
        updateValue: function (value, key) {
            this.values[key] = value
        },
        save: function () {
            this.isLoading = true

            let data = new FormData()
            let translations = []

            data.append('id', this.clip.id)

            for (let key in this.values) {
                if (this.values.hasOwnProperty(key) && this.values[key]) {
                    translations.push({
                        locale: key,
                        value: this.values[key]
                    })
                }
            }
            data.append('translations', JSON.stringify(translations))

            this.$http.post('/api/v2/admin/clips/translations/title', data).then(response => {
                this.isLoading = false
                this.$emit('saved', response.data.clip)
            }).catch(() => {
                this.isLoading = false
            })
        },
    },
    mounted: function () {
        this.setInitials()
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
