<div class="content">
    <div class="container-fluid">
        <div id="pad-wrapper" class="users-list">
            <div class="row-fluid header">
                <h3>商品列表</h3>
                <div class="span10 pull-right">
                    <a href="<?=\yii\helpers\Url::to(['product/add'])?>" class="btn-flat success pull-right">
                        <span>&#43;</span>添加新商品</a></div>
            </div>
            <!-- Users table -->
            <div class="row-fluid table">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="span2">
                            <span class="line"></span>商品名称
                        </th>
                        <th class="span2">
                            <span class="line"></span>商品库存
                        </th>
                        <th class="span2">
                            <span class="line"></span>商品单价
                        </th>
                        <th class="span2">
                            <span class="line"></span>是否热卖
                        </th>
                        <th class="span2">
                            <span class="line"></span>是否促销
                        </th>
                        <th class="span2">
                            <span class="line"></span>促销价
                        </th>
                        <th class="span2">
                            <span class="line"></span>是否上架
                        </th>
                        <th class="span2">
                            <span class="line"></span>是否推荐
                        </th>
                        <th class="span2">
                            <span class="line"></span>操作
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- row -->
                    <?php foreach ($products as $product) { ?>
                        <tr>
                            <td>
                                <img src="Http://<?=$product->cover?>" class="img-circle avatar hidden-phone"/>
                                <a href="<?php echo \yii\helpers\Url::to([
                                    'product/detail',
                                    'productId' => $product->productId,
                                ]); ?>">
                                    <?=$product->title?>
                                </a>
                            </td>
                            <td><?=$product->num?></td>
                            <td><?=$product->price?></td>
                            <td><?=$product->isHot ? "热卖" : "不热卖"?></td>
                            <td><?=$product->isSale ? "促销中" : "不促销"?></td>
                            <td><?=$product->salePrice?></td>
                            <td><?=$product->isOn ? "上架" : "下架"?></td>
                            <td><?=$product->isTui ? "推荐" : "不推荐"?></td>
                            <td class="align-right">
                                <a href="<?php echo \yii\helpers\Url::to([
                                    'product/mod',
                                    'productId' => $product->productId,
                                ]); ?>">
                                    编辑
                                </a>
                                <a href="<?php echo \yii\helpers\Url::to([
                                    'product/on',
                                    'productId' => $product->productId,
                                ]); ?>">
                                    上架
                                </a>
                                <a href="<?php echo \yii\helpers\Url::to([
                                    'product/off',
                                    'productId' => $product->productId,
                                ]); ?>">
                                    下架
                                </a>
                                <a href="<?php echo \yii\helpers\Url::to([
                                    'product/del',
                                    'productId' => $product->productId,
                                ]); ?>">
                                    删除
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <?php
                if (Yii::$app->session->hasFlash('info')) {
                    echo Yii::$app->session->getFlash('info');
                }
                ?>
            </div>
            <div class="pagination pull-right">
                <?php echo yii\widgets\LinkPager::widget([
                    'pagination' => $pager,
                    'prevPageLabel' => '&#8249;',
                    'nextPageLabel' => '&#8250',
                ]) ?>
            </div>
        </div>
    </div>
</div>
