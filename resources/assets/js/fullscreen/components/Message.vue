<template>
	<div id="fullscreen-message">
		<div id="display-message" class="message text-success" ref="message">
			Messaggio
		</div>
	</div>
</template>
<script>
import {TimelineMax, Sine, Power4} from 'gsap'
export default {
	name: 'Message',
	data: () => ({
		message: '',
	}),
	methods: {
		showMessage: function() {
			var vue = this
			var t1 = new TimelineMax()
			t1.to('#fullscreen-message', .4, {
				opacity: 1,
				display: 'inherit',
				ease: Power4.easeInOut,
			})
				.to('#display-message', .2, {
					opacity: 1,
					display: 'block',
					ease: Sine.easeInOut,
					onComplete: function() {
						setTimeout(vue.hideMessage, 7000)
					}
				})
		},
		hideMessage: function() {
			var t1 = new TimelineMax()
			t1.to('#display-message', .2, {
				opacity: 0,
				display: 'none',
				ease: Sine.easeInOut,
			})
				.to('#fullscreen-message', .2, {
					opacity: 0,
					display: 'none',
					ease: Power4.easeInOut,
				})

		},
	},
	created() {
		document.addEventListener('fullscreen-message', (message) => {
			this.message = message
			this.showMessage()
		})
	},
	mounted() {
	  //do something after mounting vue instance

	  // this.showMessage()

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

		display: none;
		opacity: 0;

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

			display: none;
			opacity: 0;
		}
	}

</style>
