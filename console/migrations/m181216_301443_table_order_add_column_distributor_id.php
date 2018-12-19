<?php

use yii\db\Migration;

class m181216_301443_table_order_add_column_distributor_id extends Migration{

    public function up(){

        $this->addColumn(\common\models\Order::tableName(),'distribution_id',$this->integer()->unsigned()->notNull()->defaultValue(0));
        $this->addColumn(\common\models\Order::tableName(),'total_amount',$this->decimal(11,2)->unsigned()->notNull()->defaultValue(0));
        $this->addColumn(\common\models\Order::tableName(),'payment_amount',$this->decimal(11,2)->unsigned()->notNull()->defaultValue(0));
        $this->addColumn(\common\models\Order::tableName(),'pay_status',$this->smallInteger()->unsigned()->notNull()->defaultValue(0));
        $this->renameColumn(\common\models\Order::tableName(),'status','order_status');

        $this->addColumn(\common\models\Goods::tableName(),'max_num',$this->integer()->unsigned()->notNull()->defaultValue(1));
    }
}