<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods_day_count`.
 */
class m171106_030115_create_goods_day_count_table extends Migration
{
    /**
     * @inheritdoc
     * day	date	����
    count	int	��Ʒ��
     */
    public function up()
    {
        $this->createTable('goods_day_count', [
            'day' => $this->date(),
            'count' => $this->integer(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods_day_count');
    }
}
