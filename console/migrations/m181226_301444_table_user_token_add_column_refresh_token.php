<?php

use yii\db\Migration;

class m181226_301444_table_user_token_add_column_refresh_token extends Migration{

    public function up(){

        $this->addColumn(\common\models\UserToken::tableName(),'refresh_token',$this->string(255)->notNull()->defaultValue(0));
    }
}