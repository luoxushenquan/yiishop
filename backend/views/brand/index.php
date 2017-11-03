<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/3
 * Time: 16:28
 */
?>
<a href="<?= \yii\helpers\Url::to(['brand/add'])?>"class="btn btn-info">添加品牌</a>
<table class="table table-bordered">
    <tr>
        <th>id</th>
        <th>品牌</th>
        <th>简介</th>
        <th>logo</th>
        <th>排序</th>
        <th>简介</th>
        <th>操作</th>
    </tr>
    <?php foreach ($brand as $v): ?>
        <tr>
            <td><?=$v->id?></td>
            <td><?=$v->name?></td>
            <td><?=$v->intro?></td>
            <td><img src="<?=$v->logo?>"width="70px"></td>
            <td><?=$v->sort?></td>
            <td><?=$v->status?></td>
            <td>
                <a href="<?= \yii\helpers\Url::to(['brand/delete','id'=>$v->id])?>"class="glyphicon glyphicon-trash"></a>
                <a href="<?= \yii\helpers\Url::to(['brand/edit','id'=>$v->id])?>"class="glyphicon glyphicon-wrench"></a>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
<?php
//分页工具条
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$pager
]);