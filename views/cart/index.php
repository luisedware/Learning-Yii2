<?php
use yii\bootstrap\ActiveForm;
?>
<!-- ============================================================= HEADER : END ============================================================= -->
<section id="cart-page">
    <?php $form = ActiveForm::begin([
        'action' => \yii\helpers\Url::to(['order/add']),
    ])?>
    <div class="container">
        <?php
            if (Yii::$app->session->has('info')) {
                echo Yii::$app->session['info'];
            }
        ?>
        <div class="col-xs-12 col-md-9 items-holder no-margin">
            <?php foreach ($carts as $key => $cart) : ?>
                <input type="hidden" name="OrderDetail[<?=$key?>][productId]" value="<?=$cart->productId?>">
                <input type="hidden" name="OrderDetail[<?=$key?>][price]" value="<?=$cart->price?>">
                <input type="hidden" name="OrderDetail[<?=$key?>][productNum]" value="<?=$cart->productNum?>">
                <div class="row no-margin cart-item">
                    <div class="col-xs-12 col-sm-2 no-margin">
                        <a href="<?php echo \yii\helpers\Url::to(['product/index']); ?>" class="thumb-holder">
                            <img class="lazy" alt="" src="http://<?=$cart->product->cover?>"/>
                        </a>
                    </div>

                    <div class="col-xs-12 col-sm-5 ">
                        <div class="title">
                            <a href="#"><?=$cart->product->title?></a>
                        </div>
                        <div class="brand"><?=$cart->product->title?></div>
                    </div>

                    <div class="col-xs-12 col-sm-3 no-margin">
                        <div class="quantity">
                            <div class="le-quantity">
                                <form>
                                    <a class="minus" href="#reduce"></a>
                                    <input name="quantity" readonly="readonly" type="text" value="<?=$cart->productNum?>"/>
                                    <a class="plus" href="#add"></a>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-2 no-margin">
                        <div class="price">
                            <?php echo floatval($cart->productNum * $cart->price); ?>
                        </div>
                        <a class="close-btn" href="#"></a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- ========================================= CONTENT : END ========================================= -->

        <!-- ========================================= SIDEBAR ========================================= -->

        <div class="col-xs-12 col-md-3 no-margin sidebar ">
            <div class="widget cart-summary">
                <h1 class="border">商品购物车</h1>
                <div class="body">
                    <ul class="tabled-data no-border inverse-bold">
                        <li>
                            <label>购物车总价</label>
                            <div class="value pull-right"></div>
                        </li>
                        <li>
                            <label>运费</label>
                            <div class="value pull-right">0</div>
                        </li>
                    </ul>
                    <ul id="total-price" class="tabled-data inverse-bold no-border">
                        <li>
                            <label>订单总价</label>
                            <div class="value pull-right"></div>
                        </li>
                    </ul>
                    <div class="buttons-holder">
                        <button type="submit" class="le-button big">去结算</button>
                        <a class="simple-link block" href="<?php echo \yii\helpers\Url::to(['product/index']); ?>">继续购物</a>
                    </div>
                </div>
            </div><!-- /.widget -->

            <div id="cupon-widget" class="widget">
                <h1 class="border">使用优惠券</h1>
                <div class="body">
                    <form>
                        <div class="inline-input">
                            <input data-placeholder="请输入优惠券码" type="text"/>
                            <button class="le-button" type="submit">使用</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.widget -->
        </div><!-- /.sidebar -->

        <!-- ========================================= SIDEBAR : END ========================================= -->
    </div>
    <?php ActiveForm::end() ?>
</section>        <!-- ============================================================= FOOTER ============================================================= -->

