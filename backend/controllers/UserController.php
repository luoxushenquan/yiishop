<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/8
 * Time: 10:38
 */

namespace backend\controllers;
use backend\models\User;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Request;

class UserController extends Controller{
    public function actionAdd(){
        $model = new User();
        $request = new Request();
        if($request->isPost){

            $model->load($request->post());
            if($model->validate()){
//                echo 'eee',exit;
                $model->created_at=time();

                $model->password_hash=\yii::$app->security->generatePasswordHash($model->password_hash);
                $model->save(0);
                \Yii::$app->session->setFlash('success', '添加成功');
                return $this->redirect(['index']);
            }
        }

        return $this->render('add',['model'=>$model]);
    }
    public function actionIndex(){

        $user=User::find();
        $pager = new Pagination();
        $pager->totalCount=$user->count();
        $pager->pageSize=5;
        $user = $user->limit($pager->limit)->offset($pager->offset)->all();

        return $this->render('index',['user'=>$user,'pager'=>$pager]);
    }
    //删除用户
    public function actionDelete($id){
        $user = User::findOne(['id'=>$id]);
        $user->delete();
//        $user->status=0;
//        $user->save();
        $this->redirect(['index']);

    }
    public function actionJin($id){
        $user = User::findOne(['id'=>$id]);
        $user->status=0;
        $user->save();
        $this->redirect(['index']);

    }
    public function actionEdit($id){
        $model = User::findOne(['id'=>$id]);
        $request=\yii::$app->request;
        if($request->isPost){

            $model->load($request->post());
            if($model->validate()){
//                echo 'eee',exit;
                $model->created_at=time();

                $model->password_hash=\yii::$app->security->generatePasswordHash($model->password_hash);
                $model->save(0);
                \Yii::$app->session->setFlash('success', '添加成功');
                return $this->redirect(['index']);
            }
        }

        return $this->render('add',['model'=>$model]);
    }

}