<template lang="html">
	<div class="">
		<div id="input-box" class="" ref="input">
			<input
				id="media"
				type="file"
				name="media"
				class="form-control"
				@change="filesChange($event.target.name, $event.target.files)">

			<input id="session-token" type="hidden" value="">

			<button
				id="upload"
				class="btn btn-yellow"
				@click="sendUpload">
				<i class="fa fa-upload" aria-hidden="true"></i>
			</button>
		</div>
		<div id="loader" ref="loader">
			<i class="fa fa-refresh fa-spin"></i>
			<div id="progress-bar" class="progress" style="width: 100%">
				<div ref="progress_bar" class="progress-bar" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
			</div>
		</div>
		<div v-if="error_msg" class="d-flex justify-content-around pb-4">
			<div class="error">
				{{ this.error_msg }}
			</div>
		</div>
	</div>
</template>

<script>
import {TimelineMax, TweenMax, Sine} from 'gsap'
import axios from 'axios'

export default {
	name: 'UploadForm',
	props: {
		app_id: {
			type: String,
			default: '',
		},
		csrf_field: {
			type: String,
			default: '',
		},
		route: {
			type: String,
			default: '',
		},
	},
	data: () => ({
		assets_list: '',
		error_msg: null,
		file: null,
	}),
	computed: {
		sessionToken: function() {
			return document.getElementById('session-token').value
		}
	},
	methods: {
		filesChange: function(name, files) {
			this.file = files[0]
			this.error_msg = null
		},
		loaderHide: function() {
			var t1 = new TimelineMax()
			t1.to(this.$refs.loader, .2, {
					opacity: 0,
					display: 'none',
					ease: Sine.easeInOut,
				})
				.to(this.$refs.input, .2, {
					opacity: 1,
					display: 'flex',
					ease: Sine.easeInOut,
				})
		},
		loaderShow: function() {
			var t1 = new TimelineMax()
			t1.to(this.$refs.input, .2, {
					opacity: 0,
					display: 'none',
					ease: Sine.easeInOut,
				})
				.to(this.$refs.loader, .2, {
					opacity: 1,
					display: 'flex',
					ease: Sine.easeInOut,
				})
		},
		sendUpload: function() {
			if (!this.sessionToken) {
				this.error_msg = 'This session is corrupted. Please, save and reload the application'
				return false
			}

			if (!this.file) {
				this.error_msg = 'You must pick a file!'
				return false
			}

			// Reset the progress-bar
			vue.$refs.progress_bar.style.width = '0%'

			// show loader
			this.loaderShow()

			// Prepare the form
			var vue = this
			var data = new FormData()
			data.append('_token', this.csrf_field)
			data.append('media', this.file)
			data.append('session_token', this.sessionToken) // bisogna trovare un modo per catturare il token

			// Start the request
			var request = new XMLHttpRequest();
			request.upload.addEventListener('progress', function(e){
                   	var percent = Math.round((e.loaded / e.total) * 100)
					vue.$refs.progress_bar.style.width = percent+'%'
                }, false)

			request.addEventListener('load', function(e){
                if (e.target.status != 200) {
					// error
					vue.error_msg = 'Oops something went wrong, plase save the session and reload the page'
                } else {
					// success
					var response = JSON.parse(e.target.responseText)
					var asset = document.createElement('li')
					asset.className = 'col-md-3 asset'
					asset.innerHTML = '<img src="'+response.img+'" class="img-fluid w-100">'
					vue.assets_list.appendChild(asset)
					vue.loaderHide()
                }
            }, false)

            request.open('post', this.route)
            request.send(data)
		},
	},
	mounted() {
		this.assets_list = document.getElementById('upload-assets')
	}
}
</script>

<style lang="scss">

	#input-box {
		display: flex;
	}

	#progress-bar {
		margin-left: 32px;
	}

	#loader {
		display: none;
		opacity: 0;
	}

</style>
