options<template>
<div class="a-clip-panel">
    <container padding="sm">
        <div class="a-clip-panel__topbar">
            <div class="admin-apps__select">
                <ui-title title="Nuova Clip" />
            </div>
        </div>
    </container>
    <container>
        <div class="form">
            <div class="a-clip-panel__group">
                <ui-title
                    title="Carica Clip"
                    tag="span"
                    font-size="h5"
                    :has-padding="false"
                    :has-margin="false"
                    :has-container="false"
                />
                <hr class="a-clip-panel__divider">

                <div class="a-clip-panel__row form-group row">
                    <label
                        for="title"
                        class="col-md-1"
                    >
                        Titolo
                    </label>
                    <div class="col-md-11">
                        <input
                            type="text"
                            name="title"
                            class="form-control"
                            v-model="title"
                        />
                    </div>
                </div>

                <file-input
                    label="Video"
                    name="video"
                    accept="video/mp4"
                    label-size="col-md-1"
                    input-size="col-md-11"
                />
            </div>

            <div class="a-clip-panel__group">
                <ui-title
                    title="Informazioni Clip"
                    tag="span"
                    font-size="h5"
                    :has-padding="false"
                    :has-margin="false"
                    :has-container="false"
                />
                <hr class="a-clip-panel__divider">

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
                                :value="period.id"
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
                        <select-2-input :options="this.options.directors" />
                    </div>
                    <label
                        for="peoples"
                        class="col-md-1"
                    >
                        Interpreti
                    </label>
                    <div class="col-md-5">
                        <select-2-input :options="this.options.peoples" />
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
                        <select-2-input :multiple="false"  :options="this.options.formats"/>
                    </div>
                    <label
                        for="age"
                        class="col-md-1"
                    >
                        Età
                    </label>
                    <div class="col-md-3">
                        <select-2-input :multiple="false"  :options="this.options.ages"/>
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
                      <select-2-input :options="this.options.genres" />
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
                            v-model="region"
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
                        <select-2-input :options="this.options.topics" />
                    </div>
                </div>
            </div>

            <clip-depth />

            <div class="a-clip-panel__group">
                <ui-title
                    title="Paratesti"
                    tag="span"
                    font-size="h5"
                    :has-padding="false"
                    :has-margin="false"
                    :has-container="false"
                />
                <hr class="a-clip-panel__divider">

                Paratesti
            </div>

            <div class="a-clip-panel__group">
                <ui-title
                    title="Esercizi"
                    tag="span"
                    font-size="h5"
                    :has-padding="false"
                    :has-margin="false"
                    :has-container="false"
                />
                <hr class="a-clip-panel__divider">

                <div class="a-clip-panel__row form-group row">
                    <label class="col-md-2">
                        Compare The Clips
                    </label>
                    <switch-input
                        label="Compare The Clips"
                        label-size="col-md-2"
                        input-size="col-md-1"
                        :has-row="false"
                    />
                    <label class="col-md-2 offset-md-1">
                        Frame Crop
                    </label>
                    <switch-input
                        label="Frame Crop"
                        label-size="col-md-2"
                        input-size="col-md-1"
                        :has-row="false"
                    />
                    <label class="col-md-2 offset-md-1">
                        Check The Sound
                    </label>
                    <switch-input
                        label="
                        Check
                        The
                        Sound"
                        label-size="col-md-2"
                        input-size="col-md-1"
                        :has-row="false"
                    />
                </div>
            </div>

        </div>

    </container>
</div>
</template>

<script>
import {
    Container,
    FileInput,
    ImagePreview,
    SwitchInput,
    TextEditor,
    TextInput,
    Select2Input,
}
from '../adminui'


import {
    UiButton,
    UiTitle,
}
from '../../ui'

import ClipDepth from '../components/ClipDepth.vue'


export default {
    name: 'ClipCreate',
    components: {
        Container,
        FileInput,
        ImagePreview,
        SwitchInput,
        TextEditor,
        TextInput,
        UiButton,
        UiTitle,
        Select2Input,
        ClipDepth,
    },
    data: function () {
        return {
            title: null,
            video: null,
            period: null,
            directors: [],
            peoples: [],
            year: null,
            format: null,
            age: null,
            genre: null,
            region: null,
            topics: [],

            options: {
                periods: [],
                directors: [],
                genres: [],
                formats: [],
                ages: [],
                topics: [],
                peoples: [],
                hashtags: [],
            },
        }
    },
    methods: {
        getData: function () {
            this.$http.get('/api/v2/admin/clips/get-initials').then(response => {
                for (let key in this.options) {
                    if (this.options.hasOwnProperty(key) && response.data.hasOwnProperty(key)) {
                        this.options[key] = response.data[key]
                    }
                }
                this.period = this.options.periods[0].id
            })
        },
        updateField: function (key, value) {

        },
    },
    created: function () {
        this.getData()
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

label {
    font-size: $font-size-sm;
}

.a-clip-panel {
    &__topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    &__divider {
        margin-top: $spacer / 1.618;
        margin-bottom: $spacer * 1.618;
    }

    &__group {
        margin-bottom: $spacer * 2 * 1.618;
    }
    &__row {
        align-items: center;
    }

    &__select {
        margin-right: $spacer;
        display: flex;
        align-items: center;

        label {
            flex-grow: 1;
            margin-right: $spacer / 2;
            margin-bottom: 0;
            font-size: $font-size-sm;
            color: $text-muted;
        }

        .form-control {
            width: auto;
        }
    }

    &__per-page {
        margin-left: auto;
        margin-right: $spacer;
        display: flex;
        align-items: center;

        label {
            flex-grow: 1;
            margin-right: $spacer / 2;
            margin-bottom: 0;
            font-size: $font-size-sm;
            color: $text-muted;
        }

        .form-control {
            width: auto;
        }
    }

    &__search {
        max-width: 200px;
    }
}

.clips-table {
    &__preview {
        width: $spacer * 3;
    }
}
</style>
