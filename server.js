var app = require('express')();
var server = require('http').Server(app);
var io = require('socket.io')(server);
var redis = require('redis');

server.listen(8890);
io.on('connection', function (socket) {
    console.log('connect success');
    var redisClient = redis.createClient();
    redisClient.subscribe('message');

    redisClient.on('message', function (channel, data) {
        socket.emit(channel, data);
    });

    socket.on('DistConnect', function () {
        redisClient.quit();
    });
});

