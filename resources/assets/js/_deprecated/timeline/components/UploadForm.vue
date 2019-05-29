<template>
	<div class="">
        <div id="title" v-if="this.has_title" class="mb-3" ref="title">
            <input type="text" v-model="title" class="form-control" placeholder="Title">
        </div>
		<div id="input-box" class="mb-3" ref="input">
			<input
				id="media"
				type="file"
				name="media"
				class="form-control"
				@change="filesChange($event.target.name, $event.target.files)">

			<input id="session-token" type="hidden" value="null">

			<button
				id="upload"
				:class="'ml-3 btn btn-'+color"
				@click="sendUpload">
				<i class="fa fa-upload" aria-hidden="true"></i>
			</button>
		</div>
		<div id="loader" ref="loader">
			<i class="fa fa-refresh fa-spin"></i>
			<div id="progress-bar" class="progress" style="width: 100%">
				<div ref="progress_bar" class="progress-bar" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
			</div>
			<div id="percent">{{ this.percent }}%</div>
		</div>
		<div v-if="error_msg" class="d-flex justify-content-around pb-4">
			<div class="error text-danger">
				<b>{{ this.error_msg }}</b>
			</div>
		</div>
	</div>
</template>

<script>
import {
    TimelineMax,
    TweenMax,
    Sine
} from 'gsap'
import axios from 'axios'
import $ from 'jquery'

export default {
    name: 'UploadForm',
    props: {
        app_id: {
            type: String,
            default: null,
        },
        color: {
            type: String,
            default: 'yellow',
        },
        csrf_field: {
            type: String,
            default: null,
        },
        route: {
            type: String,
            default: null,
        },
        has_title: {
            type: Boolean,
            default: false,
        }
    },
    data: () => ({
        assets_list: null,
        error_msg: null,
        file: null,
        percent: 0,
        session_token: '',
        title: '',
        videos: [],
    }),
    computed: {

    },
    methods: {
        filesChange: function(name, files) {
            this.file = files[0]
            this.error_msg = null
        },
        formatResponse: function(response) {
            var vue = this
            return new Promise((resolve, reject) => {
                switch (true) {
                    case parseInt(this.app_id) == 10:
                        this.assets_list = document.getElementById('upload-assets')
                        var asset = document.createElement('tr')
                        asset.setAttribute('id', 'video-' + response.video_id)
                        asset.innerHTML =
                            '<td><img src="' + response.img + '" width="57" class="img-fluid"></td>' +
                            '<td>' +
                            '<input id="video-id-src" type="hidden" name="" value="' + response.src + '">' +
                            '<div class="btn-group">' +
                            // '<button type="button" class="btn btn-blue" onclick="videoPlay(\''+response.src+'\')"><i class="fa fa-play" aria-hidden="true"></i></button>'+
                            '<button type="button" class="btn btn-blue" onclick="videoDelete(' + response.video_id + ')"><i class="fa fa-trash-o" aria-hidden="true"></i></button>' +
                            '</div>' +
                            '</td>'
                        this.assets_list.appendChild(asset)

                        var video = {
                            'img': response.img,
                            'video': response.src
                        };
                        this.videos.push(video)
                        localStorage.setItem('app-10-video-uploaded', JSON.stringify(this.videos));

                        resolve('done')
                        break;

                    case parseInt(this.app_id) == 11:
                        this.assets_list = document.getElementById('upload-assets')
                        var asset =
                            '<tr>' +
                            '<td class="align-middle">' +
                            '<img src="' + response.img + '" width="57">' +
                            '</td>' +
                            '<td class="align-middle">' + response.name + '</td>' +
                            '<td class="align-middle">' +
                            '<div class="btn-group">' +
                            '<button ng-click="addElement(\'' + response.video_id + '\',\'' + response.name + '\', \'' + response.duration + '\', \'' + response.src +
                            '\')" class="btn btn-secondary btn-yellow" data-toggle="tooltip" data-placement="top" title="Add To Timeline">' +
                            '<i class="fa fa-plus" aria-hidden="true"></i>' +
                            '</button>' +
                            '</div>' +
                            '</td>' +
                            '</tr>'

                        var event = new CustomEvent('new-video-on-library', {
                            'detail': asset
                        })
                        this.assets_list.dispatchEvent(event) // send the event to angularjs

                        resolve('done')
                        break;

                    case parseInt(this.app_id) == 13:
                        this.assets_list = document.getElementById('upload-assets')
                        var asset = document.createElement('div')
                        asset.className = 'asset col-md-3 col-sm-4 pb-3'
                        asset.innerHTML =
                            '<img src="' + response.img + '" alt="image asset" class="img-fluid" data-img-src="' + response.img + '"/>' +
                            '<a href="" class="abs-btn btn btn-sm btn-danger d-none"><i class="fa fa-times"></i></a>'
                        this.assets_list.appendChild(asset)

                        resolve('done')
                        break;

                    case parseInt(this.app_id) == 15:
                        this.assets_list = document.getElementById('upload-assets')
                        var asset = document.createElement('li')
                        asset.className = 'col-md-3 asset'
                        asset.innerHTML = '<img src="' + response.img + '" class="img-fluid w-100">'
                        this.assets_list.appendChild(asset)
                        resolve('done')
                        break;

                    case parseInt(this.app_id) == 16 || parseInt(this.app_id) == 17: // contests
                        this.assets_list = document.getElementById('response')
                        var asset = document.createElement('div')
                        this.$refs.input.style.display = 'none'
                        this.$refs.title.style.display = 'none'
                        this.$refs.loader.style.display = 'none'
                        this.error_msg = ''

                        asset.innerHTML =
                            '<h3 class="text-center pb-4 text-success">Your video has been sent!</h3>' +
                            '<h6 class="text-center pb-4 text-success">One last step, give it a title and save it!</h6>'
                        this.assets_list.appendChild(asset)

                        var video = {
                            'img': response.img,
                            'video': response.src
                        };

                        localStorage.setItem('app-' + this.app_id + '-video', JSON.stringify(video));
                        resolve('stop')
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
                .to(this.$refs.title, .2, {
                    opacity: 1,
                    display: 'block',
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
                .to(this.$refs.title, .2, {
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
            this.session_token = document.getElementById('session-token').value
            if (!this.session_token || this.session_token == 'null') {
                this.error_msg = 'This session is corrupted. Please, save and reload the application'
                return false
            }

            if (this.has_title == true) {
                if (this.title == 'Untitled' || this.title == '') {
                    this.error_msg = 'You must insert a title!'
                    return false
                }
            }

            if (!this.file) {
                this.error_msg = 'You must pick a file!'
                return false
            }

            // Reset the progress-bar
            this.$refs.progress_bar.style.width = '0%'
            this.percent = 0

            // show loader
            this.loaderShow()

            // Prepare the form
            var vue = this
            var data = new FormData()
            data.append('_token', this.csrf_field)
            data.append('media', this.file)
            data.append('session_token', this.session_token)
            data.append('session', this.session_token)
            if (this.has_title) {
                data.append('directly-save', true)
                data.append('title', this.title)
            }

            // Start the request
            var request = new XMLHttpRequest();
            request.upload.addEventListener('progress', function(e) {
                var percent = Math.round((e.loaded / e.total) * 100)
                vue.$refs.progress_bar.style.width = percent + '%'
                vue.percent = percent
            }, false)

            request.addEventListener('load', function(e) {
                if (parseInt(e.target.status) != 200) {
                    // error
                    vue.error_msg = 'Oops something went wrong, plase save the session and reload the page'
                } else {
                    // success
                    var XMLresponse = JSON.parse(e.target.responseText)
                    vue.formatResponse(XMLresponse).then(response => {
                        console.log(response)
                        if (response == 'done') {
                            vue.loaderHide()
                        }
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
        $(document).trigger('upload-module-loaded', null)
    }
}
</script>

<style lang="scss">
#input-box {
    display: flex;
}

#progress-bar {
    margin-left: 32px;

    > .progress-bar {
        height: auto;
    }
}

#loader {
    display: none;
    opacity: 0;
    position: relative;

    > i {
        position: absolute;
        height: 16px;
        width: inherit;
        top: 25%;
        transform: translateY(-50%);
    }

    > #percent {
        margin-left: 32px;
    }
}
</style>
