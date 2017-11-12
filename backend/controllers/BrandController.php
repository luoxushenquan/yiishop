<?php
/**
 * Created by PhpStorm.
 * User: pc
 * Date: 2017/11/3
 * Time: 14:23
 */
namespace backend\controllers;
use backend\filters\RbacFilter;
use backend\models\Brand;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\Request;
use yii\web\UploadedFile;
use Qiniu\Auth;

// 引入上传类
use Qiniu\Storage\UploadManager;
class BrandController extends  Controller{

    public $enableCsrfValidation=false;
    public function actionAdd(){
        $model = new Brand();
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
//        $brand->delete();
        return $this->redirect(['index']);
    }
    public function actionEdit($id){
        $model = Brand::findOne(['id'=>$id]);
        $request = \yii::$app->request;
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
    //处理文件上传的
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
    //测试=========================================================================================
    public function actionTest(){
        // 引入鉴权类


// 需要填写你的 Access Key 和 Secret Key
        $accessKey ="41InI-3JIW8QeoyP8dGu6XYv9QUNYq9ehDk7DT4m";
        $secretKey = "xEMR1dU2oyTkt6vouPLuZwOBtdaFm_cGJVHWDWvN";
     //对象空间的名称
        $bucket = "yiishop";

// 构建鉴权对象
$auth = new Auth($accessKey, $secretKey);

// 生成上传 Token
$token = $auth->uploadToken($bucket);

// 要上传文件的本地路径
$filePath =\yii::getAlias('@webroot').'\upload\59fd391c52133.jpg' ;

// 上传到七牛后保存的文件名
$key = '\upload\59fd391c52133.jpg';

// 初始化 UploadManager 对象并进行文件的上传。
$uploadMgr = new UploadManager();

// 调用 UploadManager 的 putFile 方法进行文件的上传。
        //报错了
list($ret, $err) = $uploadMgr->putFile($token, $key, $filePath);
//echo "\n====> putFile result: \n";
if ($err !== null) {
    //上传失败打印错误
    var_dump($err);
} else {
    //没有出错打印上传救过
    var_dump($ret);
}

    }
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