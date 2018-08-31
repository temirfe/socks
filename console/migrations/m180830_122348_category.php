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
            'title' => $this->string('255')->notNull(),
            'title_ru' => $this->string('255')->notNull(),
            'title_ko' => $this->string('255')->notNull(),
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
