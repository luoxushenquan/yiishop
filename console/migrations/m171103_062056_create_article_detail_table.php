<?php

use yii\db\Migration;

/**
 * Handles the creation of table `article_detail`.
 */
class m171103_062056_create_article_detail_table extends Migration
{
    /**
     * @inheritdoc
     * article_id	primaryKey	ÎÄÕÂid
    content	text	¼ò½é
     */
    public function up()
    {
        $this->createTable('article_detail', [
            'article_id' => $this->primaryKey()->comment('ÎÄÕÂid'),
            'content' => $this->text()->comment('¼ò½é'),
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
