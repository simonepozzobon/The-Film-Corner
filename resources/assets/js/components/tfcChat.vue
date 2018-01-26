<template>
  <div id="chat" class="collapse" style="width: 25rem;">
    <div class="box blue">
      <div class="box-header">
        To: {{ toname }}
      </div>
      <div class="box-body chat">
        <div id="questo" class="messages" ref="messages">
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
var socket = io.connect('http://'+ window.location.hostname +':6002', {reconnect: true})
var _ = require('lodash')
var $ = require('jquery')

export default {
  name: 'TfcChat',
  props: ['fromtype', 'fromid', 'toid', 'totype', 'toname', 'sessiontoken'],
  data: () => ({
    messages: [],
    msg: '',
    conts: '',
  }),
  mounted() {
    var vue = this
    this.resizeChat()
    this.loadHistory()
    socket.on('connect', function(){
      console.log('CLIENT CONNECTED')
    })
    socket.on('chat:newMessage:'+this.fromid+':'+this.fromtype, (data) => {
      var message = {
        'msg': data.message,
        'type': 'received',
        'color': 'green',
        'pos': 'justify-content-start',
      }
      this.messages.push(message)
    })
    socket.on('chat:UserSignin', (data) => {
      this.messages.push(data.username)
    })
    window.addEventListener( 'resize', _.debounce(vue.resizeChat, 50) )
    $('#chat').on( 'shown.bs.collapse', () => {
      var questo = document.getElementById('questo')
      questo.scrollTop = (questo.scrollHeight)
    })

  },
  methods: {
    sendMsg (e)
    {
      e.preventDefault()
      var vue = this

      axios.post('/api/v1/chat-notification', {
        'from_id': vue.fromid,
        'from_type': vue.fromtype,
        'to_id': vue.toid,
        'to_type': vue.totype,
        'token': vue.sessiontoken,
        'message' : vue.msg,
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
        })
        .catch((error) => {
          console.log(error)
        })
    },

    loadHistory()
    {
      var vue = this
      axios.post('/api/v1/chat-history', {
        'from_id': vue.fromid,
        'from_type': vue.fromtype,
        'to_id': vue.toid,
        'to_type': vue.totype,
        'token': vue.sessiontoken,
      })
        .then((response) => {
          if (response.data.success != false)
          {
            _.each(response.data, (msg) => {
              // console.log(msg);
              var history
              if (msg.from == vue.fromid)
              {
                history = {
                  'msg': msg.message,
                  'type': 'sent',
                  'color': 'yellow',
                  'pos': 'justify-content-end',
                }
                vue.messages.push(history)
              }
              if (msg.from == vue.toid)
              {
                history = {
                  'msg': msg.message,
                  'type': 'received',
                  'color': 'green',
                  'pos': 'justify-content-start',
                }
                vue.messages.push(history)
              }
            })
          }
          else
          {
            console.log(response.data.status)
          }
        })
        .catch((error) => {
          console.log(error)
        })
    },

    resizeChat()
    {
      var height = window.innerHeight / 4
      this.$refs['messages'].style.height = height+'px'
    },

    typingMsg()
    {
      // var vue = this
      // _.debounce(
      //   axios.post('/api/v1/chat-typing', {
      //       'from_id': vue.fromid,
      //       'from_type': vue.fromtype,
      //       'to_id': vue.toid,
      //       'to_type': vue.totype,
      //       'token': vue.sessiontoken,
      //   })
      //   , 500);

    },
  },
}
</script>
<style lang="scss" scoped>
</style>
