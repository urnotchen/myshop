<?php

use yii\db\Migration;

class m181203_301442_add_column extends Migration{

    public function up(){

        $this->addColumn(\common\models\Goods::tableName(),'sales_num',$this->integer()->unsigned()->notNull()->defaultValue(0));
    }
}