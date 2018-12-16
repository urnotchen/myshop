<?php
use yii\helpers\Html;


/* @var $this \yii\web\View */
/* @var $userIdentity \common\models\BaseUser */

?>

<header class="main-header">

    <?= Html::a(Yii::$app->name, Yii::$app->homeUrl, ['class' => 'logo']) ?>

    <nav class="navbar navbar-static-top" role="navigation">

        <div class="navbar-custom-menu-left" style="float: left;">

            <?php

            $items[] = [
                'text' => '<span class="sr-only">Toggle navigation</span>',
                'url' => '#',
                'options' => [
                    'class' => 'sidebar-toggle',
                    'data-toggle' => 'offcanvas',
                    'role' => 'button',
                ],
            ];

            $items[] = [
                'text' => '商品管理',
                'url' => ['/goods/goods/index'],
                'activeModule' => 'goods',
            ];
            $items[] = [
                'text' => '订单',
                'url' => ['/order/order/index'],
                'activeModule' => 'order',
            ];

            $items[] = [
                'text' => '设置',
                'url' => ['/setting/misc/policy'],
                'activeModule' => 'setting',
            ];

            echo \backend\widgets\TopMenu::widget(['items' => $items]);

            ?>

        </div>

        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <?php
                            if(!Yii::$app->getUser()->isGuest){
//                                echo Html::img($userIdentity->avatar, ['class' => 'user-image', 'alt' => '用户头像']);
                                echo '<span class="hidden-xs">'.Yii::$app->user->identity->username."</span>";
                            }
                        ?>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <?php if(!Yii::$app->getUser()->isGuest): ?>
                            <p>
                                <?= Yii::$app->user->identity->username; ?> - Web Developer
                                <small>Member since <?= date('Y.m.d', Yii::$app->user->identity->created_at); ?></small>
                            </p>
                            <?php endif ?>
                        </li>
                        <!-- Menu Body -->
                        <li class="user-body">
                            <div class="col-xs-12 text-center">
                            </div>
                        </li>
                        <!-- Menu Footer-->
                        <li class="user-footer">

                            <div class="pull-right">
                                <?= Html::a(
                                    'Sign out',
                                    ['/site/logout'],
                                    ['data-method' => 'post', 'class' => 'btn btn-default btn-flat']
                                ) ?>
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>
