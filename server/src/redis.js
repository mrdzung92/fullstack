const Redis = require('ioredis');
const redis = new Redis();

redis.on('connect', () => {
  console.log('Connected to Redis');
});

redis.on('error', (err) => {
  console.log('Redis error: ', err);
});




module.exports = redis;