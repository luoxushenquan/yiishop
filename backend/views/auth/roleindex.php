
<?php
/* @var $this yii\web\View */

$this->registerCssFile('@web/DataTables-1.10.15/media/css/jquery.dataTables.css');
$this->registerJsFile('@web/DataTables-1.10.15/media/js/jquery.dataTables.js',[
    'depends'=>\yii\web\JqueryAsset::className()//指定依赖
]);
?>

    <a href="<?= \yii\helpers\Url::to(['auth/addrole'])?>"class="btn btn-info">添加角色</a>
    <table id="table_id_example" class="display">
        <thead>
        <tr>
            <th>名称</th>
            <th>描述</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($role as $v):?>
            <tr>
                <td><?=$v->name?></td>
                <td><?=$v->description?></td>
                <td>
                    <a href="<?= \yii\helpers\Url::to(['auth/roledelete','role'=>$v->name])?>"class="glyphicon glyphicon-trash"></a>
                    <a href="<?= \yii\helpers\Url::to(['auth/roleedit','role'=>$v->name])?>"class="glyphicon glyphicon-wrench"></a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php
$this->registerJs(<<<Js
   $(document).ready( function () {
        $('#table_id_example').DataTable();
    } );
Js
);

