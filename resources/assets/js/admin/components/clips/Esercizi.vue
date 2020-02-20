<template>
<div class="row no-gutters">
    <switch-container
        ref="switch"
        v-for="option in options"
        :key="option.id"
        :option="option"
        @ready="switchReady"
        @updateSelection="updateSelection($event, option)"
    />
</div>
</template>

<script>
import SwitchContainer from './SwitchContainer.vue'

export default {
    name: "Esercizi",
    components: {
        SwitchContainer,
    },
    props: {
        options: {
            type: Array,
            default: function () {
                return [];
            }
        },
        exercises: {
            type: Array,
            default: function () {
                return [];
            }
        },
        initials: {
            type: Object,
            default: function () {
                return {};
            }
        },
        clip: {
            type: Object,
            default: function () {
                return {};
            }
        }
    },
    data: function () {
        return {
            clipId: null,
            counter: 0,
            keys: ["exercise_1", "exercise_2", "exercise_3"]
        };
    },
    watch: {
        initials: function (initials) {
            // console.log('wqtch', initials);
            this.setInitials();
        },
        clip: function () {
            this.checkClipId();
        }
    },
    methods: {
        checkClipId: function () {
            // set clip id
            if (
                this.clip &&
                this.clip.hasOwnProperty("id") &&
                this.clip.id > 0
            ) {
                this.clipId = this.clip.id;
            }
        },
        updateSelection: function (value, option) {
            if (value) {
                // console.log('add exercise');
                this.addExercise(option);
            }
            else {
                // console.log('remove exercise');
                this.removeExercise(option);
            }
        },
        addExercise: function (option) {
            const newExercise = Object.assign({}, option);
            newExercise["uuid"] = this.$util.uuid();
            newExercise["isNew"] = true;

            if (
                newExercise.hasOwnProperty("has_library") &&
                newExercise.has_library == 1
            ) {
                newExercise["libraries"] = [];
            }

            let cached = this.exercises;
            cached.push(newExercise);

            if (this.clipId) {
                let data = new FormData();
                data.append("clip_id", this.clipId);
                data.append("exercise_id", option.id);

                this.$http
                    .post("/api/v2/admin/clips/exercises/add", data)
                    .then(response => {
                        // console.log('response add', response);
                        this.$emit("update:exercises", cached);
                    });
            }
            else {
                this.$emit("update:exercises", cached);
            }
        },
        removeExercise: function (option) {
            let idx = this.exercises.findIndex(
                exercise => exercise.id == option.id
            );
            if (idx > -1) {
                let cached = this.exercises;
                cached.splice(idx, 1);

                if (this.clipId) {
                    let data = new FormData();
                    data.append("clip_id", this.clipId);
                    data.append("exercise_id", option.id);

                    this.$http
                        .post("/api/v2/admin/clips/exercises/remove", data)
                        .then(response => {
                            // console.log('response remove', response);
                            this.$emit("update:exercises", cached);
                        });
                }
                else {
                    this.$emit("update:exercises", cached);
                }
            }
            else {
                // console.log('non trovato');
            }
        },
        switchReady: function () {
            this.counter = this.counter + 1
            if (this.counter >= 3) {
                this.setInitials()
            }
        },
        setInitials: function () {
            if (this.initials) {
                for (let i = 0; i < this.keys.length; i++) {
                    let key = this.keys[i];
                    if (this.initials.hasOwnProperty(key)) {
                        let idx = parseInt(key.replace("exercise_", "")) - 1;
                        if (this.$refs.switch) {
                            let component = this.$refs.switch[idx];
                            // console.log(component);

                            // la clip ha questo esercizio
                            component.value = this.initials[key] == 1 ? true : false;
                        }
                    }
                }
            }
        }
    },
    mounted: function () {
        this.checkClipId();
    }
};
</script>

<style lang="scss" scoped>
@import "~styles/shared";
</style>
