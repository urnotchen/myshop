<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\goods\models\search\GoodsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '商品列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Goods', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'name',
            'distributor_prize',
            'sales_begin' => [
                'label'=>'售卖时间',
                'attribute' => 'sales_begin',
                'format'=>'raw',
                'value' => function(\backend\modules\goods\models\Goods $model){
                    return \backend\helpers\DateHelper::timestampToDRP($model->sales_begin,$model->sales_end);
                },
//                'options' =>  ],
            ],
            'sales_begin' => [
                'label'=>'售卖时间',
                'attribute' => 'sales_begin',
                'format'=>'raw',
                'value' => function(\backend\modules\goods\models\Goods $model){
                    return \backend\helpers\DateHelper::timestampToDRP($model->sales_begin,$model->sales_end);
                },
//                'options' =>  ],
            ],
            'store_id' => [
                'label' => '商家',
                'attribute' => 'store_id',
                'format'=>'raw',
                'value' => function(\backend\modules\goods\models\Goods $model){
                    return $model->store->name;
                },
//                'options' =>  ],
            ],
            'stock_num',
            'sales_num',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
