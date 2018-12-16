<?php

namespace frontend\modules\v1\models\forms;

use yii\base\Model;

class OrderForm extends Model {

    public $num,$phone,$name,$content;


    public function rules(){

        return [
            [['num','phone','name'],'required'],
            [['num','phone'],'integer'],
            [['name','content'],'string'],
        ];
    }

    public function prepare($rawParams,$runValidation = true){

        $this->load($rawParams, '');

        if ($runValidation) $this->validate();

        return $this;
    }

}