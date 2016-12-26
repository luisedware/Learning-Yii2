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
                            <td class="align-right">
                                <a href="">编辑</a>
                                <a href="">上架</a>
                                <a href="">下架</a>
                                <a href="">删除</a>
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
