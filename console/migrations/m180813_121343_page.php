<?php

use yii\db\Migration;

/**
 * Class m180813_121343_page
 */
class m180813_121343_page extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('page', [
            'id' => $this->primaryKey(),
            'title' => $this->string('255')->notNull(),
            'title_ru' => $this->string('255')->notNull(),
            'title_ko' => $this->string('255')->notNull(),
            'category' => $this->string('20')->notNull(),
            'text' => $this->text()->notNull(),
            'text_ru' => $this->text()->notNull(),
            'text_ko' => $this->text()->notNull(),
        ],$tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('page');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180813_121343_page cannot be reverted.\n";

        return false;
    }
    */
}
