<?php

use yii\db\Migration;

/**
 * Class m180830_130621_price
 */
class m180830_133621_price extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('price', [
            'id' => $this->primaryKey(),
            'title' => $this->string('50')->notNull(),
            'title_ru' => $this->string('50')->notNull(),
            'title_ko' => $this->string('50')->notNull(),
            'note' => $this->string('50')->notNull(),
            'note_ru' => $this->string('50')->notNull(),
            'note_ko' => $this->string('50')->notNull(),
            'date_start'=>$this->date(),
            'date_end'=>$this->date(),
            'price'=>$this->integer(),
            'currency' => $this->string('3'),
            'tour_id'=>$this->integer(),
            'group_of'=>$this->smallInteger(5),
        ],$tableOptions);

        $this->createIndex('idx_price_tour', 'price', 'tour_id');

        $this->addForeignKey(
            'fk-price-tour_id','price','tour_id','tour','id',
            'RESTRICT','NO ACTION'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('price');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180830_130621_price cannot be reverted.\n";

        return false;
    }
    */
}
