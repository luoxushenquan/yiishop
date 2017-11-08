<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/8
 * Time: 11:27
 */
?>

    <a href="<?= \yii\helpers\Url::to(['user/add'])?>"class="btn btn-info">添加用户</a>
<table class="table table-bordered">
    <tr>
        <th>id</th>
        <th>用户名</th>
        <th>email</th>
        <th>创建时间</th>
        <th>最后登录时间</th>
        <th>最后登录ip</th>
        <th>状态</th>
        <th>操作</th>
    </tr>
    <?php foreach($user as $v):?>
        <tr>
            <td><?=$v->id?></td>
            <td><?=$v->username?></td>
            <td><?=$v->email?></td>
            <td><?=date('Y-m-d H:i:s',$v->created_at)?></td>
            <td><?=date('Y-m-d H:i:s',$v->last_login_time)?></td>
            <td><?=$v->last_login_ip?></td>
            <td><?=$v->status?'启用':'禁用'?></td>
            <td>
                <a href="<?= \yii\helpers\Url::to(['user/delete','id'=>$v->id])?>"class="glyphicon glyphicon-remove"></a>
                <a href="<?= \yii\helpers\Url::to(['user/edit','id'=>$v->id])?>"class="glyphicon glyphicon-wrench"></a>
                <a href="<?= \yii\helpers\Url::to(['user/jin','id'=>$v->id])?>"class="glyphicon glyphicon-trash"></a>
            </td>
        </tr>
    <?php endforeach;?>
</table>
<?php
//分页工具条
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$pager
]);
