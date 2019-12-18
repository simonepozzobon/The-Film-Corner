<template>
<block-panel title="Traduzioni Titolo">
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

export default {
    name: 'TraduzioniClip',
    components: {
        BlockPanel,
        TextInput,
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
            languages: ['it', 'en', 'fr', 'sr', 'sl', 'ka']
        }
    },
    watch: {
        title: function (title) {
            this.values.it = title
        },
        initials: function () {
            this.setInitials()
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
        updateValue: function (value, key) {
            this.values[key] = value
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
