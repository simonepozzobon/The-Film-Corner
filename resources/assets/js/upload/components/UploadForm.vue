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
			default: null,
		},
		csrf_field: {
			type: String,
			default: null,
		},
		route: {
			type: String,
			default: null,
		},
	},
	data: () => ({
		assets_list: null,
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
		formatResponse: function(response) {
			var vue = this
			return new Promise((resolve, reject) => {
				switch (parseInt(this.app_id)) {
					case 11:
						this.assets_list = document.getElementById('upload-assets')
						var asset =
							'<tr>'+
								'<td class="align-middle">' +
									'<img src="'+response.img+'" width="57">'+
								'</td>'+
								'<td class="align-middle">'+response.name+'</td>'+
								'<td class="align-middle" ng-controller="toolController">'+
									'<div class="btn-group">'+
										'<button ng-click="addElement(\''+response.video_id+'\',\''+response.name+'\', \''+response.duration+'\', \''+response.src+'\')" class="btn btn-secondary btn-yellow" data-toggle="tooltip" data-placement="top" title="Add To Timeline">'+
											'<i class="fa fa-plus" aria-hidden="true"></i>'+
										'</button>'+
									'</div>'+
								'</td>'+
							'</tr>'

						var event = new CustomEvent('new-video-on-library', {'detail': asset})
				        this.assets_list.dispatchEvent(event) // send the event to angularjs
						resolve('done')
						break;

					case 15:
						this.assets_list = document.getElementById('upload-assets')
						var asset = document.createElement('li')
						asset.className = 'col-md-3 asset'
						asset.innerHTML = '<img src="'+response.img+'" class="img-fluid w-100">'
						this.assets_list.appendChild(asset)
						resolve('done')
						break;
				}
				reject('I can\'t manage this response')
			})
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
			this.$refs.progress_bar.style.width = '0%'

			// show loader
			this.loaderShow()

			// Prepare the form
			var vue = this
			var data = new FormData()
			data.append('_token', this.csrf_field)
			data.append('media', this.file)
			data.append('session_token', this.sessionToken)
			data.append('session', this.sessionToken)

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
					var XMLresponse = JSON.parse(e.target.responseText)
					console.log('XMLResponse ',XMLresponse)
					vue.formatResponse(XMLresponse).then(response => {
						vue.loaderHide()
					}).catch(error => {
						vue.error_msg = 'Oops the server can\'t manage the response'
					})
                }
            }, false)

            request.open('post', this.route)
            request.send(data)
		},
	},
	mounted() {
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
