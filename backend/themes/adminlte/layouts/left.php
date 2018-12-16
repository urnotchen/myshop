<aside class="main-sidebar">
    <div class="sidebar-block"></div>
    <section class="sidebar">

        <?= \backend\widgets\Nav::widget([
            'encodeLabels' => false,
            'options' => ['class' => 'sidebar-menu'],
            'items' => \Yii::$app->sidebarItems->getItems()
        ]); ?>

    </section>

</aside>