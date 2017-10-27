<template>
  <div id="chat" class="collapse" style="width: 25rem;">
    <div class="box container-fluid">
      <div class="row">
        <div class="col dark-blue py-3 px-5">
          <button type="button" class="close" data-toggle="collapse" data-target="#chat" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            <span class="sr-only">Chiudi</span>
          </button>
          <h3>{{toname}}</h3>
        </div>
      </div>
      <div class="row">
        <div id="questo" class="col blue p-5" style="overflow-y: scroll;" ref="messages">
          <div v-for="message in messages" :class="'d-flex '+message.pos+' mb-3'">
            <div :class="'box '+message.color+' p-2 w-75'">
              <span class="msg">{{message.msg}}</span>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col dark-blue px-5 pt-4 pb-2">
          <div class="d-flex justify-content-around">
            <div class="form-group d-inline-block w-75">
              <input @keyup.enter="sendMsg" @keyup="typingMsg" class="form-control" v-model="msg">
            </div>
            <div class="form-group d-inline-block">
              <a @click="sendMsg" href="#" class="btn btn-secondary btn-blue-inverse"><i class="fa fa-paper-plane-o"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
var axios = require('axios');
var io = require('socket.io-client')
var socket = io.connect('http://'+ window.location.hostname +':6001', {reconnect: true});
var _ = require('lodash');
var $ = require('jquery');

export default {
  name: "tfc-chat",
  props: ['fromtype', 'fromid', 'toid', 'totype', 'toname', 'sessiontoken'],
  data: () => ({
      messages: [],
      msg: '',
      conts: '',
  }),
  mounted() {
    var vue = this;
    this.resizeChat();
    this.loadHistory();
    socket.on('connect', function(){
        console.log('CLIENT CONNECTED');
    });
    socket.on('chat:newMessage:'+this.fromid+':'+this.fromtype, (data) => {
        var message = {
            'msg': data.message,
            'type': 'received',
            'color': 'green',
            'pos': 'justify-content-start',
        }
        this.messages.push(message);
    });
    socket.on('chat:UserSignin', (data) => {
        this.messages.push(data.username);
    });
    window.addEventListener( 'resize', _.debounce(vue.resizeChat, 50) );
    $('#chat').on( 'shown.bs.collapse', () => {
        var questo = document.getElementById('questo');
        questo.scrollTop = (questo.scrollHeight - 120);
    });

    // axios.post('/api/v1/chat-typing', {
    //     'from_id': vue.fromid,
    //     'from_type': vue.fromtype,
    //     'to_id': vue.toid,
    //     'to_type': vue.totype,
    //     'token': vue.sessiontoken,
    // }).then((response) => {
    //   console.log(response);
    // });

  },
  methods: {
    sendMsg (e)
    {
        e.preventDefault();
        var vue = this;

        axios.post('/api/v1/chat-notification', {
            'from_id': vue.fromid,
            'from_type': vue.fromtype,
            'to_id': vue.toid,
            'to_type': vue.totype,
            'token': vue.sessiontoken,
            'message' : vue.msg,
        })
        .then((response) => {
            // console.log(response);
            var message = {
              'msg': vue.msg,
              'type': 'sent',
              'color': 'yellow',
              'pos': 'justify-content-end',
            }
            vue.messages.push(message);
            vue.msg = '';
        })
        .catch((error) => {
            console.log(error);
        });
    },

    loadHistory()
    {
        var vue = this;
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
                  if (msg.from == vue.fromid)
                  {
                      var history = {
                          'msg': msg.message,
                          'type': 'sent',
                          'color': 'yellow',
                          'pos': 'justify-content-end',
                      }
                      vue.messages.push(history);
                  }
                  if (msg.from == vue.toid)
                  {
                      var history = {
                          'msg': msg.message,
                          'type': 'received',
                          'color': 'green',
                          'pos': 'justify-content-start',
                      }
                      vue.messages.push(history);
                  }
                });
            }
            else
            {
                console.log(response.data.status);
            }
        })
        .catch((error) => {
            console.log(error);
        })
    },

    resizeChat()
    {
      var height = window.innerHeight / 4;
      this.$refs['messages'].style.height = height+'px';
    },

    typingMsg()
    {
      var vue = this;
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
  .box {
    border-radius: .5rem;
  }
  .box span {
    padding-left: .5rem;
  }
</style>
