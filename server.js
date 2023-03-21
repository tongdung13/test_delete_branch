var app = require("express")();
var server = require("http").Server(app);
var io = require("socket.io")(server, {
    cors: {
      origin: '*',
      allowedHeaders: ["authorization"]
    }
});
var redis = require("redis");

server.listen(8890);
io.on("connection", function (socket) {
    var redisClient = redis.createClient();
    redisClient.subscribe("message");

    redisClient.on("message", function (channel, data) {
        socket.emit(channel, data);
    });

    socket.on("disconnect", function () {
        redisClient.quit();
    });
});
