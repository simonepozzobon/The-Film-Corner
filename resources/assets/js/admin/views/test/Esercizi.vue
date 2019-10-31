<template>
<div class="admin-home">
    <container>
        <block-panel
            title="Esercizi"
            :has-animations="true"
        >
            <esercizi
                :options="options.exercises"
                :exercises.sync="exercises"
                ref="selector"
            />
        </block-panel>
    </container>
    <librerie-esercizi
        v-for="exercise in exercises"
        :key="exercise.uuid"
        :exercise="exercise"
        :clip="clip"
    />
</div>
</template>

<script>
import {
    Container,
    BlockPanel,
}
from '../../adminui'

import Esercizi from '../../components/clips/Esercizi.vue'
import LibrerieEsercizi from '../../components/clips/LibrerieEsercizi.vue'

export default {
    name: 'Testing',
    components: {
        Container,
        BlockPanel,
        Esercizi,
        LibrerieEsercizi,
    },
    data: function () {
        return {
            options: {
                // periods: [],
                // directors: [],
                // genres: [],
                // formats: [],
                // ages: [],
                // topics: [],
                // peoples: [],
                // hashtags: [],
                // paratext_types: [],
                exercises: [],
            },
            clip: {
                id: 1,
            },
            exercises: [],
        }
    },
    methods: {
        debug: function () {
            // seleziona un esercizio random tra quelli esistenti
            let selector = this.$refs.selector
            let switches = selector.$refs.switch
            let randomIdx = this.$util.randomFromArr(switches.length)

            let switcher = switches[0]

            this.$nextTick(() => {
                switcher.value = true
            })
        },
        getData: function () {
            this.$http.get('/api/v2/admin/clips/get-initials').then(response => {
                for (let key in this.options) {
                    if (this.options.hasOwnProperty(key) && response.data.hasOwnProperty(key)) {
                        this.options[key] = response.data[key]
                    }
                }

                this.$nextTick(() => {
                    this.debug()
                })
            })
        },

    },
    created: function () {
        this.getData()
    },
}
</script>

<style lang="scss">
@import '~styles/shared';
.para-single {
    &__sub-title {
        padding-top: $spacer * 1.618 !important;
        padding-bottom: $spacer * 1.618 !important;
    }
}
</style>

<style lang="scss" scoped>
@import '~styles/shared';
$color: lighten($gray-200, 8);
$color-darken: lighten($gray-200, 3);
$darken: lighten($dark, 3);

.para-single {
    margin-bottom: $spacer * 2.5;
    flex-direction: column;
    align-items: center;
    justify-content: center;

    &__content {
        @include custom-box-shadow($darken, 2px, 0.02);
        @include gradient-directional($color, lighten($color, 2), -11deg);
        @include border-radius($border-radius * 2);
        padding: ($spacer / 2) ($spacer * 2) ($spacer * 2) ($spacer * 2);
    }
}
</style>
