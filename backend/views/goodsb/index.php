<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/4
 * Time: 13:39
 */
?>
    <a href="<?= \yii\helpers\Url::to(['goodsb/add'])?>"class="btn btn-info">添加商品</a>
<form <?= \yii\helpers\Url::to(['goodsb/index'])?> method="get" >
    <input type="text"name="like" class=" placeholderl" value="">
<!--    <input type="text"name="like" value="按商品名搜索" onfocus="javascript:if(this.value=='按商品名搜索')this.value='';">-->
    <button class="glyphicon glyphicon-search"></button>
    </form>


    <table class="table table-bordered">
        <tr>
            <th>id</th>
            <th>货号</th>
            <th>名称</th>
            <th>logo</th>
            <th>库存</th>
            <th>是否在售</th>
            <th>上架时间</th>
            <th>操作</th>
        </tr>
        <?php foreach ($goods as $v): ?>
            <tr>
                <td><?=$v->id?></td>
                <td><?=$v->sn?></td>
                <td><?=$v->name?></td>
                <td><img src="<?=$v->logo?>"width="80" class="img-circle"></td>
                <td><?=$v->stock ?></td>
                <td><?=$v->is_on_sale?'是':'否'?></td>
                <td><?=date('Y-m-d H:i:s' ,$v->create_time)?></td>
                <td>
                    <a href="<?= \yii\helpers\Url::to(['goodsb/delete','id'=>$v->id])?>"class="glyphicon glyphicon-trash"></a>
                    <a href="<?= \yii\helpers\Url::to(['goodsb/edit','id'=>$v->id])?>"class="glyphicon glyphicon-wrench"></a>
                    <a href="<?= \yii\helpers\Url::to(['gallery/gallery','id'=>$v->id])?>"class="glyphicon glyphicon-picture"></a>
                    <a href="<?= \yii\helpers\Url::to(['goodsb/look','id'=>$v->id])?>"class="glyphicon glyphicon-eye-open"></a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php
//分页工具条
echo \yii\widgets\LinkPager::widget([
    'pagination'=>$pager
]);
