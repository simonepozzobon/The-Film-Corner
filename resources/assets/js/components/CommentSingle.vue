<template>
    <div class="col">
        <div :class="'box '+color">
            <div class="box-header">
                <div class="title">
                    {{ comment.author.name }}

                </div>
                <div class="time">
                    {{ comment.time }}
                </div>
            </div>
            <div class="box-body" ref="comment">
                {{ comment.comment }}
            </div>
            <div id="confirmation" class="box-btns pt" ref="confirmation">
                <button @click="destroy(comment.id)" :class="'btn btn-'+color" v-show="this.canDelete">
                    <i class="fa fa-trash-o"></i> Confirm
                </button>
                <button @click="undo" :class="'btn btn-'+color"><i class="fa fa-undo"></i> Cancel</button>
            </div>
            <div class="box-btns">
                <button @click="confirmation" type="button" name="button" :class="'btn btn-'+color"><i class="fa fa-trash-o"></i> Delete</button>
                <button @click="newReply" type="button" name="button" :class="'btn btn-'+color"><i class="fa fa-comments-o"></i> Reply</button>
            </div>
        </div>
        <div id="reply" :class="'box mt '+reply_color" ref="newReply">
            <div class="box-header">
                <div class="title">
                    Reply to {{ comment.author.name }}
                </div>
                <div class="icon" ref="close" @click="closeReply">
                    <i class="fa fa-times"></i>
                </div>
            </div>
            <div class="box-body">
                <textarea v-model="reply_msg" name="comment" class="form-control"></textarea>
            </div>
            <div class="box-btns">
                <button @click="sendReply" type="button" name="button" :class="'btn btn-'+reply_color"><i class="fa fa-comment-o"></i> Send</button>
            </div>
        </div>
        <replies-list :replies="comment.replies" :user="user" :user_type="user_type"></replies-list>
    </div>
</template>
<script>
import _ from 'lodash'
import axios from 'axios'
import { TweenMax, Power4, TimelineMax } from "gsap"

import RepliesList from './Comments/RepliesList.vue'
import ReplyNew from './Comments/ReplyNew.vue'

export default {
    name: 'CommentSingle',
    components: {
        RepliesList
    },
    props: {
        'comment': {
            type: Object,
            default: function() {}
        },
        'user': {
            type: Object,
            default: ''
        },
        'user_type': {
            type: String,
            default: ''
        }
    },
    data: function() {
        return {
            reply_msg: '',
            colors: ['green', 'yellow', 'orange', 'blue'],
        }
    },
    computed: {
        canDelete: function() {
            if (this.user.id == this.comment.userable_id && this.user_type == this.comment.userable_type) {
                return true
            }
            return false
        },
        color: function() {
            return this.colors[this.index]
        },
        index: function() {
            return Math.floor(Math.random() * 3)
        },
        reply_color: function() {
            return this.colors[this.index + 1]
        },
    },
    methods: {
        confirmation: function() {
            var t1 = new TimelineMax()
            t1.to(this.$refs.comment, .4, {
                    opacity: 0,
                    ease: Power4.easeInOut,
                    onComplete: () => {
                        this.$refs.comment.style.display = 'none'
                        this.$refs.confirmation.style.display = 'inherit'
                    }
                })
                .to(this.$refs.confirmation, .4, {
                    opacity: 1,
                    ease: Power4.easeInOut,
                })
        },
        undo: function() {
            var t1 = new TimelineMax();
            t1.to(this.$refs.confirmation, .4, {
                    opacity: 1,
                    ease: Power4.easeInOut,
                    onComplete: () => {
                        this.$refs.confirmation.style.display = 'none';
                        this.$refs.comment.style.display = 'inherit';
                    }
                })
                .to(this.$refs.comment, .4, {
                    opacity: 1,
                    ease: Power4.easeInOut
                })
        },
        destroy: function(id) {
            if (this.canDelete) {
                var formData = new FormData()
                formData.append('id', id)
                formData.append('user_id', this.user.id)
                formData.append('user_type', this.user_type)

                axios.post('/api/v1/destroy-comment', formData)
                .then(response => {
                    if (response.data.success) {
                        this.$parent.$emit('commentDelete', id)
                    }
                })
                .catch(error => {
                    console.log(error)
                });
            }

        },

        // reply
        newReply: function() {
            this.$refs.newReply.style.display = 'inherit'
            var t1 = new TimelineMax()
            t1.to(this.$refs.newReply, .4, {
                height: 'auto',
                opacity: 1
            })
        },
        closeReply: function() {
            var t1 = new TimelineMax();
            t1.to(this.$refs.newReply, .2, {
                    opacity: 0,
                })
                .to(this.$refs.newReply, .2, {
                    height: 0,
                    display: 'none'
                })
        },
        sendReply: function() {
            var formData = new FormData()
            formData.append('comment', this.reply_msg)
            formData.append('user', this.user.id)
            formData.append('user_type', this.user_type)
            formData.append('commentable_type', 'App\\Comment')
            formData.append('commentable_id', this.comment.id)

            axios.post('/api/v1/send-comment', formData).then(response => {
                this.comment.replies.push(response.data)
                this.closeReply()
            }).catch(error => {
                console.log(error)
            })
        },
    },
    mounted: function() {
    },
}
</script>
<style lang="scss" scoped>
#confirmation {
    display: none;
    opacity: 0;
}

.box-header {
    display: flex;
    flex-direction: row;
    justify-content: space-between;

    > .time {
        align-self: flex-end;
        font-size: 1rem;
        line-height: 1.62;
        font-weight: normal;
        text-transform: lowercase;
    }
}

#reply {
    display: none;
    height: 0;
    opacity: 0;

    > .box-header {
        display: flex;
        flex-direction: row;
        justify-content: space-between;

        > .icon {
            cursor: pointer;
        }
    }
}
</style>
