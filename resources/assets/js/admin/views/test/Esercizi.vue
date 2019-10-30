<template>
<div class="admin-home">
    <container>
        <block-panel
            title="Esercizi"
            :has-animations="true"
        >
            <div class="row">
                <label class="col-md-2">
                    Compare The Clips
                </label>
                <switch-input
                    label="Compare The Clips"
                    label-size="col-md-2"
                    input-size="col-md-1"
                    :has-row="false"
                    @update="updateSelection($event, 1, 'Compare The Clips')"
                />
                <label class="col-md-2 offset-md-1">
                    Frame Crop
                </label>
                <switch-input
                    label="Frame Crop"
                    label-size="col-md-2"
                    input-size="col-md-1"
                    :has-row="false"
                    @update="updateSelection($event, 2, 'Frame Crop')"
                />
                <label class="col-md-2 offset-md-1">
                    Check The Sound
                </label>
                <switch-input
                    label="Check The Sound"
                    label-size="col-md-2"
                    input-size="col-md-1"
                    :has-row="false"
                    @update="updateSelection($event, 3, 'Check The Sound')"
                />
            </div>
        </block-panel>
    </container>
    <container
        v-for="exercise in exercises"
        :key="exercise.uuid"
    >
        <block-panel
            :title="exercise.title"
            :has-animations="true"
        >
        </block-panel>
    </container>
</div>
</template>

<script>
import {
    BlockPanel,
    Container,
    PanelTitle,
    SwitchInput,
}
from '../../adminui'

export default {
    name: 'Testing',
    components: {
        BlockPanel,
        Container,
        PanelTitle,
        SwitchInput,
    },
    data: function () {
        return {
            exercises: [],
        }
    },
    methods: {
        debug: function () {},
        updateSelection: function (value, id, title) {
            if (value) {
                this.addExercise(id, title)
            }
            else {
                this.removeExercise(id, title)
            }
        },
        addExercise: function (id, title) {
            const exerxise = {
                id: id,
                uuid: this.$util.uuid(),
                title: title,
                libraries: [],
            }
            this.exercises.push(exerxise)
        },
        removeExercise: function (id, title) {
            let idx = this.exercises.findIndex(exercise => exercise.id == id)
            if (idx > -1) {
                this.exercises.splice(idx, 1)
            }
            else {
                console.log('non trovato');
            }
        }
    },
    mounted: function () {

    }
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
