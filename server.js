#!/usr/bin/env nodejs
// var _ = require('lodash')

require('dotenv').load()

let ssl

if (process.env.APP_ENV == 'local') {
    ssl = false
} else {
    ssl = true
}

var fs = require('fs')
var express = require('express')
var app = express()

var serverPort = 6001

if (ssl) {
    var options = {
        key: fs.readFileSync('/etc/letsencrypt/live/thefilmcorner.eu/privkey.pem'),
        cert: fs.readFileSync('/etc/letsencrypt/live/thefilmcorner.eu/fullchain.pem')
    }
    var server = require('https').createServer(options, app)
    console.log('running https')
} else {
    var server = require('http').Server()
}

var io = require ('socket.io')(server)

if (process.env.APP_ENV == 'local') {
    io.set('origins', '*:*')
    // io.set('match origin protocol', true)
}

var Redis = require ('ioredis')
var redis = new Redis()


// canale a cui iscriversi
redis.subscribe('chat')
redis.subscribe('notification')

// evento quando arriva un messaggio su quel canale
redis.on('message', (channel, message) => {
    message = JSON.parse(message)

    if (channel == 'chat') {
        // io.emit(channel + ':' + message.event, message.data) //es. chat:UserSignin, data
        // channel:event:to_id:to_type - message.data
        io.emit(channel + ':' + message.event + ':' + message.to_id + ':' + message.to_type, message.data)
        console.log('Messaggio ricevuto per ' + message.to_id + ' ' + message.to_type + ' - tipo di evento ' + message.event)
        // console.log(channel + ':' + message.event + ':' + message.to_id + ':' + message.to_type)
    }
    else if (channel == 'notification') {
        // channel:event:to_id:to_type - message (complete message)
        io.emit(channel + ':' + message.event + ':' + message.to_id + ':' + message.to_type, message)
        console.log('Notifica ricevuta per ' + message.to_id + ' ' + message.to_type)
    }
})

server.listen(serverPort)

console.log('Server is running at port ', serverPort)
