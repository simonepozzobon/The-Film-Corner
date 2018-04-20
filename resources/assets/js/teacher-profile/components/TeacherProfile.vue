<template>
	<div id="teacher-profile" class="row mt">
		<div class="col-md-8">
			<sessions :title="translationParsed.activities" :notifications="notificationsUpdated" />
			<shared-sessions :title="translationParsed.network" :sessions="sharedSessions" />
		</div>
		<div class="col-md-4">
			<student-panel :title="translationParsed.students" :students="studentsParsed" />
		</div>
	</div>
</template>
<script>
import Sessions from './Sessions.vue'
import StudentPanel from './StudentPanel.vue'
import SharedSessions from './SharedSessions.vue'
import EventBus from '_js/EventBus'

import axios from 'axios'
import _ from 'lodash'
var io = require('socket.io-client')
var socket = io.connect('http://' + window.location.hostname + ':6001', {
	reconnect: true
})

export default {
	name: 'TeacherProfile',
	props: {
		students: {
			default: '',
			type: String
		},
		notifications: {
			default: '',
			type: String
		},
		user: {
			default: '',
			type: String
		},
		user_type: {
			default: '',
			type: String
		},
		shared_sessions: {
			default: '',
			type: String
		},
		translation: {
			default: '',
			type: String
		}
	},
	computed: {
		studentsParsed: function() {
			return JSON.parse(this.students)
		},
		notificationsParsed: function() {
			var parsed = JSON.parse(this.notifications)
			parsed = _.each(parsed, (single) => {
				single.data = single.notification.data
				single.read_at = single.notification.read_at
				single.id = single.notification.id
			})
			return parsed
		},
		userParsed: function() {
			return JSON.parse(this.user)
		},
		shared_sessionsParsed: function() {
			return JSON.parse(this.shared_sessions)
		},
		translationParsed: function() {
			return JSON.parse(this.translation)
		},
	},
	data: () => ({
		notificationsUpdated: [],
		sharedSessions: [],
	}),
	mounted() {
		var vue = this
		this.notificationsUpdated = this.notificationsParsed
		this.sharedSessions = this.shared_sessionsParsed

		socket.on('connect', function() {
			console.log('CLIENT CONNECTED')
		})

		// need to be changed to notifications
		socket.on('chat:newMessage:' + this.fromid + ':' + this.fromtype, (data) => {
			var message = {
				'msg': data.message,
				'type': 'received',
				'color': 'green',
				'pos': 'justify-content-start',
			}
			this.messages.push(message)
		})

		socket.on('notification:newSharedSession:' + this.userParsed.id + ':' + this.user_type, (data) => {
			vue.pushNotification(data)
		})

		this.$root.$on('notification-deleted', notification => {
			this.deleteNotification(notification)
		})

		this.$root.$on('notification-mark-as-read', notification => {
			this.markAsRead(notification)
		})

		EventBus.$on('session-shared', response => {
			console.log('ricevuto', response)
			this.sharedSessions.push(response.session)
		})

		EventBus.$on('shared-session-deleted', id => {
			var index = this.sharedSessions.findIndex(function(session) {
				return session.id == id
			})
			if (index > -1) {
				this.sharedSessions.splice(index, 1)
			}
		})
	},
	methods: {
		pushNotification: function(notification) {
			this.notificationsUpdated.unshift(notification)
		},
		deleteNotification: function(notification) {
			this.notificationsUpdated = this.notificationsUpdated.filter(function(value) {
				return value.id !== notification.id
			})
		},
		markAsRead: function(notification) {
			var foundIndex = this.notificationsUpdated.findIndex((element) => {
				return element.id == notification.id
			})
			if (foundIndex != -1) {
				if (this.notificationsUpdated[foundIndex].read_at == null) {
					this.notificationsUpdated[foundIndex].read_at = 10
					axios.get('/teacher/notifications/markasread/' + this.notificationsUpdated[foundIndex].id)
				} else {
					this.notificationsUpdated[foundIndex].read_at = null

					var data = new FormData()
					data.append('id', this.notificationsUpdated[foundIndex].id)

					axios.post('/teacher/notifications/markasunread', data)
				}
			}
		}
	},
	components: {
		Sessions,
		StudentPanel,
		SharedSessions
	}
}
</script>
<style lang="scss" scoped>
</style>
