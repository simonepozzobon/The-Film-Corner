<template>
  <div id="teacher-profile" class="row mt">
    <div class="col-md-8">
      <sessions :notifications="notificationsParsed"/>
    </div>
    <div class="col-md-4">
      <student-panel :students="studentsParsed"/>
    </div>
  </div>
</template>
<script>
import Sessions from './Sessions.vue'
import StudentPanel from './StudentPanel.vue'

var io = require('socket.io-client')
var socket = io.connect('http://'+ window.location.hostname +':6001', {reconnect: true})


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
    }
  },
  computed: {
    studentsParsed: function()
    {
      return JSON.parse(this.students)
    },
    notificationsParsed: function()
    {
      return JSON.parse(this.notifications)
    }
  },
  data: () => ({

  }),
  mounted() {
    socket.on('connect', function(){
      console.log('CLIENT CONNECTED')
    })

    // need to be changed to notifications
    socket.on('chat:newMessage:'+this.fromid+':'+this.fromtype, (data) => {
      var message = {
        'msg': data.message,
        'type': 'received',
        'color': 'green',
        'pos': 'justify-content-start',
      }
      this.messages.push(message)
    })
  },
  components: {
    Sessions,
    StudentPanel
  }
}
</script>
<style lang="scss" scoped>
</style>
