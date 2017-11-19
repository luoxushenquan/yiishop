<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order_goods`.
 */
class m171117_025527_create_order_goods_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('order_goods', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->comment('����id'),
            'goods_id' => $this->integer()->comment('��Ʒid'),
            'goods_name' => $this->string(255)->comment('��Ʒ����'),
            'logo' => $this->string(255)->comment('ͼƬ'),
            'price' => $this->decimal()->comment('�۸�'),
            'amount' => $this->integer()->comment('����'),
            'total' => $this->decimal()->comment('С��'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('order_goods');
    }
}
