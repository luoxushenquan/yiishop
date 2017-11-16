<?php

namespace backend\controllers;

use backend\filters\RbacFilter;
use backend\models\GoodsCategory;
use yii\data\Pagination;

class GoodsController extends \yii\web\Controller
{


    public function actionAddCategory(){
    $model =new GoodsCategory();
        //parent_id默认值
//        $model->parent_id=0;
        $request=\Yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                if($model->parent_id==0){
                    $model->makeRoot();
                    return $this->redirect(['index']);
                }else{
                    //添加子节点
                    $parent=GoodsCategory::findOne(['id'=>$model->parent_id]);
                    $model->prependTo($parent);
                    return $this->redirect(['index']);
                }


            }
        }
//        var_dump($model);exit;
        return $this->render('add-category',['model'=>$model]);
    }



    public function actionTest(){
//    $this->layout==false;

        return $this->renderPartial('test');
    }
    public function actionIndex()
    {
        $goodsCategory=GoodsCategory::find();
        $pager = new Pagination();
        $pager->totalCount=$goodsCategory->count();
        $pager->pageSize=5;
        $goodsCategory = $goodsCategory->orderBy('tree ASC,lft ASC')->limit($pager->limit)->offset($pager->offset)->all();
//        $goodsCategory = $goodsCategory->limit($pager->limit)->offset($pager->offset)->all();
        return $this->render('index',['goodsCategory'=>$goodsCategory,'pager'=>$pager]);
    }

    public function actionDelete($id){
//        var_dump($id);exit;
        $model = GoodsCategory::findOne(['id'=>$id]);
     if($model->isLeaf()){
         if($model->parent_id !=0){
             $model->delete();
         }else{
             $model->deleteWithChildren();
         }

     }
        //只能删空节点

        return $this->redirect(['index']);
    }
    public function actionEdit($id){
        $model = GoodsCategory::findOne(['id'=>$id]);

        $parent_id=$model->parent_id;
        $request=\Yii::$app->request;

        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                if($model->parent_id==0){
                    //                $countries = new Menu(['name' => 'Countries']);
//                $countries->makeRoot();
                    //修改为根节点报错旧的id 0
                if($parent_id==0){
                    $model->save();
                }else{
                    $model->makeRoot();
                }
//                    $model->makeRoot();
                    return $this->redirect(['index']);
                }else{
                    //添加子节点
//                $countries = new Menu(['name' => 'Countries']);
//                $countries->makeRoot();
                    $parent=GoodsCategory::findOne(['id'=>$model->parent_id]);
                    $model->prependTo($parent);
                    return $this->redirect(['index']);
                }


            }
        }
        return $this->render('add-category',['model'=>$model]);
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
