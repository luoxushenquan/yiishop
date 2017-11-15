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
            'name' => $this->integer(50)->notNull()->comment('用户id'),
            'username' => $this->string(50)->notNull()->unique()->comment('收货人'),
            'cmbprovince' => $this->string(255)->notNull()->comment('省'),
            'cmbcity' => $this->string(255)->notNull()->comment('市'),
            'cmbarea' => $this->string(255)->notNull()->comment('县'),
            'content' => $this->string(255)->notNull()->comment('详细地址'),
            'tel' => $this->char(15)->notNull()->comment('电话号码'),
            'states' => $this->integer(1)->comment('是否默认地址0 否 1 是'),
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
