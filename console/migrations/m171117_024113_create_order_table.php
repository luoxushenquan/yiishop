<?php

use yii\db\Migration;

/**
 * Handles the creation of table `order`.
 */
class m171117_024113_create_order_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'member_id'=>$this->integer()->comment('�û�id'),
            'name'=>$this->string(50)->comment('�ջ���'),
            'province'=>$this->string(20)->comment('ʡ'),
            'city'=>$this->string(20)->comment('��'),
            'area'=>$this->string(20)->comment('��'),
            'address'=>$this->string(255)->comment('��ϸ��ַ'),
            'tel'=>$this->char(11)->comment('�绰����'),
            'delivery_id'=>$this->integer()->comment('���ͷ�ʽid'),
            'delivery_name'=>$this->string()->comment('���ͷ�����'),
            'delivery_price'=>$this->string()->comment('���ͷ�ʽ�۸�'),
            'payment_id'=>$this->integer()->comment('֧����ʽid'),
            'payment_name'=>$this->string()->comment('֧����������'),
            'total'=>$this->decimal()->comment('�������'),
            'status'=>$this->integer()->comment('����״̬ 0 ȡ�� 1 ��֧�� 2 �������'),
            'trade_no'=>$this->string()->comment('���������׺�'),
            'create_time'=>$this->integer()->comment('����ʱ��'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('order');
    }
}
