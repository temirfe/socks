<?php

use yii\db\Migration;

/**
 * Class m181124_130453_product
 */
class m181124_130453_product extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('product', [
            'id' => $this->primaryKey(),
            'images' =>$this->string('500')->notNull(),
            'public' =>$this->boolean(),
            'title' => $this->string('500')->notNull(),
            'description' => $this->text(),
            'category_id' => $this->integer('11'),
            'price' => $this->integer('11'),
            'sex' => $this->tinyInteger('1'),
        ],$tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m181124_130453_product cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181124_130453_product cannot be reverted.\n";

        return false;
    }
    */
}
