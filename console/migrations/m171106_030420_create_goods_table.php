<?php

use yii\db\Migration;

/**
 * Handles the creation of table `goods`.
 */
class m171106_030420_create_goods_table extends Migration
{
    /**
     * @inheritdoc
     * id	primaryKey
    name	varchar(20)	��Ʒ����
    sn	varchar(20)	����
    logo	varchar(255)	LOGOͼƬ
    goods_category_id	int	��Ʒ����id
    brand_id	int	Ʒ�Ʒ���
    market_price	decimal(10,2)	�г��۸�
    shop_price	decimal(10, 2)	��Ʒ�۸�
    stock	int	���
    is_on_sale	int(1)	�Ƿ�����(1���� 0�¼�)
    status	inter(1)	״̬(1���� 0����վ)
    sort	int()	����
    create_time	int()	���ʱ��
    view_times	int()	�������
     */
    public function up()
    {
        $this->createTable('goods', [
            'id' => $this->primaryKey(),
            'name' => $this->string(20)->comment('��Ʒ����'),
            'sn' => $this->string(20)->comment('����'),
            'logo' => $this->string(255)->comment('logoͼƬ'),
            'goods_category_id'=> $this->integer()->comment('��Ʒ����id'),
            'brand_id'=> $this->integer()->comment('Ʒ�Ʒ���'),
            'market_price'=> $this->decimal(10,2)->comment('�г��۸�'),
            'shop_price'=> $this->decimal(10,2)->comment('��Ʒ�۸�'),
            'stock'=> $this->integer()->comment('���'),
            'is_on_sale'=> $this->integer()->comment('��(0)����(1)'),
            'status'=> $this->integer(1)->comment('����վ(0)����(1)'),
            'sort'=> $this->integer()->comment('����'),
            'create_time'=> $this->integer()->comment('���ʱ��'),
            'view_times'=> $this->integer()->comment('�����'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('goods');
    }
}
