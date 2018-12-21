<?php

namespace frontend\modules\v1\models\forms;

use common\components\ResponseCode;
use frontend\modules\v1\models\Goods;
use frontend\modules\v1\models\Order;
use yii\base\Model;
use yii\web\HttpException;

class OrderForm extends Model {

    use \frontend\traits\ModelPrepareTrait;

    public $num,$phone,$name,$content,$goods_id,$payment_amount,$total_amount;


    public function rules(){

        return [
            [['goods_id','num','phone','name','payment_amount','total_amount'],'required'],
            [['num','phone'],'integer'],
            [['total_amount','payment_amount'],'number'],
            [['name','content'],'string'],
            ['phone','match','pattern'=>'/^[1][34578][0-9]{9}$/'],
        ];
    }

    public function prepare($rawParams,$runValidation = true){

        $this->load($rawParams, '');

        if ($runValidation) $this->validate();
        $this->validateOrderPrice();

        return $this;
    }

    /*
     * 验证订单总价
     * */
    public function validateOrderPrice(){
        //根据数量和单价进行判断
        //查找到商品
        $goods = Goods::findOneOrException(['goods_id' => $this->goods_id]);
        //总量和价格不符
        if($goods->sales_actual * $this->num != $this->payment_amount){
            throw new HttpException(403, '订单总价不符', ResponseCode::ORDER_PARAMS_ERROR);
        }
        //校验库存
        if($this->num > ($goods->stock_num - $goods->sales_num)){
            throw new HttpException(403,'库存不足',ResponseCode::ORDER_GOODS_NOT_ENOUGH);
        }
        //验证购买时间过没过期
        if(($goods->sales_begin > time()) || ($goods->sales_end < time()) ){
            throw new HttpException(403,'不在售卖时间内无法购买',ResponseCode::ORDER_GOODS_NOT_IN_TIME);
        }

        //校验用户商品购买限额
        $user_id = \Yii::$app->getUser()->id;
        if((Order::getGoodsNum($user_id,$goods) + $this->num) > $goods->max_num){
            throw new HttpException(403,'已超过最大购买限额',ResponseCode::ORDER_GOODS_NOT_ENOUGH);
        }
    }


}