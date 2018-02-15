<template>
	<div id="fullscreen-message">
		<div class="message text-success">
			Messaggio
		</div>
	</div>
</template>
<script>
export default {
	name: 'Message',
	data: () => ({
		message: '',
	}),
	methods: {},
	created() {
		document.addEventListener('fullscreen-message', (message) => {
			alert('message')
		})
	}
}
</script>
<style lang="scss" scoped>
@import '~styles/variables';
@import '~styles/mixins';

	#fullscreen-message {
		position: fixed;
		top: 0;
		left: 0;
		right: 0;
		bottom: 0;
		width: 100%;
		height: 100%;
		z-index: 9999;
		background-color: rgba($modal-content-bg, .8);

		> .message {
			font-family: $font-family-serif;
		    font-weight: 900;
		    text-transform: uppercase;
			color: $black;
			font-size: $font-size-h1;
		    line-height: 2.83rem;
			position: absolute;
			left: 50%;
			top: 50%;
			transform: translate(-50%, -50%);
		}
	}

</style>
