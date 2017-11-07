<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/6
 * Time: 19:46
 */
?>
<a  href='<?= \yii\helpers\Url::to(["gallery/add","id"=>"$id"])?>'class="btn btn-info" >添加相册</a><br/>
<!--这个不行-->
<input type="hidden" name="id" value="$id">
<?php foreach($gallery as $v):?>
    <p><img src="<?=$v->path?>" class="img-thumbnail" class="img-responsive">
    <a href="<?= \yii\helpers\Url::to(['gallery/delete','id'=>$v->id,'goods_id'=>$id])?>"class="btn btn-danger">删除</a></p>


<?php endforeach; ?>