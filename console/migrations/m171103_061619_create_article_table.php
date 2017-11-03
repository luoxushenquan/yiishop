<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article`.
 */
class m171103_061619_create_article_table extends Migration
{
    /**
     * @inheritdoc
     * id	primaryKey
    name	varchar(50)	����
    intro	text	���
    article_category_id	int()	���·���id
    sort	int(11)	����
    status	int(2)	״̬(-1ɾ�� 0���� 1����)
    create_time	int(11)	����ʱ��
     */
    public function up()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'name'=>$this->string(50)->notNull()->comment('����'),
            'intro'=>$this->text(50)->notNull()->comment('���'),
            'article_category_id'=>$this->integer(50)->notNull()->comment('���·���id'),
            'sort'=>$this->integer(50)->notNull()->comment('����'),
            'status'=>$this->integer(50)->notNull()->comment('״̬'),
            'create_time'=>$this->integer(11)->notNull()->comment('����ʱ��'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article');
    }
}
