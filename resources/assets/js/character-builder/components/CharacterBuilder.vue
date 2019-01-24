<template lang="html">
    <div>
        <div class="row mt">
            <preview
            />
            <library
                :title="library_text"
                :libraries="librariesParsed"
            />
        </div>
        <control-bar
            :deselect_all="deselect_all_text"
            :move_back="move_back_text"
            :move_backward="move_backward_text"
            :move_forward="move_forward_text"
            :move_to_front="move_to_front_text"
            :remove="remove_text"
        />
        <notes
            :notes="notes_text"
        />
    </div>
</template>

<script>
import ControlBar from './ControlBar.vue'
export default {
    name: 'CharacterBuilder',
    components: {
        ControlBar,
    },
    props: {
        libraries: {
            type: String,
            default: '',
        },
        library_text: {
            type: String,
            default: '',
        },
        deselect_all_text: {
            type: String,
            default: '',
        },
        move_back_text: {
            type: String,
            default: '',
        },
        move_backward_text: {
            type: String,
            default: '',
        },
        move_forward_text: {
            type: String,
            default: '',
        },
        move_to_front_text: {
            type: String,
            default: '',
        },
        remove_text: {
            type: String,
            default: '',
        },
        notes_text: {
            type: String,
            default: '',
        },
    },
    computed: {
        librariesParsed: function() {
            if (this.libraries) {
                return JSON.parse(this.libraries)
            }
            return []
        }
    }
}
</script>

<style lang="css">
</style>
