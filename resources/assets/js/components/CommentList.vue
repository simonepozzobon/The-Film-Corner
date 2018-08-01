<template>
    <div id="comment-list">
        <div v-for="(comment, index) in this.comments_list" :key="comment.key" class="comment row mt">
            <comment-single
                :comment="comment"
                :user="userConv"
                :user_type="userType"/>
        </div>
    </div>
</template>
<script>
import CommentSingle from './CommentSingle.vue'

export default {
    name: 'CommentList',
    components: {
        CommentSingle
    },
    props: {
        'comments': {
            type: String,
            default: '',
        },
        'user': {
            type: String,
            default: '',
        },
        'user_type': {
            type: String,
            default: '',
        }
    },
    data: function() {
        return {
            comments_list: ''
        }
    },
    computed: {
        commentsArr: function() {
            return JSON.parse(this.comments)
        },
        userConv: function() {
            return JSON.parse(this.user)
        },
        userType: function() {
            return this.user_type
        },
    },
    methods: {
        addComment: function(comment) {
            this.comments_list.push(comment)
        },
        deleteComment: function(id) {
            this.comments_list = this.comments_list.filter(function(value) {
                return value.id !== id;
            });
        }
    },
    mounted: function() {
        this.comments_list = this.commentsArr

        this.$parent.$on('newComment', comment => {
            this.addComment(comment)
        })

        this.$on('commentDelete', id => {
            this.deleteComment(id)
        })
    },

}
</script>
<style lang="scss" scoped>
</style>
