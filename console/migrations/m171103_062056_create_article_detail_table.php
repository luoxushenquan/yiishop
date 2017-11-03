<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_detail`.
 */
class m171103_062056_create_article_detail_table extends Migration
{
    /**
     * @inheritdoc
     * article_id	primaryKey	����id
    content	text	���
     */
    public function up()
    {
        $this->createTable('article_detail', [
            'article_id' => $this->primaryKey()->comment('����id'),
            'content' => $this->text()->comment('���'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('article_detail');
    }
}
