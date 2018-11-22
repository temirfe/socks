<?php

use yii\db\Migration;

/**
 * Class m181118_064817_banner
 */
class m181118_064817_banner extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('banner', [
            'id' => $this->primaryKey(),
            'image' =>$this->string('200')->notNull(),
            'public' =>$this->boolean(),
            'type' => $this->smallInteger('1')->notNull()->defaultValue(0),
            'link' => $this->string('200')->notNull(),
            'weight' => $this->integer('11')->notNull()->defaultValue(0),
            'title' => $this->string('500')->notNull(),
            'component' => $this->string('50'),
            'component_id' => $this->integer('11'),
        ],$tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('banner');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m181118_064817_banner cannot be reverted.\n";

        return false;
    }
    */
}
