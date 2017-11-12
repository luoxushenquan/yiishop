<?php

use yii\db\Migration;

/**
 * Handles the creation of table `member`.
 */
class m171112_034922_create_member_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('member', [
            'id' => $this->primaryKey(),
            'username' => $this->string(50)->notNull()->unique()->comment('�û���'),
            'auth_key' => $this->string(32)->notNull()->comment(''),
            'password_hash' => $this->string()->notNull()->comment('����(����)'),
            'email' => $this->string()->notNull()->unique()->comment('����'),
            'tel' => $this->char(11)->notNull()->unique()->comment('�绰����'),
            'last_login_time' => $this->integer()->notNull()->comment('����½ʱ��'),
            'last_login_ip' => $this->integer()->notNull()->comment('����¼ip'),
            'status' => $this->smallInteger()->notNull()->comment('״̬(1����,0ɾ��)'),
            'created_at' => $this->integer()->notNull()->comment('���ʱ��'),
            'updated_at' => $this->integer()->notNull()->comment('�޸�ʱ��'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('member');
    }
}
