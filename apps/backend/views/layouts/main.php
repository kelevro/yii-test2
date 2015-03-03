<?
/** @var $this \yii\base\View */
use yii\helpers\Html;

backend\assets\AppAsset::register($this);
?>
<? $this->beginPage() ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= Html::encode($this->title) ?></title>

        <? $this->head() ?>

        <!-- open sans font -->
        <link
            href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800'
            rel='stylesheet' type='text/css'>

        <!-- lato font -->
<!--        <link href='http://fonts.googleapis.com/css?family=Lato:300,400,700,900,300italic,400italic,700italic,900italic'-->
<!--              rel='stylesheet' type='text/css'>-->
    </head>
    <body>
    <? $this->beginBody() ?>
    <!-- navbar -->
    <header class="navbar navbar-inverse" role="banner">
        <div class="navbar-header">
            <button class="navbar-toggle" type="button" data-toggle="collapse" id="menu-toggler">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="/">RK Electronics</a>
        </div>
        <ul class="nav navbar-nav pull-right hidden-xs">
            <li>
                <a href="#" class="hidden-xs hidden-sm">
                    <?= Yii::$app->user->identity->email ?>
                </a>
            </li>
            <li class="settings hidden-xs hidden-sm">
                <a href="<?=\yii\helpers\Url::to(['/user/default/logout']) ?>" role="button">
                    <i class="fa fa-share"></i>
                </a>
            </li>
        </ul>
    </header>
    <!-- end navbar -->

    <?= \backend\widgets\SideBar::widget() ?>

    <!-- main container -->
    <div class="content">

        <? if (!($this->context->id == 'site' && $this->context->action->id == 'index')): ?>
        <div style="margin: 10px">
            <?= \backend\widgets\Flash::widget() ?>
            <?=\yii\widgets\Breadcrumbs::widget([
                'homeLink' => false,
                'links' => $this->context->breadcrumbs,
            ])?>
        </div>
        <?endif?>

        <div id="pad-wrapper"><?= $content ?></div>

    </div>

    <? $this->endBody() ?>
    </body>
    </html>
<? $this->endPage() ?>