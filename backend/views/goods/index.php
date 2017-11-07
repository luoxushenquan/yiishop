<?php
///* @var $this yii\web\View */
//?>
<!--<h1>goods/index</h1>-->
<!---->
<!--<p>-->
<!--    You may change the content of this page by modifying-->
<!--    the file <code>--><?//= __FILE__; ?><!--</code>.-->
<!--</p>-->
<!--    depth	int()	层级-->
<!--    name	varchar(50)	名称-->
<!--    parent_id	int()	上级分类id-->
<!--    intro	text()	简介-->
    <a href="<?= \yii\helpers\Url::to(['goods/add-category'])?>"class="btn btn-info">添加品牌</a>
    <table class="table table-bordered">
        <tr>
            <th>层级</th>
            <th>名称</th>
            <th>上级分类</th>
            <th>简介</th>
            <th>操作</th>
        </tr>
        <?php foreach ($goodsCategory as $v): ?>
            <tr>
                <td><?=$v->depth?></td>
                <td><?=$v->name?></td>
                <td><?=$v->parent_id?></td>
                <td><?=$v->intro?></td>
                <td>
                    <a href="<?= \yii\helpers\Url::to(['goods/delete','id'=>$v->id])?>"class="glyphicon glyphicon-trash"></a>
                    <a href="<?= \yii\helpers\Url::to(['goods/edit','id'=>$v->id])?>"class="glyphicon glyphicon-wrench"></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php
//分页工具条
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$pager
]);