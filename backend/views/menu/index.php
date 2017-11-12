<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/8
 * Time: 11:27
 */
?>

    <a href="<?= \yii\helpers\Url::to(['menu/add'])?>"class="btn btn-info">添加菜单</a>
<table class="table table-bordered">
    <tr>
        <th>名称</th>
        <th>路由</th>
        <th>操作</th>
    </tr>
    <?php foreach($menu as $v):?>
        <tr>
            <td><?=$v->name?></td>
            <td><?=$v->item?></td>
            <td>
                <a href="<?= \yii\helpers\Url::to(['menu/delete','id'=>$v->id])?>"class="glyphicon glyphicon-remove"></a>
                <a href="<?= \yii\helpers\Url::to(['menu/edit','id'=>$v->id])?>"class="glyphicon glyphicon-wrench"></a>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?php
//分页工具条
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$pager
]);
