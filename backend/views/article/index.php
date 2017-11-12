<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/4
 * Time: 13:39
 */
?>
    <a href="<?= \yii\helpers\Url::to(['article/add'])?>"class="btn btn-info">添加文章</a>
    <table class="table table-bordered">
        <tr>
            <th>id</th>
            <th>文章名</th>
            <th>简介</th>
            <th>文章分类</th>
            <th>排序</th>
            <th>发布时间</th>
            <th>操作</th>
        </tr>
        <?php foreach ($article as $v): ?>
            <tr>
                <td><?=$v->id?></td>
                <td><?=$v->name?></td>
                <td><?=$v->intro?></td>
                <td><?=$v->article_category_id ?></td>
                <td><?=$v->sort?></td>
                <td><?=$v->create_time?></td>
                <td>
                    <a href="<?= \yii\helpers\Url::to(['article/delete','id'=>$v->id])?>"class="glyphicon glyphicon-trash"></a>
                    <a href="<?= \yii\helpers\Url::to(['article/edit','id'=>$v->id])?>"class="glyphicon glyphicon-wrench"></a>
                    <a href="<?= \yii\helpers\Url::to(['article/detail','id'=>$v->id])?>"class="glyphicon glyphicon-search"></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php
//分页工具条
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$pager
]);
