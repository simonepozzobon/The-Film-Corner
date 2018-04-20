<template>
<div id="notification" class="row align-items-center" @mouseenter="showDelete" @mouseleave="hideDelete" @click="markAsRead" ref="notification">
	<div class="col">
		<div class="wrapper">
			<div class="icons-left">
				<div class="icon">
					<i v-if="this.approved" class="fa fa-check text-success" />
					<i v-else class="fa fa-exclamation text-danger" />
				</div>
				<div class="icon">
					<i v-if="this.status" class="fa fa-eye text-warning" />
					<i v-else class="fa fa-eye-slash text-danger" />
				</div>
			</div>
			<div class="description">
				<span>{{ this.notification.data.sender.name }}</span> - {{ this.notification.data.session.app.title }}
			</div>
			<div class="icons-right" ref="icons_right">
				<a v-if="this.approved" href="#" class="btn btn-sm btn-blue mr" @click="shareSession">
            Share
          </a>
				<a :href="'/teacher/'+section_slug+'/'+app_cat_slug+'/'+app_slug+'/'+token" class="btn btn-sm btn-blue">
            Open
          </a>
				<i class="fa fa-times text-muted" @click="deleteNotification" />
			</div>
		</div>
	</div>
</div>
</template>
<script>
import {
	TweenMax,
	Power4
} from 'gsap'
import axios from 'axios'
import EventBus from '_js/EventBus'

export default {
	name: 'Notification',
	props: {
		'notification': {
			default: function() {},
			type: [Object, Array]
		}
	},
	computed: {
		status: function() {
			if (this.notification.read_at != null) {
				return true
			}
			return false
		},
		approved: function() {
			if (this.notification.teacher_approved == 1) {
				return true
			}
            return false
		},
		section_slug: function() {
			return this.notification.data.session.app.category.section.slug
		},
		app_cat_slug: function() {
			return this.notification.data.session.app.category.slug
		},
		app_slug: function() {
			return this.notification.data.session.app.slug
		},
		token: function() {
			return this.notification.data.session.token
		}
	},
	mounted: function() {
		this.showNotification()
	},
	methods: {
		showNotification: function() {
			TweenMax.to(this.$refs.notification, .8, {
				opacity: 1,
				display: 'flex',
				easing: Power4.easeInOut
			})
		},
		showDelete: function() {
			TweenMax.to(this.$refs.icons_right, .4, {
				opacity: 1,
				display: 'inherit',
				easing: Power4.easeInOut
			})
		},
		hideDelete: function() {
			TweenMax.to(this.$refs.icons_right, .4, {
				opacity: 0,
				display: 'none',
				easing: Power4.easeInOut
			})
		},
		deleteNotification: function() {
			var vue = this
			var data = new FormData()
			data.append('id', this.notification.id)

			axios.post('/teacher/notifications/destroy', data)
				.then(() => {
					vue.$root.$emit('notification-deleted', this.notification)
				})
		},
		markAsRead: function() {
			this.$root.$emit('notification-mark-as-read', this.notification)
		},
		shareSession: function() {
			var vue = this

			var data = new FormData()
			data.append('token', this.notification.data.session.token)

			axios.post('/teacher/session/share-approved', data)
				.then((response) => {
					EventBus.$emit('session-shared', response)
				})
		},
	}
}
</script>
<style lang="scss" scoped>
@import '~styles/variables';

#notification {
    margin-bottom: $spacer * 3 / 4;
    display: none;
    opacity: 0;

    > .col {
        > .wrapper {
            display: flex;
            align-items: center;
            padding-bottom: $spacer / 3;
            border-bottom: 2px dashed $tfc-dark-blue;

            > .icons-left {
                display: flex;

                > .icon {
                    margin-right: $spacer * 3 / 4;
                    width: $spacer;
                    text-align: center;
                }
            }

            > .description {
                > span {
                    text-transform: capitalize;
                }
            }

            > .icons-right {
                margin-left: auto;
                align-self: center;
                display: none;
                opacity: 0;

                > i {
                    margin-left: $spacer / 2;
                }

                > .mr {
                    margin-right: $spacer / 2;
                }
            }
        }
    }
}
</style>
