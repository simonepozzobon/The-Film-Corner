<template>
    <div class="row mt">
        <div class="col-12">
            <div class="box orange">
                <div class="box-btns pt">
                    <div class="btn-group mr-1">
                        <button type="button" name="button" class="btn btn-secondary btn-orange" @click="play">
                            <i class="fa fa-play" aria-hidden="true"></i>
                        </button>
                        <button type="button" name="button" class="btn btn-secondary btn-orange" @click="pause">
                            <i class="fa fa-pause" aria-hidden="true"></i>
                        </button>
                        <button type="button" name="button" class="btn btn-secondary btn-orange" @click="stop">
                            <i class="fa fa-stop" aria-hidden="true"></i>
                        </button>
                        <button type="button" name="button" class="btn btn-secondary btn-orange" @click="backward">
                            <i class="fa fa-backward" aria-hidden="true"></i>
                        </button>
                        <button type="button" name="button" class="btn btn-secondary btn-orange" @click="forward">
                            <i class="fa fa-forward" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'ControlBar',
    methods: {
        play: function() {
            this.$root.play()
        },
        pause: function() {
            this.$root.pause()
        },
        stop: function() {
            this.$root.stop()
        },
        backward: function() {
            this.$root.backward()
        },
        forward: function() {
            this.$root.forward()
        },
        updateEditor: function() {
        }
    }
}
</script>

<style lang="css">
</style>
