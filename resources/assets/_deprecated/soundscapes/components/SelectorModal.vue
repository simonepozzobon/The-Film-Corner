<template>
    <div ref="modal" class="modal fade" id="selector-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">
                        {{ title }}
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body d-flex justify-content-around align-items-center">
                    <selector-btn
                        v-for="(player, i) in this.$root.players"
                        :key="i"
                        :idx="i"
                        @selected="selected"
                    />
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import SelectorBtn from './SelectorBtn.vue'

export default {
    name: 'SelectorModal',
    components: {
        SelectorBtn,
    },
    props: {
        title: {
            type: String,
            default: '',
        }
    },
    data: function() {
        return {
            obj: null,
        }
    },
    methods: {
        show: function() {
            $(this.$refs.modal).modal('show')
        },
        selected: function(idx) {
            this.$root.players[idx].src = this.obj
            this.$root.stop()
            $(this.$refs.modal).modal('hide')
            this.$root.changeSrc(idx)
        },
    },
    mounted: function() {
        this.$root.$on('add-to-mixer', obj => {
            this.obj = obj
            this.show()
        })
    }
}
</script>

<style lang="css">
</style>
