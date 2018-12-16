<?php
namespace backend\modules\goods\models\form;

use backend\modules\goods\models\Goods;
use backend\modules\goods\models\Store;
use yii\base\Model;

class GoodsDetailsForm extends Model
{

    const SEPARATOR = '~';

    public $name,$content,$sales_initial,$sales_actual,$sales_begin,$sales_end,$stock_num,$store_id,$distributor_prize,$status,
                $sales_begin_end;



    public function rules()
    {
        return [
            [['name','content','sales_initial','sales_actual','stock_num','store_id','sales_begin_end'],'required'],
            [['sales_initial','sales_actual'], 'number','min' => 100],
//            [['pic_ids'], 'validatePic','skipOnEmpty' => false],
            [['stock_num','stock_num','status'],'integer'],
            ['sales_begin_end','validateRange'],
            [['store_id'], 'exist','targetClass' => Store::className(),'targetAttribute' => 'id'],
        ];
    }

    public function validateText($attr,$params){

        if ($this->hasErrors()) return false;
        //判断是否为空，是否超过140字
        if(mb_strlen($this->weibo_text) == 0){
            $this->addError($attr,'微博内容不能为空');
        }
        if(mb_strlen($this->weibo_text) > 140){
            $this->addError($attr,'微博内容不能超过140字');
        }
    }

//    public function validatePic($attr){
//
//        if ($this->hasErrors()) return false;
//
//        if(!$this->pic_ids){
//            return ;
//        }
//        $picArr = explode(',',$this->pic_ids);
//
//        if(!is_array($picArr)){
//            $this->addError($attr,'图片格式有误，请重新上传');
//        }
//        if(count($picArr) > 9 ){
//            $this->addError($attr,'最多上传9张图片');
//        }
//
//        $this->pic_ids = $picArr;
//    }


    public function validateRange($attr, $params)
    {
        echo 223;
        $this->addError($attr, '发布时间格式错误.');
        if ($this->hasErrors()) return false;

        $sales_begin_end = explode(self::SEPARATOR, $this->sales_begin_end);
        var_export($sales_begin_end);
        if (!is_array($sales_begin_end) || count($sales_begin_end) != 2) {
            $this->addError($attr, '发布时间格式错误.');
            return false;
        }

        foreach ($sales_begin_end as $v) {
            $time = strtotime($v);
            $temp[] = $time;
            if ($time === false) {
                $this->addError($attr, '发布时间格式错误.');
                break;
            }
        }
        var_export($temp);die;

        $this->sales_begin = $temp[0];
        $this->sales_end = $temp[1];
    }


    public function attributeLabels()
    {
        return [
            'name' => '商品名称',
            'content' => '商品内容',
            'distributor_prize' => '分销商奖金',
            'sales_initial' => '原价',
            'sales_actual' => '现价',
            'status' => '状态',
            'sales_begin_end' => '售卖时间',
            'stock_num' => '售卖总量',
            'store_id' => '商家',
        ];
    }

    public function saveGoods(){

        $goods = new Goods();
        $goods->distributor_prize= $this->distributor_prize;
        $goods->name= $this->name;
        $goods->content= $this->content;
        $goods->sales_initial= $this->sales_initial;
        $goods->sales_actual= $this->sales_actual;
        $goods->status= $this->status;
        $goods->sales_begin= $this->sales_begin;
        $goods->sales_end= $this->sales_end;
        $goods->stock_num= $this->stock_num;
        $goods->store_id= $this->store_id;
         $goods->save();
//        var_dump($goods);
    }
}