<?php

use yii\db\Migration;

/**
 * Class m180830_122816_destination
 */
class m180830_122816_destination extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('destination', [
            'id' => $this->primaryKey(),
            'title' => $this->string('255')->notNull(),
            'image' => $this->string('50')->notNull(),
            'intro' => $this->string('500')->notNull(),
            'text' => $this->text()->notNull(),
        ],$tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('destination');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180830_122816_destination cannot be reverted.\n";

        return false;
    }
    */
}
