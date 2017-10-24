/* our server app */

var _ = require('lodash');

var server = require ('http').Server();
var io = require ('socket.io')(server);
var Redis = require ('ioredis');
var redis = new Redis();


// canale a cui iscriversi
redis.subscribe('chat');

// evento quando arriva un messaggio su quel canale
redis.on('message', (channel, message) => {
  message = JSON.parse(message);
  // io.emit(channel + ':' + message.event, message.data); //es. chat:UserSignin, data
  io.emit('test', 'ciao');
  console.log(' ');
  io.clients((error, clients) => {
    if (error) throw error;
    _.each(clients, (client) => {
      console.log('client ', client);
    })
  });
  // channel:event:to_id:to_type - message.data
  io.emit(channel + ':' + message.event + ':' + message.to_id + ':' + message.to_type, message.data);
  console.log('Messaggio ricevuto per ' + message.to_id + ' ' + message.to_type);
  console.log(message +' '+ channel);
  console.log(channel + ':' + message.event + ':' + message.to_id + ':' + message.to_type);
});

server.listen('6001');
