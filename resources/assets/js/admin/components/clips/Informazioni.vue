<template>
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
            <select-2-input
                :multiple="false"
                :options="this.options.formats"
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
                :options="this.options.ages"
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
from '../../adminui'


import {
    UiButton,
    UiTitle,
}
from '../../../ui'

export default {
    name: 'Informazioni',
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
    },
    props: {
        options: {
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
            region: null,
        }
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
