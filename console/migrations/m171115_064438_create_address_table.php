<?php

use yii\db\Migration;

/**
 * Handles the creation of table `address`.
 */
class m171115_064438_create_address_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('address', [
            'id' => $this->primaryKey(),
            'name' => $this->integer(50)->notNull()->comment('�û�id'),
            'username' => $this->string(50)->notNull()->unique()->comment('�ջ���'),
            'cmbprovince' => $this->string(255)->notNull()->comment('ʡ'),
            'cmbcity' => $this->string(255)->notNull()->comment('��'),
            'cmbarea' => $this->string(255)->notNull()->comment('��'),
            'content' => $this->string(255)->notNull()->comment('��ϸ��ַ'),
            'tel' => $this->char(15)->notNull()->comment('�绰����'),
            'states' => $this->integer(1)->comment('�Ƿ�Ĭ�ϵ�ַ0 �� 1 ��'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('address');
    }
}
