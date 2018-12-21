<?php

use yii\db\Migration;

class m181221_301443_table_fuser_add_column_prize extends Migration{

    public function up(){

        $this->addColumn(\common\models\FUser::tableName(),'prize_withdrawal',$this->decimal()->unsigned()->notNull()->defaultValue(0));
        $this->addColumn(\common\models\FUser::tableName(),'prize_now',$this->decimal()->unsigned()->notNull()->defaultValue(0));


    }
}