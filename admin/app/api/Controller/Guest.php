<?php
namespace app\api\controller;

use app\api\controller\BaseController;
use app\api\Service\UsersService;
use app\api\Validate\AuthValidate;
use app\model\UsersModel;
use think\captcha\facade\Captcha;

class Guest extends BaseController
{
    public function getVerifyCode()
    {
        $uniqid = uniqid(mt_rand(100000, 999999));
        return json(['success' => true, 'msg' => 'success', 'data' => ['uniqid' => $uniqid, 'captcha_src' => captcha_src() . '?uniqid=' . $uniqid]]);
    }

    public function auth()
    {

        $data = input();
        $dataReturn = [];
        $scene = (isset($data['login_type']) && $data['login_type'] == true) ? 'login' : 'register';

        if (!Captcha::check($data['verify_code'], $data['uniqid']) || empty($data['verify_code']) || empty($data['uniqid'])) {
            return $this->error('验证码错误');
        }

        try {
            validate(AuthValidate::class)->scene($scene)->check($data);
        } catch (\think\exception\ValidateException $e) {
            return $this->error($e->getError());
        }

        if ($scene == 'login') {
            $userInfo = UsersModel::where('username', $data['username'])->findOrEmpty();
            if ($userInfo->isEmpty() || !password_verify($data['password'], $userInfo->password)) {
                return $this->error('用户名或密码错误');
            }

            $userData = [
                'login_time' => time(),
                'login_ip' => ip2long(request()->ip()),
            ];
            $dataReturn = [
                'id' => $userInfo->id,
                'username' => $userInfo->username,
            ];

            UsersModel::where('id', $userInfo->id)->update($userData);
        } else {
            $userData = [
                'username' => $data['username'],
                'password' => password_hash($data['password'], PASSWORD_BCRYPT),
                'invite_code' => UsersService::instance()->genergorInviteCode(),
                'invite_code' => '',
                'register_ip' => ip2long(request()->ip()),
                'register_time' => time(),
                'login_ip' => ip2long(request()->ip()),
                'login_time' => time(),
            ];

            $newUser = UsersModel::create($userData);

            if (!$newUser) {
                return $this->error('注册失败');
            } else {
                $dataReturn = [
                    'id' => $newUser->id,
                    'username' => $newUser->username,
                ];
            }
        }
        $dataReturn['token'] = UsersService::instance()->createJwt($dataReturn);
        UsersService::instance()->saveRedis($dataReturn);
        return $this->success('登录成功', $dataReturn);

    }
}
