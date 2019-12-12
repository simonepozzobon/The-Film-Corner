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
            <select
                class="form-control"
                name="period"
                v-model="period"
            >
                <option
                    v-for="period in this.options.periods"
                    :key="period.id"
                    :value="period.title"
                >{{ period.title }}</option>
            </select>
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
                ref="directors"
                :options="this.options.directors"
                @update="updateField($event, 'directors', true)"
                @remove="removeValue($event, 'directors', true)"
                @ready="selectIsReady('directors')"
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
                ref="peoples"
                :options="this.options.peoples"
                @update="updateField($event, 'peoples', true)"
                @remove="removeValue($event, 'peoples', true)"
                @ready="selectIsReady('peoples')"
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
                ref="format"
                :multiple="false"
                :options="this.options.formats"
                @update="updateField($event, 'format')"
                @remove="removeValue($event, 'format')"
                @ready="selectIsReady('format')"
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
                ref="age"
                :multiple="false"
                :options="this.options.ages"
                @update="updateField($event, 'age')"
                @remove="removeValue($event, 'age')"
                @ready="selectIsReady('age')"
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
                ref="genre"
                :multiple="false"
                :options="this.options.genres"
                @update="updateField($event, 'genre')"
                @ready="selectIsReady('genre')"
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
                ref="topics"
                :options="this.options.topics"
                @update="updateField($event, 'topics', true)"
                @remove="removeValue($event, 'topics', true)"
                @ready="selectIsReady('topics')"
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
        initials: {
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
            keys: [
                'period',
                'year',
                'nationality',
                'directors',
                'peoples',
                'format',
                'age',
                'genre',
                'topics',
            ]
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
        initials: function (initials) {
            for (let i = 0; i < this.keys.length; i++) {
                let key = this.keys[i]
                if (initials.hasOwnProperty(key)) {
                    if (typeof initials[key] == 'string') {
                        this[key] = initials[key]
                    }
                    // else if (initials[key].length) {
                    //     if (key == 'directors') {
                    //         let old = this[key]
                    //         for (let j = 0; j < initials[key].length; j++) {
                    //             let current = initials[key][j]
                    //             console.log('curernt', current);
                    //             this.$refs.directors.selectOption(current.id)
                    //         }
                    //
                    //         // this[key] = Object.assign([], old)
                    //         console.log('modificata', this[key]);
                    //     }
                    //
                    // }
                    // else {
                    //     this[key] = initials[key]
                    //     // console.log('no', key, this[key]);
                    // }
                    // console.log(this[key]);
                }
            }
        },
    },
    methods: {
        selectIsReady: function (key) {
            // se si tratta di un'array
            if (this.initials[key].length) {
                let old = this[key]
                for (let j = 0; j < this.initials[key].length; j++) {
                    let current = this.initials[key][j]
                    this.$refs[key].selectOption(current.id)
                }
            }
            // o se si tratta una singola selezione
            else {
                this.$refs[key].selectOption(this.initials[key].id)
            }
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
