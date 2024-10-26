const http = require('http');
const app = require('./app');//we can add .js behind the app as well

/*
    if not set we use 3000 as default
*/
const port = process.env.PORT || 3000;

/*
    Create a server with http package
    we need to pass listener in parameters 
*/
const server = http.createServer(app);

server.listen(port);//listens to the port above