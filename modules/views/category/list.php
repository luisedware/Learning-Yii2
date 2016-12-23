<div class="content">
    <div class="container-fluid">
        <div id="pad-wrapper" class="users-list">
            <div class="row-fluid header">
                <h3>分类列表</h3>
                <div class="span10 pull-right">
                    <a href="<?=\yii\helpers\Url::to(['category/add'])?>" class="btn-flat success pull-right">
                        <span>&#43;</span>添加新分类</a></div>
            </div>
            <!-- Users table -->
            <div class="row-fluid table">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="span2">
                            <span class="line"></span>分类 ID
                        </th>
                        <th class="span2">
                            <span class="line"></span>分类名称
                        </th>
                        <th class="span2">
                            <span class="line"></span>操作
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- row -->
                    <?php foreach ($categories as $cate) { ?>
                        <tr>
                            <td><?php echo $cate['cateId']; ?></td>
                            <td><?php echo $cate['title']; ?></td>
                            <td class="align-left">
                                <a href="<?php echo yii\helpers\Url::to([
                                    'category/update',
                                    'cateId' => $cate['cateId'],
                                ]) ?>">修改</a>
                                <a href="<?php echo yii\helpers\Url::to([
                                    'category/delete',
                                    'cateId' => $cate['cateId'],
                                ]) ?>">删除</a>
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
