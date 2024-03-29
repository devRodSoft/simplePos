<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\User;
use app\models\Sucursales;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php $this->registerCsrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    
    NavBar::begin([
        'brandLabel' => "Seduction Sexshop",
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar navbar-fixed-top',
            'style' => 'background-color: #E10C78;'
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => 'Productos',  'url' => ['/productos/index'],         'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->userType == User::SUPER_ADMIN],
            //['label' => 'Sucupro',    'url' => ['/sucursal-producto/index'], 'visible' => !Yii::$app->user->isGuest],
            //['label' => 'Reportes',   'url' => ['/detalle-venta/index'],     'visible' => !Yii::$app->user->isGuest],
            ['label' => 'Ventas',     'url' => ['/ventas/index'],            'visible' => !Yii::$app->user->isGuest ],
            //['label' => 'Abonos',     'url' => ['/abonos/index'],            'visible' => !Yii::$app->user->isGuest ],
            //['label' => 'Sucursales', 'url' => ['/sucursales/index'],        'visible' => !Yii::$app->user->isGuest  && Yii::$app->user->identity->userType == User::SUPER_ADMIN],
            ['label' => 'Cajas',      'url' => ['/cajas/index'],             'visible' => !Yii::$app->user->isGuest],
            ['label' => 'Clientes',   'url' => ['/clientes/index'],          'visible' => !Yii::$app->user->isGuest],
            ['label' => 'Retiros',    'url' => ['/salidas/index'],           'visible' => !Yii::$app->user->isGuest],
            ['label' => 'Usuarios',   'url' => ['/user/index'],              'visible' => !Yii::$app->user->isGuest && Yii::$app->user->identity->userType == User::SUPER_ADMIN],
            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ' - ' . Sucursales::find()->select('nombre')->where(['=', 'id', Yii::$app->user->identity->sucursalId])->one()->nombre .   ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Rodsoft <?= date('Y') ?></p>

        <p class="pull-right">smartPOS</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
