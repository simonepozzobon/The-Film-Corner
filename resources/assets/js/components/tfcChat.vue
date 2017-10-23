<template>
  <div id="chat" style="width: 30rem">
    <div class="box container-fluid mb-4">
      <div class="row">
        <div class="col dark-blue py-3 px-5">
          <h3>{{title}} - {{type}}</h3>
        </div>
      </div>
      <div class="row">
        <div class="col blue p-5">
          <div class="form-group">
            <select class="form-control" v-model="to_id">
              <option v-for="contact in conts" :value="contact.id">{{contact.name}}</option>
            </select>
          </div>
          <div v-for="message in messages" :class="'d-flex '+message.pos+' mb-3'">
                  <div :class="'box '+message.color+' p-2 w-75'">
                    <p>{{message.msg}}</p>
                  </div>
          </div>
          <div class="form-group">
            <input @keyup.enter="sendMsg" class="form-control" v-model="msg">
          </div>
          <a @click="sendMsg" href="#" class="btn btn-block btn-primary">Send</a>
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
  props: ['title', 'type', 'user', 'contacts'],
  data: () => ({
      messages: [],
      msg: '',
      to_id: '',
      conts: '',
  }),
  mounted() {
    console.log(this.user);
    console.log(this.contacts);
    this.conts = JSON.parse(this.contacts);

    socket.on('chat:UserSignin', (data) => {
      this.messages.push(data.username);
    });

    socket.on('chat:newMessage:'+this.user+':'+this.type, (data) => {
      var message = {
        'msg': data.message,
        'type': 'received',
        'color': 'green',
        'pos': 'justify-content-start',
      }
      this.messages.push(message);
    });
  },
  methods: {
    sendMsg (e)
    {
        e.preventDefault();
        var vue = this;

        if (this.type == 'student') {
          this.to_type = 'teacher';
        } else {
          this.to_type = 'student';
        }
        axios.post('/api/v1/test-notification', {
            'from_id': vue.user,
            'from_type': vue.type,
            'to_id': vue.to_id,
            'to_type': vue.to_type,
            'message' : vue.msg,
        })
        .then((response) => {
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
  },
}
</script>
<style lang="scss" scoped>
</style>
