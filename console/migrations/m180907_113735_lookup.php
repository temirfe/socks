<?php

use yii\db\Migration;

/**
 * Class m180907_113735_lookup
 */
class m180907_113735_lookup extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('lookup', [
            'id' => $this->primaryKey(),
            'title' => $this->string('200')->notNull(),
            'text' => $this->string('500')->notNull(),
        ],$tableOptions);
        $this->createIndex('idx_lookup_title', 'lookup', 'title');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('lookup');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180907_113735_lookup cannot be reverted.\n";

        return false;
    }
    */
}
