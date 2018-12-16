<?php

use yii\db\Migration;

class m181208_301443_table_store_add_column_address extends Migration{

    public function up(){

        $this->addColumn(\common\models\Store::tableName(),'address',$this->string()->notNull());
    }
}