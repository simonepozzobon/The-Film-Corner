<template>
    <div>
        <div class="row mt">
            <preview
                :character_text="character_text"
            />
            <library
                :title="library_text"
                :libraries="librariesParsed"
            />
        </div>
        <!-- <control-bar
            :deselect_all="deselect_all_text"
            :move_back="move_back_text"
            :move_backward="move_backward_text"
            :move_forward="move_forward_text"
            :move_to_front="move_to_front_text"
            :remove="remove_text"
        /> -->
        <notes
            :notes="notes_text"
            :character_builder_desc="character_builder_desc"
        />
    </div>
</template>

<script>
import ControlBar from './ControlBar.vue'
import Library from './Library.vue'
import Notes from './Notes.vue'
import Preview from './Preview.vue'

export default {
    name: 'CharacterBuilder',
    components: {
        ControlBar,
        Library,
        Notes,
        Preview,
    },
    props: {
        libraries: {
            type: String,
            default: '',
        },
        character_text: {
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
        character_builder_desc: {
            type: String,
            default: '',
        },
        open: {
            type: Boolean,
            default: false,
        },
        session: {
            type: String,
            default: ''
        }
    },
    computed: {
        librariesParsed: function() {
            if (this.libraries) {
                let parsed = JSON.parse(this.libraries)
                this.$root.libraries = parsed
                return parsed
            }
            return []
        },
    },
    methods: {
        init: function() {
            if (this.open) {
                let session = JSON.parse(this.session)
                this.$root.session = session
            }
        }
    },
    mounted: function() {
        this.init()
    }
}
</script>

<style lang="css">
</style>
