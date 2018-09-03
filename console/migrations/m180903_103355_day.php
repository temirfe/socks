<?php

use yii\db\Migration;

/**
 * Class m180903_103355_day
 */
class m180903_103355_day extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('day', [
            'id' => $this->primaryKey(),
            'title' => $this->string('50')->notNull(),
            'title_ru' => $this->string('50')->notNull(),
            'title_ko' => $this->string('50')->notNull(),
            'itinerary' => $this->text()->notNull(),
            'itinerary_ru' => $this->text()->notNull(),
            'itinerary_ko' => $this->text()->notNull(),
            'meals' => $this->string('255')->notNull(),
            'meals_ru' => $this->string('255')->notNull(),
            'meals_ko' => $this->string('255')->notNull(),
            'accommodation' => $this->string('250')->notNull(),
            'accommodation_ru' => $this->string('250')->notNull(),
            'accommodation_ko' => $this->string('250')->notNull(),
            'tour_id'=>$this->integer(),
        ],$tableOptions);

        $this->createIndex('idx_day_tour', 'day', 'tour_id');

        $this->addForeignKey(
            'fk-day-tour','day','tour_id','tour','id',
            'RESTRICT','NO ACTION'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('day');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180903_103355_day cannot be reverted.\n";

        return false;
    }
    */
}
