<template>
<ui-button
    :title="title"
    class="prop-single-exercise"
    display="inline-block"
    color="yellow"
    :has-container="false"
    :has-margin="false"
    @click="goToExercise()"
/>
</template>

<script>
import {
    UiButton
}
from '../../../ui'

export default {
    name: 'ExerciseButton',
    components: {
        UiButton
    },
    props: {
        exercise: {
            type: Object,
            default: function () {
                return {}
            },
        },
    },
    data: function () {
        return {
            title: null,
        }
    },
    watch: {
        '$root.locale': function (locale) {
            this.translateTitle()
        }
    },
    methods: {
        translateTitle: function () {
            let locale = this.$root.locale

            let title = this.exercise.translations.find(translation => translation.locale == locale)
            if (title) {
                this.title = title.title
            }
            else {
                this.title = this.exercise.title
            }

        },
        goToExercise: function () {
            this.$root.goToWithParams('propaganda-exercise', {
                id: this.$route.params.id,
                exerciseId: this.exercise.id
            })
        }
    },
    mounted: function () {
        this.translateTitle()
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
</style>
