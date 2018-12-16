<?php

namespace frontend\components\rest;
use common\models\User;
use common\services\StatisticsService;
use yii\base\Exception;



/**
 * frontend 所有的 controller 都继承自本controller
 * 
 * 用于将所有接口返回的数据转换成json格式
 */
class Controller extends \yii\rest\Controller
{

    protected $_statisticsService;

    //重写$serializer
    public $serializer = 'frontend\components\rest\Serializer';

    public function behaviors()
    {
        $inherit = parent::behaviors();

        $inherit['contentNegotiator']['formats']['application/xml'] = \yii\web\Response::FORMAT_JSON;
        $inherit['contentNegotiator']['formats']['text/html'] = \yii\web\Response::FORMAT_HTML;

        return $inherit;
    }

    /**
     * @return null|\yii\web\IdentityInterface|\frontend\models\User
     */
    protected function getUser()
    {
        $user =  \Yii::$app->user->identity;

        User::updateLastUseTime($user->id);
        try {
            $this->statisticsService->setAU(time(), $user->id);
        }catch( \yii\db\Exception $e){
            //如果redis缓存有问题 就忽略 不能影响其他部分
//            $this->statisticsService = null;

        }
        return $user;
    }

    protected function getStatisticsService()
    {
        if ($this->_statisticsService === null)
            try {
                $this->_statisticsService = new StatisticsService();
            }catch( \yii\db\Exception $e){
                //如果redis缓存有问题 就忽略 不能影响其他部分
                $this->_statisticsService = null;

        }

        return $this->_statisticsService;
    }
}
