<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/10
 * Time: 11:21
 */

namespace backend\controllers;
use backend\filters\RbacFilter;
use backend\models\Menu;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Request;

class MenuController extends Controller{
    public function actionAdd(){
        $auth = \Yii::$app->authManager;
        $model = new Menu();
        $request=new Request();
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->save();
                $this->redirect(['index']);
            }
        }
        $datas= Menu::find()->where(['class'=>1])->asArray()->all();
        $items= ArrayHelper::map($datas,'id','name');
         $permissions=$auth->getPermissions();
        $permissions= ArrayHelper::map($permissions,'name','name');
        return $this->render('add',['model'=>$model,'items'=>$items,'permissions'=>$permissions]);

    }
    //????б?
    public function actionIndex(){
        $menu = Menu::find();
        $pager = new Pagination();
        $pager->totalCount=$menu->count();
        $pager->pageSize=10;
        $menu = $menu->limit($pager->limit)->offset($pager->offset)->all();

        return $this->render('index',['menu'=>$menu,'pager'=>$pager]);
    }

    //??????
    public function actionDelete($id){
        $menu = Menu::findOne(['id'=>$id]);
        $menu->delete();
        return $this->redirect(['index']);
    }
    //?????
    public function actionEdit($id){
        $auth = \Yii::$app->authManager;
        $model=Menu::findOne(['id'=>$id]);

        $request=\yii::$app->request;
        if($request->isPost){
            $model->load($request->post());
            if($model->validate()){
                $model->save();
                $this->redirect(['index']);
            }
        }

        $datas= Menu::find()->where(['class'=>1])->asArray()->all();
        $items= ArrayHelper::map($datas,'id','name');
        $permissions=$auth->getPermissions();
        $permissions= ArrayHelper::map($permissions,'name','name');
        return $this->render('add',['model'=>$model,'items'=>$items,'permissions'=>$permissions]);

    }
    public function actionTest(){

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