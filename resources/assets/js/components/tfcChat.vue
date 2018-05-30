<template>
<div id="chat" class="collapse" style="width: 25rem;">
	<div class="box blue">
		<div class="box-header">
			To: {{ toname }}
		</div>
		<div class="box-body chat">
			<div id="chat-messages" class="messages" ref="messages">
				<div v-for="message in messages" :class="'messages-body'">
					<div :class="'message '+message.color+' '+message.type+' w-75'">
						<span class="msg">{{ message.msg }}</span>
					</div>
				</div>
			</div>
		</div>
		<div class="box-btns">
			<div class="form-group d-inline-block w-75">
				<input @keyup.enter="sendMsg" @keyup="typingMsg" class="form-control" v-model="msg">
			</div>
			<div class="form-group d-inline-block">
				<a @click="sendMsg" href="#" class="btn btn-blue"><i class="fa fa-paper-plane-o"/></a>
			</div>
		</div>
	</div>
</div>
</template>
<script>
var axios = require('axios')
var io = require('socket.io-client')
var socket = io.connect('https://' + window.location.hostname + ':6001', {
	reconnect: true
})
var _ = require('lodash')
var $ = require('jquery')

export default {
	name: 'TfcChat',
	props: ['fromtype', 'fromid', 'toid', 'totype', 'toname', 'token'],
	data: () => ({
		messages: [],
		msg: '',
		conts: '',
		status: false,
	}),
	mounted() {
		// check and listen for the status of the chat
		this.checkStatus()
		$('#chat').on('hidden.bs.collapse', () => {
			this.checkStatus()
		})
		$('#chat').on('shown.bs.collapse', () => {
			this.checkStatus()
			this.markMessagesAsRead()
		})

		var vue = this
		this.resizeChat()
		this.loadHistory()
		socket.on('connect', function() {
			console.log('CLIENT CONNECTED')
		})
		socket.on('chat:newMessage:' + this.fromid + ':' + this.fromtype, (data) => {
			// console.log(data)
			if (this.token == data.session) {
				var message = {
					'msg': data.message,
					'type': 'received',
					'color': 'green',
					'pos': 'justify-content-start',
				}
				this.messages.push(message)
				if (!this.status) {
					$('#chat').collapse('show')
				}
			}
		})
		socket.on('chat:UserSignin', (data) => {
			this.messages.push(data.username)
		})
		window.addEventListener('resize', _.debounce(vue.resizeChat, 50))
	},
	methods: {
		markMessagesAsRead: function() {
			var data = new FormData()
			data.append('user_id', this.fromid)
			data.append('user_class', this.fromtype)
			data.append('token', this.token)

			axios.post('/api/v1/remove-notifications', data).then(response => {
				// this call delete all the notifications from this conversation
				// console.log(response)
			})

		},
		checkStatus: function() {
			if ($('#chat').hasClass('show')) {
				this.status = true
				this.scrollToBottom()
			} else {
				this.status = false
			}
		},

		scrollToBottom: function() {
			var element = document.getElementById('chat-messages')
			setTimeout(function() {
				element.scrollTop = element.scrollHeight
			}, 50)
		},

		sendMsg: function(e) {
			e.preventDefault()
			var vue = this

			axios.post('/api/v1/chat-notification', {
					'from_id': vue.fromid,
					'from_type': vue.fromtype,
					'to_id': vue.toid,
					'to_type': vue.totype,
					'token': vue.token,
					'message': vue.msg,
				})
				.then((response) => {
					console.log(response)
					var message = {
						'msg': vue.msg,
						'type': 'sent',
						'color': 'yellow',
						'pos': 'justify-content-end',
					}
					vue.messages.push(message)
					vue.msg = ''
					vue.scrollToBottom()
				})
				.catch((error) => {
					console.log(error)
				})
		},

		loadHistory: function() {
			var vue = this
			axios.post('/api/v1/chat-history', {
					'from_id': vue.fromid,
					'from_type': vue.fromtype,
					'to_id': vue.toid,
					'to_type': vue.totype,
					'token': vue.token,
				})
				.then((response) => {
					if (response.data.success != false) {
						_.each(response.data, (msg) => {
							// console.log(msg);
							var history
							if (msg.from == vue.fromid) {
								history = {
									'msg': msg.message,
									'type': 'sent',
									'color': 'yellow',
									'pos': 'justify-content-end',
								}
								vue.messages.push(history)
							}
							if (msg.from == vue.toid) {
								history = {
									'msg': msg.message,
									'type': 'received',
									'color': 'green',
									'pos': 'justify-content-start',
								}
								vue.messages.push(history)
							}
						})
					} else {
						console.log(response.data.status)
					}
				})
				.catch((error) => {
					console.log(error)
				})
		},

		resizeChat: function() {
			var height = window.innerHeight / 4
			this.$refs['messages'].style.height = height + 'px'
		},

		typingMsg: function() {
			// var vue = this
			// _.debounce(
			//   axios.post('/api/v1/chat-typing', {
			//       'from_id': vue.fromid,
			//       'from_type': vue.fromtype,
			//       'to_id': vue.toid,
			//       'to_type': vue.totype,
			//       'token': vue.token,
			//   })
			//   , 500);

		},
	},
}
</script>
<style lang="scss" scoped>
</style>
