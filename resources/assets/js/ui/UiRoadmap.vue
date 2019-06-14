<template>
<div
    class="roadmap"
    ref="sliderController"
>
    <div class="roadmap__line">
        <ui-roadmap-dot
            v-for="(channel, index) in channels"
            :key="index"
            :point="channel"
            @click="selectChannel"
        />
    </div>
</div>
</template>

<script>
import UiRoadmapDot from './UiRoadmapDot.vue'
export default {
    name: 'UiRoadmap',
    components: {
        UiRoadmapDot
    },
    data: function() {
        return {
            channels: [{
                period: '1917',
                color: 'red',
                label: 'Russian Revolution',
            }, {
                period: '1922-1945',
                color: 'orange',
                label: 'Fascism and Nazism',
            }, {
                period: '1939-1945',
                color: 'green-var',
                label: 'Second World War',
            }, {
                period: '1946-1990',
                color: 'teal',
                label: 'Cold war',
            }, ],
        }
    },
    methods: {
        selectChannel: function(channel) {
            this.$emit('select-channel', channel)
        },
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.roadmap {
    display: flex;
    width: 100%;
    justify-content: center;
    align-items: center;
    margin-top: 20%;
    margin-bottom: 15%;

    &__line {
        position: relative;
        width: 90%;
        height: $spacer * 2;
        background-image: url("/svg/line-roadmap.svg");
        background-repeat: repeat-x;
        display: flex;
        align-items: center;
        justify-content: center;
    }
}
</style>
