<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/6
 * Time: 18:29
 *
 * 添加相册
 */
$form=\yii\bootstrap\ActiveForm::begin();

echo $form->field($model,'path')->hiddenInput();
//========================上传logo插件

$this->registerCssFile('@web/webuploader/webuploader.css');
$this->registerJsFile('@web/webuploader/webuploader.js',[
    'depends'=>\yii\web\JqueryAsset::className(),//制定依赖
    'position'=>\yii\web\View::POS_END//加载文件的路径
]);
$url = \yii\helpers\Url::to(['upload']);
$this->registerJs(
    <<<JS
var uploader = WebUploader.create({
    // 选完文件后，是否自动上传。
    auto: true,
    // swf文件路径
     swf:'/js/Uploader.swf',
    // 文件接收服务端。
    server: '{$url}',
    // 选择文件的按钮。可选。
    // 内部根据当前运行是创建，可能是input元素，也可能是flash.
    pick: '#filePicker',
    // 只允许选择图片文件。
    accept: {
        title: 'Images',
        extensions: 'gif,jpg,jpeg,bmp,png',
        mimeTypes: 'image/jpg,image/jpeg,image/png'//弹出选择框慢的问题
    }
});

//文件上传成功 回显图片
uploader.on( 'uploadSuccess', function( file ,response) {
   // $( '#'+file.id ).addClass('upload-state-done');
//=======================url没出来
    //将图片地址赋值给img
    console.debug(response);
    $("#img").attr('src',response.url);
    //将图片地址写入logo
        $('#goodsgallery-path').val(response.url)
});
JS
)
?>

<div id="uploader-demo">
    <!--用来存放item-->
    <div id="fileList" class="uploader-list"></div>
    <div id="filePicker">选择图片</div>
</div>
<div><img id="img" width="500px"></div>
<?php
echo '<input type="submit" class="btn btn-primary" value="上传">';
\yii\bootstrap\ActiveForm::end();