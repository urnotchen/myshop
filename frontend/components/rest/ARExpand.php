<?php

namespace frontend\components\rest;

use Yii;
use yii\db\ActiveQuery;

class ARExpand extends \yii\base\Object
{

    public $validExpand = [];

    public $expandParam = 'expand';

    /**
     * 获取请求中的 expand 参数 用逗号分隔 ！！不是数组
     * @brief getRequiredExpand 
     *
     * ref: yii\soft\Serializer::getRequestedFields()
     *
     * @return 
     */
    public function getRequestedExpand()
    {/*{{{*/
        $expand = Yii::$app->request->get($this->expandParam);

        return preg_split('/\s*,\s*/', $expand, -1, PREG_SPLIT_NO_EMPTY);
    }/*}}}*/
    
    /*
     * 过滤 额外字段
     */
    public function getFilteredExpand()
    {/*{{{*/
        # array_intersect 比较两个数组的键值，并返回交集
        return array_intersect($this->validExpand, $this->getRequestedExpand());
    }/*}}}*/

    public function queryWithExpand(ActiveQuery $query)
    {/*{{{*/
        $filteredExpand = $this->getFilteredExpand();

        if (empty($filteredExpand)) return;
        
        $query->with($filteredExpand);
    }/*}}}*/

}
