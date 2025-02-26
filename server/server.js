const express = require('express');
const http = require('http');
const { Server } = require('socket.io');

const app = express();
const server = http.createServer(app);
const io = new Server(server, {
    cors: {
        origin: "*", // Разрешить все источники (для разработки)
        methods: ["GET", "POST"]
    }
});

io.on('connection', (socket) => {
    console.log('a user connected');

    // Обработка отправки сообщения
    socket.on('sendMessage', (data) => {
        // Отправляем сообщение всем пользователям в комнате
        io.to(data.chatId).emit('receiveMessage', data);
    });

    // Присоединение к комнате чата
    socket.on('joinChat', (chatId) => {
        socket.join(chatId);
        console.log(`User joined chat: ${chatId}`);
    });

    socket.on('disconnect', () => {
        console.log('user disconnected');
    });
});

server.listen(3000, () => {
    console.log('Socket.IO server is running on port 3000');
});