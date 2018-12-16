<?php

namespace backend\modules\goods\controllers;

use backend\helpers\DateHelper;
use backend\modules\goods\actions\Upload;
use backend\modules\goods\models\form\GoodsDetailsForm;
use backend\modules\goods\models\form\UploadForm;
use backend\modules\goods\models\Store;
use common\behaviors\NoCsrfBehavior;
use Yii;
use backend\modules\goods\models\Goods;
use backend\modules\goods\models\search\GoodsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\web\UploadedFile;

/**
 * GoodsController implements the CRUD actions for Goods model.
 */
class GoodsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'csrf' => [
                'class' => NoCsrfBehavior::className(),
                'controller' => $this,
                'actions' => [
                    'upload'
                ]
            ]
        ];
    }
    /*
         * 说明 : 百度编辑器的配置函数
         *
         * */
    public function actions() {
        return [
            'uploadd' => [
                'class' => Upload::className(),
                'uploadBasePath' => '@webroot', //file system path ps:当前运行应用的 Web 入口目录
                'uploadBaseUrl' => '@web', //web path @web ps:当前运行应用的根 URL
                'csrf' => true, //csrf校验

                'configPatch' => [
                    'imageMaxSize' =>  2 * 1024 * 1024, //图片
                    'scrawlMaxSize' => 500 * 1024, //涂鸦
                    'catcherMaxSize' => 500 * 1024, //远程
                    'videoMaxSize' => 1024 * 1024, //视频
                    'fileMaxSize' => 1024 * 1024, //文件
                    'imageManagerListPath' => '/', //图片列表
                    'fileManagerListPath' => '/', //文件列表
                ],

                // OR Closure
                'pathFormat' => [
                    'imagePathFormat' => 'uploads/images/{yyyy}{mm}{dd}/{time}{rand:6}',
                    'scrawlPathFormat' => 'uploads/images/{yyyy}{mm}{dd}/{time}{rand:6}',
                    'snapscreenPathFormat' => 'uploads/images/{yyyy}{mm}{dd}/{time}{rand:6}',
                    'catcherPathFormat' => 'uploads/images/{yyyy}{mm}{dd}/{time}{rand:6}',
                    'videoPathFormat' => 'uploads/videos/{yyyy}{mm}{dd}/{time}{rand:6}',
                    'filePathFormat' => 'uploads/files/{yyyy}{mm}{dd}/{time}{rand:6}',
                ],
                'configPatch' => [
                    'imageManagerListPath' => 'uploads/images', //图片列表
                    'fileManagerListPath' => 'uploads/images', //文件列表
                ],

                'beforeUpload' => function($action) {
                    //throw new \yii\base\Exception('error message'); //break
                },
                'afterUpload' => function($action) {
                }
            ],
        ];
    }
    /**
     * Lists all Goods models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GoodsSearch();
        //未过期的在上面 到期的在下面
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Goods model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Goods model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Goods();

//        echo $model->load(Yii::$app->request->post());
        $model->scenario = 'create';
//        if(Yii::$app->request->isPost) {
//            echo "<pre>";
//            var_dump(Yii::$app->request->post());
//            echo "</pre>";
//            die;
//        }
        $store_kv = Store::kv('id','name');

        if ($model->load(Yii::$app->request->post())&& $model->save()) {

            return $this->redirect(['view', 'id' => $model->id]);
        }
//        $model = new \backend\modules\goods\models\Goods();
        return $this->render('create', [
            'model' => $model,
            'store_kv' => $store_kv,
        ]);
    }

    public function actionTest(){

        $t = time();
        $d = explode('-', date("Y-y-m-d-H-i-s"));
        $format = "/ueditor/php/upload/image/{yyyy}{mm}{dd}/{time}{rand:6}";
        $format = str_replace("{yyyy}", $d[0], $format);
        $format = str_replace("{yy}", $d[1], $format);
        $format = str_replace("{mm}", $d[2], $format);
        $format = str_replace("{dd}", $d[3], $format);
        $format = str_replace("{hh}", $d[4], $format);
        $format = str_replace("{ii}", $d[5], $format);
        $format = str_replace("{ss}", $d[6], $format);
        $format = str_replace("{time}", $t, $format);

        //过滤文件名的非法自负,并替换文件名
        $oriName = substr('189999.jpg', 0, strrpos('189999.jpg', '.'));
        $oriName = preg_replace("/[\|\?\"\<\>\/\*\\\\]+/", '', $oriName);
        $format = str_replace("{filename}", $oriName, $format);
        $randNum = rand(1, 10000000) . rand(1, 10000000);
        if (preg_match("/\{rand\:([\d]*)\}/i", $format, $matches)) {
            $format = preg_replace("/\{rand\:[\d]*\}/i", substr($randNum, 0, $matches[1]), $format);
        }
        var_dump($format);
    }


    public function actionUpload()
    {

        $params = Yii::$app->request->post();
        Yii::$app->response->format = Response::FORMAT_JSON;
        $model = new UploadForm();
        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');
            if ($model->file && $model->validate()) {
                $path = '/upload/';
//                if (!file_exists($path)) mkdir($path);

                $filename = time() . '.' . $model->file->extension;
                //todo 上传成功后传到七牛 删除本地文件 返回七牛url
                if ($model->file->saveAs($path . $filename)){

                    return ["result" => "Success", "url" => $path . $filename];

                }else
                    return ["result" => "Fail"];
            }
            return ["result" => "ValidFail"];
        }
        return ["result" => "PostFail"];
    }
        /**
     * Updates an existing Goods model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $store_kv = Store::kv('id','name');
        $model->sales_begin_end = DateHelper::timestampToDRP($model->sales_begin,$model->sales_end);
        return $this->render('update', [
            'model' => $model,
            'store_kv' => $store_kv,
        ]);
    }

    /**
     * Deletes an existing Goods model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Goods model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Goods the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Goods::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
