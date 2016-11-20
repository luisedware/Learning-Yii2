<div class="content">
    <div class="container-fluid">
        <div id="pad-wrapper" class="users-list">
            <div class="row-fluid header">
                <h3>用户列表</h3>
                <div class="span10 pull-right">
                    <a href="<?=\yii\helpers\Url::to(['user/reg'])?>" class="btn-flat success pull-right">
                        <span>&#43;</span>添加新用户</a></div>
            </div>
            <!-- Users table -->
            <div class="row-fluid table">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th class="span2">用户ID</th>
                        <th class="span2">
                            <span class="line"></span>用户账号
                        </th>
                        <th class="span2">
                            <span class="line"></span>用户邮箱
                        </th>
                        <th class="span2">
                            <span class="line"></span>添加时间
                        </th>
                        <th class="span2">
                            <span class="line"></span>操作
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- row -->
                    <?php foreach ($users as $user) { ?>
                        <tr>
                            <td><?php echo $user->userId ?></td>
                            <td><?php echo $user->userName ?></td>
                            <td><?php echo $user->userEmail ?></td>
                            <td><?php echo date('Y-m-d H:i:s', $user->createdAt) ?></td>
                            <td class="align-right">
                                <a href="<?php echo yii\helpers\Url::to([
                                    'user/delete',
                                    'userId' => $user->userId,
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
