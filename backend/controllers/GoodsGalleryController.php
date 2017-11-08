<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/6
 * Time: 11:36
 * 商品相册  goods id 还没有
 */
namespace backend\controllers;
use backend\models\GoodsGallery;
use GuzzleHttp\Psr7\UploadedFile;
use yii\web\Controller;
use yii\web\Request;

class GoodsGalleryController extends Controller{

        public $enableCsrfValidation=false;
        public function actionAdd(){
            $model = new GoodsGallery();
            $request = new Request();
            if($request->isPost){
                $model->load($request->post());
                if($model->validate()){
                    $model->save(0);//$model->validate()
                    \Yii::$app->session->setFlash('success','添加成功');
                    return $this->redirect(['index']);
                }
            }
            return $this->render('add', ['model' => $model]);

    }
    public function actionUpload()
    {
        if (\yii::$app->request->isPost) {
            $imgFile = UploadedFile::getInstanceByName('file');
            //判断是否文件上传
            if ($imgFile) {
                $fileName = '/upload/' . uniqid() . '.' . $imgFile->extension;
                $imgFile->saveAs(\yii::getAlias('@webroot') . $fileName, 0);

                return Json_encode(['url' => $fileName]);
            }
        }
    }
}