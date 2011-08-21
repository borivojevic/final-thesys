var sys = require("sys")
, http = require("http")
, fs = require("fs")
, path = require("path")
, ws = require('./lib/ws/server')
, qs = require('querystring');

var connections = Array();
var message = null;

var httpServer = http.createServer(function(req, res){
    if (req.method == 'POST') {
        var body = '';
        req.on('data', function (data) {
            body += data;
        });
        req.on('end', function () {
            var post = qs.parse(body);
	    message = JSON.stringify(post);
	    for (var i = 0; i < connections.length; i++) {
		var connection = connections[i];
                server.send(connection.id, message);
            }
        });
    }
    res.end('OK');
});

var server = ws.createServer({
    server: httpServer
});

server.addListener("listening", function(){
    sys.log("Listening for connections.");
});

// Handle WebSocket Requests
server.addListener("connection", function(conn) {
    console.log('[*] open');

    connections.push(conn);

    conn.addListener("message", function(message){
        if (message == 'close') {
            console.log('[-] close requested')
            conn.close();
        } else {
            console.log('[+] ', (new Buffer(message)).inspect());
            server.broadcast("update");
        }
    });
  
    conn.addListener("close", function(){
        console.log('[*] close');
    })
});

server.addListener("disconnect", function(conn){ });

server.listen(7777);
