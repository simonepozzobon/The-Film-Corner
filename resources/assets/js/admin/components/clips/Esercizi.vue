<template>
<div class="row no-gutters">
    <div
        class="col"
        v-for="option in options"
        :key="option.id"
    >
        <switch-input
            ref="switch"
            :label="option.title"
            label-size="col-md-6"
            input-size="col-md-6"
            :has-row="true"
            @update="updateSelection($event, option)"
        />
    </div>
</div>
</template>

<script>
import {
    SwitchInput,
}
from '../../adminui'

export default {
    name: 'Esercizi',
    components: {
        SwitchInput,
    },
    props: {
        options: {
            type: Array,
            default: function () {
                return []
            },
        },
        exercises: {
            type: Array,
            default: function () {
                return []
            }
        }
    },
    methods: {
        updateSelection: function (value, option) {
            if (value) {
                this.addExercise(option)
            }
            else {
                this.removeExercise(option)
            }
        },
        addExercise: function (option) {
            const newExercise = Object.assign({}, option)
            newExercise['uuid'] = this.$util.uuid()
            newExercise['isNew'] = true

            if (newExercise.hasOwnProperty('has_library') && newExercise.has_library == 1) {
                newExercise['libraries'] = []
            }

            let cached = this.exercises
            cached.push(newExercise)


            this.$emit('update:exercises', cached)
        },
        removeExercise: function (option) {
            let idx = this.exercises.findIndex(exercise => exercise.id == option.id)
            if (idx > -1) {
                let cached = this.exercises
                cached.splice(idx, 1)
                this.$emit('update:exercises', cached)
            }
            else {
                console.log('non trovato');
            }
        },
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
