<template>
<block-panel
    title="Informazioni Clip"
    :initial-state="initialState"
>
    <div class="a-clip-panel__row form-group row">
        <label
            for="period"
            class="col-md-1"
        >
            Periodo
        </label>
        <div class="col-md-11">
            <select-2-input
                :multiple="false"
                :options="this.options.periods"
                :setValue="this.period"
                @update="updateField($event, 'period')"
                @remove="removeValue($event, 'period')"
            />
        </div>
    </div>

    <div class="a-clip-panel__row form-group row">
        <label
            for="directors"
            class="col-md-1"
        >
            Registi
        </label>
        <div class="col-md-5">
            <select-2-input
                :options="this.options.directors"
                :setValue="this.directors"
                @update="updateField($event, 'directors', true)"
                @remove="removeValue($event, 'directors', true)"
            />
        </div>
        <label
            for="peoples"
            class="col-md-1"
        >
            Interpreti
        </label>
        <div class="col-md-5">
            <select-2-input
                :options="this.options.peoples"
                :setValue="this.peoples"
                @update="updateField($event, 'peoples', true)"
                @remove="removeValue($event, 'peoples', true)"
            />
        </div>
    </div>

    <div class="a-clip-panel__row form-group row">
        <label
            for="year"
            class="col-md-1"
        >
            Anno
        </label>
        <div class="col-md-3">
            <input
                type="text"
                name="year"
                class="form-control"
                v-model="year"
            />
        </div>

        <label
            for="format"
            class="col-md-1"
        >
            Formato
        </label>
        <div class="col-md-3">
            <select-2-input
                :multiple="false"
                :options="this.options.formats"
                :setValue="this.format"
                @update="updateField($event, 'format')"
                @remove="removeValue($event, 'format')"
            />
        </div>
        <label
            for="age"
            class="col-md-1"
        >
            Età
        </label>
        <div class="col-md-3">
            <select-2-input
                :multiple="false"
                :setValue="this.age"
                :options="this.options.ages"
                @update="updateField($event, 'age')"
                @remove="removeValue($event, 'age')"
            />
        </div>
    </div>

    <div class="a-clip-panel__row form-group row">
        <label
            for="genre"
            class="col-md-1"
        >
            Genere
        </label>
        <div class="col-md-5">
            <select-2-input
                :multiple="false"
                :setValue="this.genre"
                :options="this.options.genres"
                @update="updateField($event, 'genre')"
            />
        </div>
        <label
            for="nationality"
            class="col-md-1"
        >
            Nazionalità
        </label>
        <div class="col-md-5">
            <input
                type="text"
                name="nationality"
                class="form-control"
                v-model="nationality"
            />
        </div>
    </div>

    <div class="a-clip-panel__row form-group row">
        <label
            for="topics"
            class="col-md-1"
        >
            Argomenti
        </label>
        <div class="col-md-11">
            <select-2-input
                :options="this.options.topics"
                :setValue="this.topics"
                @update="updateField($event, 'topics', true)"
                @remove="removeValue($event, 'topics', true)"
            />
        </div>
    </div>
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

export default {
    name: 'Informazioni',
    components: {
        BlockPanel,
        Container,
        FileInput,
        ImagePreview,
        SwitchInput,
        TextEditor,
        TextInput,
        UiButton,
        UiTitle,
        Select2Input,
    },
    props: {
        options: {
            type: Object,
            default: function () {
                return {}
            },
        },
        initialState: {
            type: Boolean,
            default: false,
        },
        initial: {
            type: Object,
            default: function () {
                return {}
            },
        },
    },
    data: function () {
        return {
            period: null,
            year: null,
            nationality: null,
            directors: [],
            peoples: [],
            format: null,
            age: null,
            genre: null,
            topics: [],
        }
    },
    watch: {
        period: function (period) {
            this.$emit('update', 'period', period)
        },
        year: function (year) {
            this.$emit('update', 'year', year)
        },
        nationality: function (nationality) {
            this.$emit('update', 'nationality', nationality)
        },
        initial: function (init) {
            console.log('trr', init);

            this.$nextTick(() => {
                this.setInit()
            })
        },
    },
    computed: {
        hasInitial: function () {
            return this.initial ? true : false
        },
    },
    methods: {
        setInit: function () {
            let obj = this.initial
            this.period = obj.period.id
            this.year = obj.year
            this.age = obj.age.id
            this.period = obj.period.id
            this.format = obj.format.id
            this.genre = obj.genre.id
            this.nationality = obj.nationality
        },
        updateField: function (e, key, isArray = false) {
            if (this.hasOwnProperty(key) && e) {
                if (isArray === true) {
                    if (e.hasOwnProperty('element')) {
                        this[key].push(e.element.text)
                    }
                    else {
                        this[key].push(e.text)
                    }
                }
                else {
                    if (e.hasOwnProperty('element')) {
                        if (e.id == '') {
                            this[key] = null
                        }
                        else {
                            this[key] = e.element.text
                        }
                    }
                    else {
                        this[key] = e.text
                    }
                }
                this.$emit('update', key, this[key])
            }
        },
        removeValue: function (e, key, isArray = false) {
            if (this.hasOwnProperty(key) && isArray == true) {

                let valueToCheck = e.text
                if (e.hasOwnProperty('element')) {
                    valueToCheck = e.element.text
                }

                let idx = this[key].findIndex(value => value == valueToCheck)
                if (idx > -1) {
                    this[key].splice(idx, 1)
                    this.$emit('update', key, this[key])
                }
            }
        },
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
