<template>
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
            <carica-clip />
            <informazioni :options="options" />
            <approfondimenti />
            <paratexts />
            <esercizi />
        </div>
    </container>
    <container padding="sm">
        <div class="a-clip-panel__topbar">
            <ui-button
                title="Salva Clip"
                color="green"
                :has-container="false"
                :has-margin="false"
            />
            <ui-button
                title="Annulla"
                color="red"
                :has-container="false"
                :has-margin="false"
            />
        </div>
    </container>
</div>
</template>

<script>
import {
    Container,
}
from '../adminui'


import {
    UiButton,
    UiTitle,
}
from '../../ui'

import Approfondimenti from '../components/clips/Approfondimenti.vue'
import CaricaClip from '../components/clips/CaricaClip.vue'
import Informazioni from '../components/clips/Informazioni.vue'
import Paratexts from '../components/clips/Paratexts.vue'
import Esercizi from '../components/clips/Esercizi.vue'

export default {
    name: 'ClipCreate',
    components: {
        Container,
        UiButton,
        UiTitle,
        Approfondimenti,
        CaricaClip,
        Informazioni,
        Paratexts,
        Esercizi,
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

<style lang="scss">
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
