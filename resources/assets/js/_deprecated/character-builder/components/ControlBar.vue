<template lang="html">
    <div class="row mt">
        <div class="col">
            <div class="box orange">
                <div id="controls" class="box-btns pt">
                    <a id="deselect" href="#" class="btn btn-orange">{{ deselect_all }}</a>
                    <div class="btn-group">
                        <a id="back" href="#" class="btn btn-orange">{{ move_back }}</a>
                        <a id="backward" href="#" class="btn btn-orange">{{ move_backward }}</a>
                        <a id="forward" href="#" class="btn btn-orange">{{ move_forward }}</a>
                        <a id="front" href="#" class="btn btn-orange">{{ move_to_front }}</a>
                    </div>
                    <a id="destroy" href="#" class="btn btn-orange">{{ remove }}</a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ControlBar',
    props: {
        deselect_all: {
            type: String,
            default: '',
        },
        move_back: {
            type: String,
            default: '',
        },
        move_backward: {
            type: String,
            default: '',
        },
        move_forward: {
            type: String,
            default: '',
        },
        move_to_front: {
            type: String,
            default: '',
        },
        remove: {
            type: String,
            default: '',
        },
    }
}
</script>

<style lang="css">
</style>
