/* our server app */

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

  // channel:event:to_id:to_type - message.data
  io.emit(channel + ':' + message.event + ':' + message.to_id + ':' + message.to_type, message.data);
  console.log('Messaggio ricevuto per ' + message.to_id + ' ' + message.to_type);
  console.log(message +' '+ channel);
});

server.listen('6001');
