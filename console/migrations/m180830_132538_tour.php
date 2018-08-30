<?php

use yii\db\Migration;

/**
 * Class m180830_132538_tour
 */
class m180830_132538_tour extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('tour', [
            'id' => $this->primaryKey(),
            'title' => $this->string('255')->notNull(),
            'image' => $this->string('50')->notNull(),
            'description' => $this->text()->notNull(),
            'days'=>$this->smallInteger(2),
            'category_id'=>$this->integer(),
            'destination_id'=>$this->integer(),
        ],$tableOptions);

        $this->createIndex('idx_tour_ctg', 'tour', 'category_id');
        $this->createIndex('idx_tour_dest', 'tour', 'destination_id');

        $this->addForeignKey(
            'fk-tour-ctg','tour','category_id','category','id',
            'RESTRICT','NO ACTION'
        );
        $this->addForeignKey(
            'fk-tour-dest','tour','destination_id','destination','id',
            'RESTRICT','NO ACTION'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('tour');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180830_132538_tour cannot be reverted.\n";

        return false;
    }
    */
}
