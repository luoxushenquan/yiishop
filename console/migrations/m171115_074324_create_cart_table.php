<?php

use yii\db\Migration;

/**
 * Handles the creation of table `cart`.
 */
class m171115_074324_create_cart_table extends Migration
{
    /**
     * @inheritdoc
     * goods_id	int	��Ʒid
    amount	int	��Ʒ����
    member_id	int	�û�id
     */
    public function up()
    {
        $this->createTable('cart', [
            'id' => $this->primaryKey(),
            'goods_id' => $this->integer()->comment('��Ʒid'),
            'amount' => $this->integer()->comment('��Ʒ����'),
            'member_id' => $this->integer()->comment('�û�id'),

        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('cart');
    }
}
