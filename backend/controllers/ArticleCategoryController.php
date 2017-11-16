<?php
namespace backend\controllers;

use backend\filters\RbacFilter;
use backend\models\ArticleCategory;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Request;

class ArticleCategoryController extends  Controller{
    public function actionAdd(){
        $model = new ArticleCategory();
        $request = new Request();
        if($request->isPost) {
            $model->load($request->post());
            if ($model->validate()) {
                $model->save(0);//$model->validate()
                \Yii::$app->session->setFlash('success', '添加成功');
                return $this->redirect(['article-category/index']);
            }
        }
        return $this->render('add', ['model' => $model]);
    }
    public function actionIndex(){

        $category=ArticleCategory::find();
        $pager = new Pagination();
        $pager->totalCount=$category->count();
        $pager->pageSize=5;
        $category = $category->where(['status'=>1])->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('index',['category'=>$category,'pager'=>$pager]);
    }
    public function actionDelete($id){
        $category = ArticleCategory::findOne(['id'=>$id]);
        $category->status=-1;
        $category->save();
        return $this->redirect(['article-category/index']);
    }
    public function actionEdit($id){
        $model=ArticleCategory::findOne(['id'=>$id]);
        $request=\yii::$app->request;
        if($request->isPost) {
            $model->load($request->post());
            if ($model->validate()) {
                $model->save(0);//$model->validate()
                \Yii::$app->session->setFlash('success', '添加成功');
                return $this->redirect(['article-category/index']);
            }
        }
        return $this->render('add', ['model' => $model]);
    }
    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>RbacFilter::className(),
                'except'=>['login','upload']
            ]
        ];
    }
}