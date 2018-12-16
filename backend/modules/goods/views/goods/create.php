<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\goods\models\Goods */

$this->title = 'Create Goods';
$this->params['breadcrumbs'][] = ['label' => 'Goods', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="goods-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'store_kv' => $store_kv,
    ]) ?>

</div>
