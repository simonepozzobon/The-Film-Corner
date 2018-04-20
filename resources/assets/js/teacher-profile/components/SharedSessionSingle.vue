<template>
    <div :id="'shared-session-single-'+session.id" class="shared-session-single">
    	<div class="shared-container">
    		<div class="shared-content">
    			<a :href="'/teacher/network/'+session.token">
              {{ session.title }} - {{ session.app.title }} made by {{ session.userable.name }}
            </a>
    		</div>
    		<div class="stats">
    			<div class="stat mr">
    				<div class="text">
    					{{ session.comments_count }}
    				</div>
    				<div class="icon">
    					<i class="fa fa-comment"></i>
    				</div>
    			</div>
    			<div class="stat">
    				<div class="text">
    					{{ session.likes.length }}
    				</div>
    				<div class="icon">
    					<i class="fa fa-heart"></i>
    				</div>
    			</div>
    			<div class="stat delete">
    				<div class="icon">
                        <button class="btn btn-green" @click="deleteSession">
                            <i class="fa fa-trash-o"></i>
                        </button>
                    </div>
    			</div>
    		</div>
    	</div>
        <div :id="'delete-session-'+session.id" class="delete-session">
            <button class="confirm btn btn-green" @click="confirmDelete">
                <i class="fa fa-check"></i>
            </button>
            <button class="undo btn btn-green" @click="deleteSession">
                <i class="fa fa-times"></i>
            </button>
        </div>
    </div>
</template>
<script>
import {TimelineMax} from 'gsap'
import EventBus from '_js/EventBus'

export default {
	name: 'SharedSessionSingle',
	props: {
		session: {
			default: function() {},
			type: Object
		}
	},
    data: function() {
        return {
            isOpen: false,
        }
    },
    methods: {
        deleteSession: function() {
            var vue = this
            if (this.isOpen) {
                // close the panel
                var t1 = new TimelineMax()
                t1.to('#delete-session-'+this.session.id, .2, {
                    display: 'none',
                    opacity: 0,
                    onComplete: function() {
                        vue.isOpen = false
                    }
                })

            } else {
                // open the panel
                var t1 = new TimelineMax()
                t1.to('#delete-session-'+this.session.id, .4, {
                    display: 'flex',
                    opacity: 1,
                    onComplete: function() {
                        vue.isOpen = true
                    }
                })
            }
        },
        confirmDelete: function() {
            var data = new FormData()
            data.append('id', this.session.id)

            axios.post('/teacher/session/shared-destroy', data).then(response => {
                    console.log(response)
                    if (response.data == 'success') {
                        EventBus.$emit('shared-session-deleted', this.session.id)
                    }
                })
                .catch(errors => {
                    console.log(errors)
                })

        }
    }
}
</script>
<style lang="scss" scoped>
@import '~styles/variables';

.shared-session-single {
    > .delete-session {
        display: flex;
        justify-content: center;
        align-items: center;

        display: none;
        opacity: 0;

        > button {
            margin: 0 $spacer $spacer $spacer;
        }
    }

    > .shared-container {
        display: flex;
        align-items: center;
        padding-bottom: $spacer * 2 / 3;

        > .shared-content {
            > a {
                text-transform: capitalize;
                color: $black;
            }
        }

        > .stats {
            margin-left: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;

            > .mr {
                margin-right: $spacer / 2;
            }

            > .stat {
                display: flex;

                > .text {
                    margin-right: $spacer / 4;
                }

                > .icon {
                    color: $gray-light;
                }
            }

            > .delete {
                > .icon {
                    margin-left: $spacer;
                }
            }
        }
    }
}
</style>
