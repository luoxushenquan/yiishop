<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/3
 * Time: 14:23
 */
namespace backend\controllers;
use backend\models\Brand;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Request;
use yii\web\UploadedFile;

class BrandController extends  Controller{
    public function actionAdd(){
        $model = new Brand();
        $request = new Request();
        if($request->isPost){
            $model->load($request->post());
//        var_dump($model);exit;
            //将上传文件封装成uploadedfile对象
            $model->imgFile = UploadedFile::getInstance($model,'imgFile');
//            var_dump($request->post());exit;
            if($model->validate()){
                $ext= $model->imgFile->extension;//获取上传文件的扩展名
//                var_dump($ext);exit;
                $file = '/upload/'.uniqid().'.'.$ext;
//                var_dump($file);exit;
                $model->imgFile->saveAs(\Yii::getAlias('@webroot').$file,0);
                $model->logo = $file;
                $model->save(0);//$model->validate()
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['index']);
            }
        }
        return $this->render('add', ['model' => $model]);
    }
    /*
     *    //分页
//        $total = Book::find()->count();
            $query=Book::find();
            $pager = new Pagination();
            $pager->totalCount=$query->count();
            $pager->pageSize=5;
            //limit 0 5
            $book = $query->limit($pager->limit)->offset($pager->offset)->all();
            return $this->render('index',['books'=>$book,'pager'=>$pager]);
     */
    public function actionIndex(){
        $brand=Brand::find();
        $pager = new Pagination();
        $pager->totalCount=$brand->count();
        $pager->pageSize=5;
        $brand = $brand->where(['status'=>1])->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('index',['brand'=>$brand,'pager'=>$pager]);
    }
    public function actionDelete($id){
        $brand = Brand::findOne(['id'=>$id]);
        $brand->status=-1;
        $brand->save();
        return $this->redirect(['index']);
    }
    public function actionEdit($id){
        $model = Brand::findOne(['id'=>$id]);
        $request = \yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
//        var_dump($model);exit;
            //将上传文件封装成uploadedfile对象
            $model->imgFile = UploadedFile::getInstance($model,'imgFile');
//            var_dump($request->post());exit;
            if($model->validate()){
                $ext= $model->imgFile->extension;//获取上传文件的扩展名
//                var_dump($ext);exit;
                $file = '/upload/'.uniqid().'.'.$ext;
//                var_dump($file);exit;
                $model->imgFile->saveAs(\Yii::getAlias('@webroot').$file,0);
                $model->logo = $file;
                $model->save(0);//$model->validate()
                \Yii::$app->session->setFlash('success','添加成功');
                return $this->redirect(['index']);
            }
        }
        return $this->render('add', ['model' => $model]);
    }
}