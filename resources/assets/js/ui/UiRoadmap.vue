<template>
<div
  class="roadmap"
  ref="sliderController"
>
    <div class="roadmap__line">
        <ui-roadmap-dot
          v-for="(stage, index) in stagesArr"
          :key="index"
          @click="goTo(index)"
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
    data: function () {
        return {
            stagesArr: [ {
                period: '1917',
                color: 'red',
                label: 'Russian Revolution',
            }, {
                period: '1922-1945',
                color: 'orange',
                label: 'Fascism and Nazism',
            }, {
                period: '1939-1945',
                color: 'green',
                label: 'Second World War',
            }, {
                period: '1946-1990',
                color: 'teal',
                label: 'Cold war',
            }, ],
        }
    },
    methods: {
        goTo: function () {},
    },
}
</script>

<style lang="scss" scoped>
@import '~styles/shared';

.roadmap {
    display: flex;
    width: 100%;
    align-items: center;

    &__line {
        position: relative;
        width: 100%;
        height: $spacer * 2;
        background-image: url("/svg/line-roadmap.svg");
        background-repeat: repeat-x;
        display: flex;
        align-items: center;
        justify-content: space-around;
    }

    &__dot {
        position: relative;
        width: $spacer;
        height: $spacer;
        @include border-radius($spacer);
        background-color: $light;
        border: 2px solid $black;
        cursor: pointer;
        transition: $transition-base;
    }
}
</style>
x
