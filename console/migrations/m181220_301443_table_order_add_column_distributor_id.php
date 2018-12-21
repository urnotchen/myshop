<?php

use yii\db\Migration;

class m181220_301443_table_order_add_column_distributor_id extends Migration{

    public function up(){

        $this->addColumn(\common\models\Order::tableName(),'distributor_id',$this->integer()->unsigned()->notNull()->defaultValue(0));


        $this->addColumn(\common\models\Distribution::tableName(),'status',$this->smallInteger()->unsigned()->notNull()->defaultValue(0));
    }
}