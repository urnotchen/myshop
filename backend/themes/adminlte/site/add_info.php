<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\modules\setting\models\User;
use app\modules\setting\models\forms\AddinfoForm;

?>

<div class="user-form">
    <h2>完善个人信息</h2>
    <?php \bluelive\adminlte\widgets\BoxWidget::begin(); ?>

    <?php $form = ActiveForm::begin(); ?>


    <?= $form->field($model, 'qq')->textInput()->label('QQ') ?>
    <?= $form->field($model, 'telephone')->textInput()->label('手机号') ?>
    <?= $form->field($model, 'alipay')->textInput()->label('支付宝') ?>
    <?= $form->field($model, 'real_name')->textInput()->label('真实姓名(支付宝对应的真实名称,否则会影响打款)') ?>
    <?= $form->field($model, 'avatar')->hiddenInput()->label('头像') ?>

    <div class="thumbnail" style="border:none;padding: 0px ;">
        <a class=" active addimg" style="width:150px;height:150px;border: 1px solid #D2D6DE;display: block">


            <img onclick="getElementById('inputfile').click()" id="img1"  style="width:150px;height:150px;cursor:pointer" alt="点击传图" name=1 src=<?php echo ""?> >
            <!--                    <img onclick="getElementById('inputfile').click()"  >-->
            <input type="file" multiple="multiple" id="inputfile" style="border:1px solid black;height:0;width:0;z-index: -1; position: absolute;left: 10px;top: 5px;"/>
        </a>
    </div>
    <div class="form-group">
        <?= Html::submitButton('提交信息', ['class' => 'btn btn-success']) ?>
    </div>
</div>


    <?php ActiveForm::end(); ?>

    <?php \bluelive\adminlte\widgets\BoxWidget::end(); ?>

</div>
<?php
$this->registerJs(<<<JS

    $("#inputfile").change(function(){
//创建FormData对象
var data = new FormData();
//为FormData对象添加数据
$.each($('#inputfile')[0].files, function(i, file) {
data.append('upload_file'+i, file);
});
console.log($('#inputfile'));//return;
$(".img1").show();    //显示加载图片
//发送数据
$.ajax({
url:'upload-avatar',
type:'POST',
data:data,
cache: false,
contentType: false,        //不可缺参数
processData: false,        //不可缺参数
success:function(data){
$(".active img").attr("src",data);
//var img_url_all = $("img#img1").attr("src") + "," + $("img#img2").attr("src") + "," + $("img#img3").attr("src") + "," + $("img#img4").attr("src") + "," + $("img#img5").attr("src") + "," + $("img#img6").attr("src") + "," + $("img#img7").attr("src") + "," + $("img#img8").attr("src") + "," + $("img#img9").attr("src");
$("#addinfoform-avatar").val(data);
//$("input#weibocontent-images_url, input#task-images_url").val(img_url_all);
//$("#weixincontent-show_cover_pic").val()
// $("#imgurl").val("");
//data = $(data).html();
//第一个feedback数据直接append，其他的用before第1个（ .eq(0).before() ）放至最前面。
//data.replace(/&lt;/g,'<').replace(/&gt;/g,'>') 转换html标签，否则图片无法显示。
//if($("#feedback").children('img').length == 0) $("#feedback").append(data.replace(/&lt;/g,'<').replace(/&gt;/g,'>'));
//else $("#feedback").children('img').eq(0).before(data.replace(/&lt;/g,'<').replace(/&gt;/g,'>'));
//$(".loading").hide();    //加载成功移除加载图片
},
error:function(){
alert('上传出错');
//$(".loading").hide();    //加载失败移除加载图片
}
});
});
JS
);