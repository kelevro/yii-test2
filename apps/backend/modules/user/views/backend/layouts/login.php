<?
/** @var $this \yii\web\View */
use yii\helpers\Html;
backend\assets\AppAsset::register($this);

$bgs = glob(Yii::getAlias('@backend/assets/img/bgs/*.jpg'));
$bg = $this->getAssetManager()->getPublishedUrl(Yii::getAlias('@backend/assets/')).'/img/bgs/'.basename($bgs[rand(0, count($bgs) - 1)]);
?>
<?$this->beginPage()?>
<!DOCTYPE html>
<html class="login-bg">
<head>
    <title><?=Html::encode($this->title)?></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <?$this->head()?>

    <!-- open sans font -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,700italic,800italic,400,300,600,700,800' rel='stylesheet' type='text/css'>

    <style type="text/css">
        html { background: url('<?=$bg?>') no-repeat center center fixed; }
    </style>
</head>
<body>
<?$this->beginBody()?>

<?=$content?>

<?$this->endBody()?>
</body>
</html>
<?$this->endPage()?>