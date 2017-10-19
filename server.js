/* our server app */

var app = require ('express');
var server = require ('http');
var io = require ('socket.io');
var redis = require ('redis');

server.listen('6001');
io.on('connection', (socket) => {
  console.log('Client connected');
  var redisClient = redis.createClient();

  redisClient.subscribe('message');
  redisClient.on('message', (channel, message) => {
    console.log('new event' + message + channel);
  });

  redisClient.on('disconnect', () => {
    redisClient.quit();
  })
})
