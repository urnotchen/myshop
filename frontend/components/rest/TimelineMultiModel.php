<?php

namespace frontend\components\rest;

use frontend\modules\v1\models\Movie;
use Yii;
use yii\base\InvalidConfigException;

use frontend\components\rest\ARExpand;
use yii\db\Query;

/**
 * TimelineModel class file.
 * @Author haoliang
 * @Date
 *
/**
 * @brief timeline
 *
 * # simply you can do that:
 *
 * public static function timeline($rawParams)
 * {
 *     // and add your filter logic in here.
 *     return $this->preparePullQuery()->findAll();
 * }
 *
 * @return [ActiveRecord,]
 */
abstract class TimelineMultiModel extends \yii\base\Model
{

    use \common\traits\ErrorsJsonTrait;
    use \common\traits\LoadExceptionTrait;
    use \common\traits\ValidateExceptionTrait;

    public $max;
    public $since;
    public $count = 10;

    /**
     * 子类需要进行的配置项
     */
    protected $_modelClass;
    protected $_orderBy;
    protected $_line;
    protected $_primaryKey;
    protected $_validExpand = [];

    protected $_query;
    protected $_maxModel;
    protected $_sinceModel;
    protected $_maxAt;
    protected $_sinceAt;

    # todo make subclass respect these attribute
    protected $_terminate = false;
    protected $_terminateWith = [];

    public function init()
    {/*{{{*/
        parent::init();

        if ($this->_modelClass === null) {
            throw new InvalidConfigException(' property "modelClass" should be set.');
        }
        if ($this->_orderBy === null) {
            throw new InvalidConfigException(' property "orderBy" should be set.');
        }
        if ($this->_line === null) {
            throw new InvalidConfigException(' property "line" should be set.');
        }
        if ($this->_primaryKey === null) {
            throw new InvalidConfigException(' property "primaryKey" should be set.');
        }

    }/*}}}*/

    /*
     * 参数的验证规则
     */
    public function rules()
    {/*{{{*/
        return [
            [['max', 'since'], 'integer', 'min' => 1],
            ['since', 'compare', 'compareValue' => 'max', 'operator' => '!='],
            ['count', 'integer', 'min' => 1],
        ];
    }/*}}}*/

    /*
     * 将查询结果加入到数据库缓存，有效期默认为一小时
     */
    # todo 缓存为3600
    protected function findAll($duration = 1)
    {/*{{{*/
        if ($this->_terminate)
            return $this->_terminateWith;

//        return $this->query->createCommand()->getRawSql();
        $res =  $this->query->all();

        return $res;
        //下面这种方法占用内存过大 废除
//        $modelClass = $this->_modelClass;
//        return $modelClass::getDb()->cache(function ($db) {
//            $res = $this->query->all();
//
//            return $res;
//        }, 1);

    }/*}}}*/

    /*
     * 根据不同的参数模拟不同的操作返回结果
     */
    protected function preparePullQuery()
    {/*{{{*/
        # 如果不存在max 也不存在since，则不更新数据
        if ($this->max === null && $this->since === null) {
            $this->pullZero();
            #Yii::trace('pull zero');
            # 如果存在max 不存在since ，则为上滑操作，获取下面的数据
        } elseif ($this->max !== null && $this->since === null) {
            $this->pullUp();
            #Yii::trace('pull up');
            # 如果不存在max 存在since ，则为下滑操作，获取最新的数据
        } elseif ($this->since !== null && $this->max === null) {
            $this->pullDown();
            #Yii::trace('pull down');
            # 如果存在max 也存在since，则获取中间的内容
        } elseif ($this->since !== null && $this->max !== null) {
            $this->pullInternal();
            #Yii::trace('pull internal');
        }
        # 限制每次返回数据的条数
        $this->limit();
//        return $this->query->createCommand()->getRawSql();
        return $this;
    }/*}}}*/

    /*
     * 限制每次返回数据的条数
     */
    protected function limit()
    {/*{{{*/
        $this->query->limit($this->count);
        return $this;
    }/*}}}*/

    public function pullZero()
    {/*{{{*/
        $this->query->orderBy($this->_orderBy);
    }/*}}}*/

    /*
     * 上拉操作
     */
    protected function pullUp()
    {/*{{{*/

        $this->query->orderBy($this->_orderBy)
            ->andWhere(['>=', $this->_line, $this->maxAt])
            ->andWhere(['not', [$this->_primaryKey => $this->max]])
        ;


    }/*}}}*/

    /*
     * 下拉操作
     */
    protected function pullDown()
    {/*{{{*/
        $this->query->orderBy($this->_orderBy)
            ->andWhere(['<=', $this->_line, $this->sinceAt])
            ->andWhere(['not', [$this->_primaryKey => $this->since]])
        ;
    }/*}}}*/

    /*
     * 获取中间数据的操作
     */
    protected function pullInternal()
    {/*{{{*/
        $this->query->orderBy($this->_orderBy)
            ->andWhere(['<=', $this->_line, $this->sinceAt])
            ->andWhere(['>=', $this->_line, $this->maxAt])
            ->andWhere(['not', [$this->_primaryKey => [$this->since, $this->max]]])
        ;
    }/*}}}*/

    protected function getQuery()
    {/*{{{*/
        if ($this->_query === null) {

            $modelClass = $this->_modelClass;
            $this->_query = $modelClass::find();
        }

        return $this->_query;
    }/*}}}*/

    /*
     * 获取指定字段的上限值，用于筛选
     */
    protected function getMaxAt()
    {/*{{{*/
        if ($this->_maxAt === null) {
            /* 如果primaryKey与line使用一个字段, 那么 maxAt = max */
            if ($this->_primaryKey != $this->_line) {
                $this->_maxAt = $this->maxModel->{$this->_line};
            } else {
                $this->_maxAt = $this->max;
            }
        }

        return $this->_maxAt;
    }/*}}}*/

    /*
     * 获取指定字段的下限值，用于筛选
     */
    protected function getSinceAt()
    {/*{{{*/
        if ($this->_sinceAt === null) {
            /* 如果primaryKey与line使用一个字段, 那么 sinceAt = since */
            if ($this->_primaryKey != $this->_line) {
                $this->_sinceAt = $this->sinceModel->{$this->_line};
            } else {
                $this->_sinceAt = $this->since;
            }
        }

        return $this->_sinceAt;
    }/*}}}*/

    //获取主键为max的实例
    protected function getMaxModel()
    {/*{{{*/
        if ($this->_maxModel === null) {
            $this->_maxModel = $this->getMaxModelInternal();
        }

        return $this->_maxModel;
    }/*}}}*/

    //获取主键为since的实例
    protected function getSinceModel()
    {/*{{{*/
        if ($this->_sinceModel === null) {
            $this->_sinceModel = $this->getSinceModelInternal();
        }

        return $this->_sinceModel;
    }/*}}}*/

    //获取主键为max的实例
    protected function getMaxModelInternal()
    {/*{{{*/

//        $res = $this->query->all();
//        foreach($this->query->all() as $one){
//
//            if($one->{$this->_primaryKey} == $this->max){
////
//                return $one;
//
//            }
//
//        }
        //复制this->query,如果直接在query上进行操作的话会影响最后的结果
        $query2 = clone $this->_query;

        return $query2->select("idTemp")->andWhere([$this->_primaryKey => $this->max])->one();

    }/*}}}*/

    //获取主键为since的实例
    protected function getSinceModelInternal()
    {/*{{{*/
//        $modelClass = $this->_modelClass;
//
//        return $modelClass::findOneOrException([
//            $this->_primaryKey => $this->since
//        ]);

//        foreach($this->query->all() as $one){
//
//            if($one->{$this->_primaryKey} == $this->since){
//
//                return $one;
//
//            }
//        }

        $query2 = clone $this->_query;

        return  $query2->select("idTemp")->andWhere([$this->_primaryKey => $this->since])->one();

    }/*}}}*/

    protected function terminateWith($value)
    {/*{{{*/
        $this->_terminate = true;
        $this->_terminateWith = [];
    }/*}}}*/

    /*
     * 获取扩展参数
     */
    protected function withExpand()
    {/*{{{*/
        if (empty($this->_validExpand)) return;

        $arExpand = new ARExpand(['validExpand' => $this->_validExpand]);

        $arExpand->queryWithExpand($this->query);
    }/*}}}*/

//    protected function getResult(){
//        file_put_contents("C:/phpStudy/weixinLog/". date('Ymd') ."elog.txt",time() ." ". date("m-d H:i:s")
//            .'//$将 raw html 处理成 Array $essay_list 文章sn一致= '. '123'."\r\n\r\n",FILE_APPEND);
//        $this->_result = $this->query->all();
//        return $this->_result;
//    }

}
