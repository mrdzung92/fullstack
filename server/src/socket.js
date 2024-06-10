const socketIo = require('socket.io');
const redis = require('./redis');
module.exports = function (server) {
    const io = socketIo(server, {
        cors: {
            origin: "http://localhost:5173",
            methods: ["GET", "POST"],
            credentials: true
        }
    });

    io.on('connection', (socket) => {
        console.log('New client connected ' + socket.id);

        //lắng nghe sự kiện updateUserInfo
        socket.on('updateUserInfo', async (data) => {
            socket.to(socket.id).emit('notify', {msg: 'You have been logged out from another device', type: 'logout'});
            redis.hgetall(`user:${data.username}`)
            .then(existingUser => { 
                if (existingUser) {
                    const current_socket_id = existingUser.socketId;
                    if(existingUser.token !== data.token){
                        socket.to(current_socket_id).emit('notify', {msg: 'You have been logged out from another device', type: 'logout'});
                    }
                    // Update the user data
                    const updatedUser = {
                    ...existingUser,
                    ...data,
                    socketId: socket.id
                    };

                     redis.hmset(`user:${data.username}`, updatedUser);
                } else {
                    console.log('User does not exist:', data.username);
                }
        
            })
            .catch(err => {
              console.log('Error getting user data:', err);
            });
            
        });









        socket.on('disconnect', () => {
            console.log('Client disconnected ' + socket.id);
        });
    });

    return io;
};