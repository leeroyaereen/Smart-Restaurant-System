const express = require('express');

const app = express();

const menuRoutes = require('./api/routes/menu');

//sets up middleware
//next is used to move the request to next middle ware in line, if we dont execute it the request wont move on
app.use((req, res, next)=>{
    res.status(200).json(/*Object*/{
        message: 'it works'

    });
});

module.exports = app;