<?php
//
//namespace common\components;
//
//use Yii;
//use commmon\models\User as UserModel;
//use yii\web\IdentityInterface;
//
///**
// * User class file.
// * @Author haoliang
// * @Date 06.09.2015 19:14
// */
//class User extends \yii\web\User
//{
//
//    public function loginRequired($checkAjax = true, $checkAcceptHeader = true)
//    {/*{{{*/
//        $this->loginUrl .= '?return_url=' . Yii::$app->getRequest()->getAbsoluteUrl();
//
//        return parent::loginRequired($checkAjax);
//    }/*}}}*/
//
//    /**
//     * 验证账号是否被禁用
//     * @return bool
//     */
//    public function checkStatus()
//    {
//        $user = UserModel::findOne($this->id);
//
//        if (isset($user->status) && ($user->status == $user::STATUS_ACTIVE)) {
//            $baseUser = $user->baseUser;
//            if (isset($baseUser->status) && ($baseUser->status == $baseUser::STATUS_ACTIVE)) {
//                return true;
//            }
//        }
//
//        return false;
//    }
//
//    /**
//     * 修改密码后该账号所有客户端立即重新登录
//     * @return bool
//     */
//    public function checkAuthKey()
//    {
//        // 获取cookie
//        $value = isset($_COOKIE[$this->identityCookie['name']]) ? $_COOKIE[$this->identityCookie['name']] : null;
//
//        // 截取 a:2:{i:0;s:9:"_identity";i:1;s:49:"["92","kE8H5lAJIL9spWYXbNoDHFcfqxUvoEoV",2592000]";}
//        $index = strpos($value, 'a:');
//
//        // 允许出现没有cookie的情况，为了防止误阻断正常用户登录，对cookie格式不正确的用户尽量宽大处理
//        if ($index == false) {
//            return true;
//        }
//
//        // 截取有效字符串
//        $value = substr($value, $index);
//        $value = @unserialize($value);
//
//        if (! isset($value[1])) {
//            return true;
//        }
//
//        $data = json_decode($value[1], true);
//
//        if (count($data) !== 3 || !isset($data[0], $data[1], $data[2])) {
//            return true;
//        }
//
//        list ($id, $authKey, $duration) = $data;
//
//        /* @var $class IdentityInterface */
//        $class = $this->identityClass;
//        $identity = $class::findIdentity($id);
//        if ($identity === null) {
//            return false;
//        } elseif (!$identity instanceof IdentityInterface) {
//            return false;
//        }
//
//        return $identity->validateAuthKey($authKey);
//    }
//
//
//}
