<?php

use yii\db\Migration;

/**
 * Class m180830_122348_category
 */
class m180830_122348_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'parent_id'=>$this->integer(11),
            'title' => $this->string('255'),
            'description' => $this->string('500'),
            'image' =>$this->string('200'),
            'public' =>$this->boolean(),
            'weight'=>$this->integer(2)->notNull()->defaultValue(0),
            'has_product'=>$this->boolean()
        ],$tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('category');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180830_122348_category cannot be reverted.\n";

        return false;
    }
    */
}
