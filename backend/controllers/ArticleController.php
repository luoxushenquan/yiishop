<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/3
 * Time: 18:33
 */
namespace backend\controllers;
use backend\filters\RbacFilter;
use backend\models\Article;
use backend\models\ArticleCategory;
use backend\models\ArticleDetail;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Request;

class ArticleController extends Controller{
    public function actionAdd(){


        $model = new Article();
        $model1 = new ArticleDetail();
        $request = new Request();
        if($request->isPost) {
            $model->load($request->post());
            if ($model->validate()&&$model->validate()) {
                $model->save(0);//$model->validate()

                $onlyOne = $model->attributes['id'];
                $model1->load($request->post());

                    $model1->article_id = $onlyOne;
                    $model1->save(0);//$model->validate()
                    \Yii::$app->session->setFlash('success', '添加成功');
                    return $this->redirect(['article/index']);

            }
        }

//查询分类id

        $datas= ArticleCategory::find()->asArray()->all();
        $items=[];
        foreach($datas as $data){
            $items[$data['id']]=$data['name'];
        }
        return $this->render('add',['model'=>$model,'model1'=>$model1,'items'=>$items]);
    }

    public function actionIndex(){
        $article=Article::find();
        $pager = new Pagination();
        $pager->totalCount=$article->count();
        $pager->pageSize=5;
        $article = $article->where(['status'=>1])->limit($pager->limit)->offset($pager->offset)->all();
        //文章分类
        return $this->render('index',['article'=>$article,'pager'=>$pager]);
    }

    public function actionDelete($id){
        $category = Article::findOne(['id'=>$id]);
//        var_dump($category);exit;
        $category->status=-1;
        $category->save();
        return $this->redirect(['article/index']);
    }

    public function actionEdit($id){
        $model=Article::findOne(['id'=>$id]);
        $model1=ArticleDetail::findOne(['id'=>$id]);
        $request=\yii::$app->request;
        if($request->isPost) {
            $model->load($request->post());
            $model1->load($request->post());
            if ($model->validate()&&$model->validate()) {
                $model->save(0);//$model->validate()
                $onlyOne = $model->attributes['id'];
                $model1->article_id = $onlyOne;
                $model1->save(0);//$model->validate()
                \Yii::$app->session->setFlash('success', '添加成功');
                return $this->redirect(['article/index']);

            }
        }
    }

    //详情
//    public function actionDetail($id){
//
//        $detail = ArticleDetail::findOne(['id'=>$id]);
//        return $this->render('detail',['detail'=>$detail]);
//    }
    public function behaviors()
    {
        return [
            'rbac'=>[
                'class'=>RbacFilter::className(),
                'except'=>['login']
            ]
        ];
    }
}