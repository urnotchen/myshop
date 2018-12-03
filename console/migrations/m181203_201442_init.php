<?php

use yii\db\Migration;

class m181203_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%goods}}', [
            'id' => $this->primaryKey(),
            'goods_id' => $this->string()->notNull()->unique(),
            'name' => $this->string()->notNull(),
            'content' => $this->text()->notNull(),
            'distributor_prize' => $this->decimal(2)->notNull()->defaultValue(0),
            'sales_initial' => $this->decimal(2)->notNull(),
            'sales_actual' => $this->decimal(2)->notNull(),
            'email' => $this->string()->notNull()->unique(),

            'status' => $this->smallInteger()->unsigned()->notNull()->defaultValue(0),
            'is_delete' => $this->smallInteger()->unsigned()->notNull()->defaultValue(0),
            'sales_begin' => $this->integer()->unsigned()->notNull(),
            'sales_end' => $this->integer()->unsigned()->notNull(),
            'stock_num' => $this->integer()->unsigned()->notNull(),
            'store_id' => $this->integer()->unsigned()->notNull(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'created_by' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
            'updated_by' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%store}}', [
            'id' => $this->primaryKey(),
            'stored_id' => $this->string()->notNull()->unique(),
            'name' => $this->string()->notNull(),
            'phone' => $this->string()->notNull(),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'created_by' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
            'updated_by' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%store_goods}}', [
            'id' => $this->primaryKey(),
            'goods_id' => $this->integer()->unsigned()->notNull(),
            'stored_id' => $this->string()->notNull(),
            'status' => $this->smallInteger()->unsigned()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->unsigned()->notNull(),
            'created_by' => $this->integer()->unsigned()->notNull(),
            'updated_at' => $this->integer()->unsigned()->notNull(),
            'updated_by' => $this->integer()->unsigned()->notNull(),
        ], $tableOptions);


        $this->createTable('{{%order}}', [
            'id' => $this->primaryKey(),
            'order_use_code' => $this->string()->notNull()->unique(),
            'order_id' => $this->string()->notNull(),
            'goods_id' => $this->integer()->unsigned()->notNull(),
            'user_id' => $this->integer()->unsigned()->unique(),
            'num' => $this->smallInteger()->notNull(),
            'order_time' => $this->integer()->unsigned()->unique(),
            'pay_time' => $this->integer()->unsigned()->unique(),
            'use_time' => $this->integer()->unsigned()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);


        $this->createTable('{{%distribution}}', [
            'id' => $this->primaryKey(),
            'distribution_id' => $this->string()->notNull()->unique(),
            'goods_id' => $this->integer()->unsigned()->notNull(),
            'purchaser_id' => $this->integer()->unsigned(),
            'distributor_id' => $this->integer()->unsigned(),
            'prize' => $this->decimal(2)->notNull(),
            'order_id' => $this->integer()->unsigned()->unique(),
            'pay_time' => $this->integer()->unsigned()->unique(),
            'use_time' => $this->integer()->unsigned()->unique(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);


        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->string()->notNull()->unique(),
            'username' => $this->string(32)->notNull()->unique(),
            'password' => $this->string()->notNull(),
            'phone' => $this->integer()->notNull()->unique(),
            'open_id' => $this->string()->notNull()->defaultValue(0),

            'is_distributor' => $this->smallInteger()->notNull()->defaultValue(0),
            'total_prize' => $this->decimal(2)->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);


        $this->createTable('{{%admin}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),

            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%goods}}');
        $this->dropTable('{{%admin}}');
        $this->dropTable('{{%distribution}}');
        $this->dropTable('{{%order}}');
        $this->dropTable('{{%store_goods}}');
        $this->dropTable('{{%store}}');
        $this->dropTable('{{%user}}');
    }
}
