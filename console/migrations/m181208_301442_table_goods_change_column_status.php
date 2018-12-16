<?php

use yii\db\Migration;

class m181208_301442_table_goods_change_column_status extends Migration{

    public function up(){

        $this->renameColumn(\common\models\Goods::tableName(),'status','goods_status');
        $this->renameColumn(\common\models\Goods::tableName(),'is_delete','sale_status');
    }
}