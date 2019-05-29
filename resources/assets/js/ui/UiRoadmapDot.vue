<template>
<div
		class="roadmap-dot"
		@click="goTo(index)"
	>
	</div>
</template>

<script>
export default {
		name: 'UiRoadmapDot',
	}
</script>

<style lang="scss" scoped>
@import '~styles/shared';
$size-close: $spacer * 2 !default;
$size-hover: $spacer * 4 !default;

.roadmap-dot {
    position: relative;
    width: $size-close;
    height: $size-close;
    @include border-radius($size-close);
    background-color: $light;
    border: 4px solid $black;
    cursor: pointer;
    transition: $transition-base;

    &:hover {
        width: $size-hover;
        height: $size-hover;
        border: 6px solid $black;
        @include border-radius($size-hover);
    }
}
</style>
