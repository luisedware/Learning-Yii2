<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>
    <div class="content">
        <div class="container-fluid">
            <div id="pad-wrapper" class="new-user">
                <div class="row-fluid header">
                    <h3>添加商品</h3></div>
                <div class="row-fluid form-wrapper">
                    <!-- left column -->
                    <div class="span9 with-sidebar">
                        <div class="container">
                            <?php
                            if (Yii::$app->session->hasFlash('info')) {
                                echo Yii::$app->session->getFlash('info');
                            }
                            $form = ActiveForm::begin([
                                'options' => [
                                    'class' => 'new_user_form inline-input',
                                    'action' => Yii::$app->urlManager->createUrl(['admin/product/add']),
                                ],
                                'fieldConfig' => [
                                    'template' => '<div class="span12 field-box">{label}{input}{error}</div>',
                                ],
                            ]);
                            ?>
                            <?php echo $form->field($product, 'cateId')->dropDownList($options); ?>
                            <?php echo $form->field($product, 'title')->textInput(['class' => 'span9']); ?>
                            <?php echo $form->field($product, 'descr')->textarea(['class' => 'span9']); ?>
                            <?php echo $form->field($product, 'price')->textInput(['class' => 'span9']); ?>
                            <?php echo $form->field($product, 'isHot')->radioList(['0' => '不热卖', '1' => '热卖'],
                                ['class' => 'span9']); ?>
                            <?php echo $form->field($product, 'isSale')->radioList(['0' => '不促销', '1' => '促销'],
                                ['class' => 'span9']); ?>
                            <?php echo $form->field($product, 'salePrice')->textInput(['class' => 'span9']); ?>
                            <?php echo $form->field($product, 'num')->textInput(['class' => 'span9']); ?>
                            <?php echo $form->field($product, 'isOn')->radioList(['0' => '下架', '1' => '上架'],
                                ['class' => 'span9']); ?>
                            <?php echo $form->field($product, 'isTui')->radioList(['0' => '不推荐', '1' => '推荐'],
                                ['class' => 'span9']); ?>
                            <?php echo $form->field($product, 'cover')->fileInput(['class' => 'span9']); ?>
                            <?php echo $form->field($product, 'pics')->fileInput(['class' => 'span9']); ?>
                            <input type='button' id="addpic" value='增加一个'>
                            <div class="span11 field-box actions">
                                <?php echo Html::submitButton('提交', ['class' => 'btn-glow primary']); ?>
                                <span>OR</span>
                                <?php echo Html::resetButton('取消', ['class' => 'reset']) ?>
                            </div>
                            <?php ActiveForm::end() ?>
                        </div>
                    </div>
                    <!-- side right column -->
                    <div class="span3 form-sidebar pull-right">
                        <div class="alert alert-info hidden-tablet">
                            <i class="icon-lightbulb pull-left"></i>请在左侧表单当中填入要添加的商品信息,包括商品名称,描述,图片等
                        </div>
                        <h6>商城用户说明</h6>
                        <p>可以在前台进行购物</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
$js = <<<JS
$(function(){
    $("#addpic").click(function() {
        var pic = $("#product-pics").clone();
        $("#product-pics").parent().append(pic);
    });
});
JS;

$this->registerJs($js);
?>