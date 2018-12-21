<?php

use yii\db\Migration;

class m181221_301444_add_table_settings extends Migration{

    public function up(){

        $this->createTable('settings',[
            'id' => $this->primaryKey(),
            'key' => $this->string()->notNull(),
            'value' => $this->string()->notNull(),
            'note' => $this->string(),
            'created_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'created_by' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'updated_at' => $this->integer()->unsigned()->notNull()->defaultValue(0),
            'updated_by' => $this->integer()->unsigned()->notNull()->defaultValue(0),
        ]);
    }
}