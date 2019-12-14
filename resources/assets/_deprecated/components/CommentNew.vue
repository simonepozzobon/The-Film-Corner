<template>
    <div id="" class="row mt">
        <div class="col">
            <div id="comment-new" class="box yellow">
                <div class="box-header">
                    <div class="title">
                        {{ title }}
                    </div>
                    <div class="icon" @click="close" ref="close">
                        <i class="fa fa-times"></i>
                    </div>
                </div>
                <div class="box-body" ref="textarea">
                    <textarea v-model="comment" name="comment" class="form-control" rows="4"></textarea>
                </div>
                <div class="box-btns pt">
                    <button @click="show" class="btn btn-yellow new-comment" ref="showBtn">
                        <i class="fa fa-comment-o"></i> New Comment
                    </button>
                    <button @click="sendComment" class="btn btn-yellow send-comment" ref="commentBtn">
                        <i class="fa fa-comment-o"></i> Send
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
<script>

import axios from 'axios'
import { TweenMax, Power4, TimelineMax } from 'gsap'

export default {
    name: "new-comment",
    props: ['csrf_field', 'user', 'user_type', 'commentable_type', 'commentable_id'],
    data: function() {
        return {
            comment: '',
            title: 'Join the discussion',
            open: false,
        }
    },
    methods: {
        sendComment: function() {
            var formData = new FormData();
            formData.append('_token', this.csrf_field);
            formData.append('comment', this.comment);
            formData.append('user', this.user);
            formData.append('user_type', this.user_type);
            formData.append('commentable_type', this.commentable_type);
            formData.append('commentable_id', this.commentable_id);

            axios.post('/api/v1/send-comment', formData).then(response => {
                    // console.log(response);
                    this.$parent.$emit('newComment', response.data);
                    this.comment = '';
                    this.close()
                }).catch(error => {
                    console.log(error);
                });
        },
        show: function() {
            var t1 = new TimelineMax()
            t1.to(this.$refs.showBtn, .4, {
                    opacity: 0,
                    display: 'none',
                    ease: Power4.easeInOut,
                })
                .to(this.$refs.commentBtn, .2, {
                    opacity: 1,
                    display: 'block'
                })

            var t2 = new TimelineMax()
            t2.from(this.$refs.textarea, .5, {
                position: 'relative',
                height: 0,
            })

            var t2_2 = new TimelineMax()
            t2_2.to(this.$refs.textarea, .5, {
                opacity: 1,
                display: 'block',
            })

            var t3 = new TimelineMax()
            t3.to(this.$refs.close, .2, {
                opacity: 1,
                display: 'block'
            })

            var master = new TimelineMax()
            master.add(t1, .1)
            master.add(t2, .1)
            master.add(t2_2, .1)
            master.add(t3, .1)
            master.play()
        },
        close: function() {
            var t1 = new TimelineMax()
            t1.to(this.$refs.commentBtn, .2, {
                    opacity: 0,
                    display: 'none'
                })
                .to(this.$refs.showBtn, .4, {
                    opacity: 1,
                    display: 'block',
                })


            var t2 = new TimelineMax()
            t2.to(this.$refs.textarea, .4, {
                opacity: 0,
                display: 'none',
            })

            var t3 = new TimelineMax()
            t3.to(this.$refs.close, .2, {
                opacity: 0,
                display: 'none'
            })

            var master = new TimelineMax()
            master.add(t1)
            master.add(t2)
            master.add(t3)
            master.play()

        },
    },
}
</script>
<style lang="scss">
#comment-new {
    .box-header {
        display: flex;
        flex-direction: row;
        justify-content: space-between;

        > .icon {
            cursor: pointer;
            display: none;
            opacity: 0;
        }
    }

    .box-body {
        display: none;
        opacity: 0;
        padding-bottom: 0;
    }

    .box-btns {
        .send-comment {
            display: none;
            opacity: 0;
        }
    }
}
</style>
