<?php

namespace frontend\modules\v1\controllers;

use frontend\components\rest\Controller;
use frontend\modules\v1\components\QueryParamAuth;
use frontend\modules\v1\models\FUser;
use Yii;
use frontend\modules\v1\models\Goods;
use frontend\modules\v1\models\search\Goods as GoodsSearch;

use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GoodsController implements the CRUD actions for Goods model.
 */
class GoodsController extends Controller
{

    public function behaviors()
    {
        $inherit = parent::behaviors();

//        $behaviors['authenticator'] = [
//            'class' => QueryParamAuth::className(),
//            'tokenParam' => 'token'  //例如改为‘token’
//        ];
        $inherit['authenticator']['only'] = [
//            'index',
                'view',
        ];
        $inherit['authenticator']['authMethods'] = [
//            \frontend\modules\v1\components\AccessTokenAuth::className(),
            QueryParamAuth::className(),
        ];

        return $inherit;
    }
    /**
     * Lists all Goods models.
     * @return mixed
     */
    public function actionIndex()
    {
        //判断有没有token 有的话带上个人信息
        $params = Yii::$app->request->get();
        //查找token
        if(empty($params['token'])){
            //跳转去验证
            return $this->redirect(['../../wx/premit-wx','redirect_uri' => APP_DOMAIN_SCHEMA.APP_FRONTEND_DOMAIN.APP_BASE_DOMAIN.'/wx/get-code']);
        }
        //判断是不是分销商,
        $user = Yii::$app->getUser();
        $res = FUser::isDistributor($user->id);

        //把所有的商品url带上token个人信息也就是openid
        $searchModel = new GoodsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return [
            'list' => $dataProvider,
            'is_distributor' => $res?FUser::DISTRIBUTOR_YES:FUser::DISTRIBUTOR_NO,
        ];
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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
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

        return $this->render('update', [
            'model' => $model,
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

    public function actionDetails($id){

        return Goods::getGoodsDetails($id);
    }

    /*
     * 获取商品售卖的实时信息
     * */
    public function getRealTimeInfo($id){

        $model = Goods::findOneOrException(['goods_id' => $id]);
        return [
            'name' => $model->name,
            'distributor_prize' => $model->distributor_prize,
            'sales_initial' => $model->sales_initial,
            'sales_actual' => $model->sales_actual,
            'goods_status',
            'sale_status',
            'sales_begin',
            'sales_end',
            'stock_num',
            'sales_num',
            'image_url',
            'max_num',
            'sales_begin',
            'sales_end',
        ];
    }
}
