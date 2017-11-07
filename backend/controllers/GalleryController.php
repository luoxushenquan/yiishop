<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/6
 * Time: 19:41
 */
namespace backend\controllers;
use backend\models\GoodsGallery;
use yii\web\Controller;
use yii\web\Request;
use yii\web\UploadedFile;

class GalleryController extends Controller
{
    public $enableCsrfValidation=false;
    public function actionGallery($id){
        $gallery=GoodsGallery::find()->where(['goods_id'=>$id])->all();
        return $this->render('index',['gallery'=>$gallery,'id'=>$id]);
    }
    //添加相册
    public function actionAdd($id){

       $model = new GoodsGallery();
        $request = new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->goods_id=$id;
                $model->save(0);//$model->validate()
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['gallery/gallery','id'=>$id]);
            }
        }

        return $this->render('add',['model'=>$model]);
    }
    public function actionDelete($id,$goods_id){
        $gallery = GoodsGallery::findOne(['id'=>$id]);
        $gallery->delete();
        \Yii::$app->session->setFlash('success','删除成功');
        return $this->redirect(['gallery/gallery','id'=>$goods_id]);
    }

    public function actionUpload()
    {
        if (\yii::$app->request->isPost) {
            //1111111111111111111111
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