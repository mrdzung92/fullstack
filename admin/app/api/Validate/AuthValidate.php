<?php
namespace app\api\Validate;

use think\Validate;
use app\model\UsersModel;
class AuthValidate extends Validate
{
    protected $rule = [
        'username' => 'require|max:45',
        'password' => 'require',
        'password_confirm' => 'require|confirm:password',
        'invite_code' => 'checkInviteCode',
    ];

    protected $message = [
        'username.require' => '用户名不能为空',
        'username.max' => '用户名长度不能超过45个字符',
        'password.require' => '密码不能为空',
        'password_confirm.require' => '确认密码不能为空',
        'password_confirm.confirm' => '两次密码不一致',
        'invite_code.checkInviteCode' => '邀请码不存在',
        'username.unique' => '用户名已存在',
        'username.regex' => '用户名只能包含字母、数字和下划线，长度4-45个字符',
    ];

    public function sceneLogin()
    {
        return $this->only(['username', 'password'])->remove('password_confirm');
    }

    public function sceneRegister()
    {
        return $this->append('username', ['unique:users,username', 'regex:/^[a-zA-Z0-9_]{4,45}$/']);
        
       

    }

    protected function checkInviteCode($value, $rule, $data = [])
    {
        if (empty($value)) {
            return true;
        }
        $user = UsersModel::where('invite_code', $value)->findOrEmpty();
        if ($user->isEmpty()) {
            return '邀请码不存在';
        }
        return true;
    }

}
