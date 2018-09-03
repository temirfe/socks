<?php

use yii\db\Migration;

/**
 * Class m180903_103721_package
 */
class m180903_103721_package extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('package', [
            'id' => $this->primaryKey(),
            'included' => $this->text()->notNull(),
            'included_ru' => $this->text()->notNull(),
            'included_ko' => $this->text()->notNull(),
            'not_included' => $this->text()->notNull(),
            'not_included_ru' => $this->text()->notNull(),
            'not_included_ko' => $this->text()->notNull(),
            'tour_id'=>$this->integer(),
        ],$tableOptions);

        $this->createIndex('idx_package_tour', 'package', 'tour_id');

        $this->addForeignKey(
            'fk-package-tour','package','tour_id','tour','id',
            'RESTRICT','NO ACTION'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('package');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180903_103721_package cannot be reverted.\n";

        return false;
    }
    */
}
