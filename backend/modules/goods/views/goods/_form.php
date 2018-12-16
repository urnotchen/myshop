<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\daterange\DateRangePicker;

/* @var $this yii\web\View */
/* @var $model backend\modules\goods\models\Goods */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="goods-form">
<!--    --><?php //var_dump($model);exit();?>
    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'image_url')->fileInput([
        'id'=>'upload','name'=>'UploadForm[file]'])?>

    <?= Html::img($model->image_url) ?>


    <input type = 'hidden' name='Goods[image_url]' id="image_url"  value=<?=  $model->image_url?>>

    <?= $form->field($model, 'content')->widget(\xj\ueditor\Ueditor::className(), [
        'style' => 'width:540px;height:600px',
        'renderTag' => true,
        'readyEvent' => 'console.log("ready")',
        'jsOptions' => [
            'serverUrl' => yii\helpers\Url::to(['uploadd']),
            'autoHeightEnabled' => false,
            'autoFloatEnable' => true,
            'elementPathEnabled' => false,
            'toolbars' => [[
                'fullscreen', 'undo', 'redo', '|',
                'bold', 'italic', 'underline', '|', 'removeformat', 'formatmatch', 'blockquote', '|', 'forecolor', 'backcolor', 'insertorderedlist', 'insertunorderedlist', '|',
                'rowspacingtop', 'rowspacingbottom', 'lineheight', '|',
                'customstyle', 'paragraph', 'fontsize', '|',
                'justifyleft', 'justifycenter', 'justifyright', 'justifyjustify', '|',
                'link', 'unlink', '|',
                'simpleupload', 'insertimage', '|', 'insertvideo', 'music', 'attachment', 'drafts'
            ]],
            'wordCount' => false,
            'iframeCssUrl' => '/css/ueditor.css',
            'initialStyle' => 'p{line-height:1.6em;font-family:微软雅黑,Microsoft YaHei;font-size:16px}',
        ],
    ]) ?>

    <?= $form->field($model, 'distributor_prize')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sales_initial')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'sales_actual')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'goods_id')->hiddenInput() ?>

    <?= $form->field($model, 'goods_status')->radioList(\backend\modules\goods\models\Goods::enum('goods_status'))  ?>

    <?= $form->field($model, 'sales_begin_end')->widget(
        DateRangePicker::className(),
        [
            'options' => ['style' => ['height'=>'34px','width'=>'125px'], 'placeholder' => '发布时间筛选'],
        ]
    )->label('售卖时间'); ?>


    <?= $form->field($model, 'stock_num')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'store_id')->dropDownList($store_kv,['prompt' => '请选择']) ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php

    $this->registerJs(<<<JS
      $("a.upload").click(function(){
          $("input#upload").click();
      });  

      $("input#upload").change(function () {  
        $.ajaxFileUpload({  
          url: '/goods/goods/upload',  
          secureuri: false,  

          fileElementId:'upload',  
          dataType: 'json',  
          success: function (data, status) {
              if (data['result'] == 'Success') {  
                  //上传成功  
                  $('#image_url').val(data['url'])
              }  
              else{  
                  alert("上传失败");  
              }  
          },  
          error: function (data, status, e) {  
              alert('error');
              return;  
          }  
        });  
  });  
JS
);
