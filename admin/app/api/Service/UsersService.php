<?php

namespace app\api\Service;

use app\model\UsersModel;
use Firebase\JWT\JWT;
use think\admin\service\AdminService;
use think\facade\Config;

/**
 * 插件服务注册
 * @class UsersService
 * @package app\api\Service
 */
class UsersService extends AdminService
{

    public function genergorInviteCode()
    {
        $characters = '23456789abcdefghijkmnopqrstuvwxyz';
        do {
            $inviteCode = '';
            for ($i = 0; $i < 6; $i++) {
                $index = rand(0, strlen($characters) - 1);
                $inviteCode .= $characters[$index];
            }
            $check = UsersModel::where('invite_code', $inviteCode)->findOrEmpty();
        } while (!$check->isEmpty());
        return $inviteCode;
    }

    /**
     * 创建JWT
     * @param array $payload   用户数据 id 和 username
     * @return string
     */

    public function createJwt($payload)
    {
        $key = Config::get('config.jwt_secret_key');
        $payload['login_time'] = time();
        return JWT::encode($payload, $key, 'HS256');
    }

    public function verifyJwt($jwt)
    {
        $key = Config::get('config.jwt_secret_key');
        return JWT::decode($jwt, $key, ['HS256']);
    }

    /**
     * 保存用户信息到Redis
     * @param array $userInfo 用户信息
     */
    public function saveRedis($userInfo)
    {
        $redis = new \think\cache\driver\Redis(Config::get('config.redis'));
        $username = $userInfo['username'];
        $userData = [
            'username' => $username,
            'socketId' => '',
            'token' => '',
            'login_time' => time(),
        ];

        // Lấy thông tin người dùng hiện có từ Redis nếu có
        $existingUser = $redis->hgetall("user:$username");
        if ($existingUser) {
            $userData['socketId'] = $existingUser['socketId'];
        }

        // Cập nhật thông tin người dùng trong Redis
        $redis->hmset("user:$username", $userData);

        // Thêm tên người dùng vào tập hợp 'usernames'
        $redis->sadd('usernames', $username);
    }

    /**
     * Xóa thông tin người dùng khỏi Redis
     * @param string $username Tên người dùng
     */
    public function deleteUserFromRedis($username){
        $redis = new \think\cache\driver\Redis(Config::get('config.redis'));
        $redis->del("user:$username");
        $redis->srem('usernames', $username);
    }

}
