<template>
  <div id="chat" class="collapse" style="width: 25rem;">
    <div class="box container-fluid">
      <div class="row">
        <div class="col dark-blue py-3 px-5">
          <h3>{{toname}}</h3>
        </div>
      </div>
      <div class="row">
        <div class="col blue p-5" style="height: 20rem; overflow-y: scroll;">
          <div v-for="message in messages" :class="'d-flex '+message.pos+' mb-3'">
                  <div :class="'box '+message.color+' p-2 w-75'">
                    <p>{{message.msg}}</p>
                  </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col blue px-5 pb-5">
          <div class="form-group">
            <input @keyup.enter="sendMsg" class="form-control" v-model="msg">
          </div>
          <a @click="sendMsg" href="#" class="btn btn-block btn-secondary btn-blue"><i class="fa fa-paper-plane-o"></i> Send</a>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
var axios = require('axios');

var io = require('socket.io-client')
var socket = io.connect('http://localhost:6001', {reconnect: true});

export default {
  name: "tfc-chat",
  props: ['fromtype', 'fromid', 'toid', 'totype', 'toname', 'sessiontoken'],
  data: () => ({
      messages: [],
      msg: '',
      conts: '',
  }),
  mounted() {
    // this.loadHistory();
    // console.log('check 1', socket.connected);
    // socket.on('connect', function() {
    //   console.log('check 2', socket.connected);
    //
    // });
    socket.on('chat:newMessage:'+this.fromid+':'+this.fromtype, (data) => {
      console.log('new message');
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
    console.log(socket);
    console.log('chat:newMessage:'+this.fromid+':'+this.fromtype);

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
          console.log(response);
            var message = {
              'msg': vue.msg,
              'type': 'sent',
              'color': 'orange',
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
              console.log(msg);
              if (msg.from == vue.fromid)
              {
                  var history = {
                      'msg': msg.message,
                      'type': 'sent',
                      'color': 'orange',
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
    }

  },
}
</script>
<style lang="scss" scoped>
</style>
