<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View $this
 * @var yii\gii\generators\crud\Generator $generator
 */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use backend\components\Html;
use <?="yii\\grid\\GridView"?>;
/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var <?= ltrim($generator->searchModelClass, '\\') ?> $searchModel
 */
?>

<div class="table-wrapper <?=Inflector::camel2id(StringHelper::basename($generator->modelClass))?> list">
    <div class="row filter-block">
        <h4 class="pull-left"><?=Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))?></h4>
        <div class="pull-left col-md-offset-1">
            <?="<?="?>Html::a('Add New', ['update'], ['class' => 'btn btn-success btn-flat', 'icon' => 'fa-plus']) ?>
        </div>
    </div>

    <div class="row">
        <?="<?="?>GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                [
                    'attribute' => 'id',
                    'headerOptions' => ['class' => 'col-md-1'],
                ],
        <?php
        $count = 0;
        foreach ($generator->getTableSchema()->columns as $column) {
            $format = $generator->generateColumnFormat($column);
            if (++$count < 6) {
                echo "\t\t\t'" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
            } else {
                echo "\t\t\t// '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
            }
        }
        ?>
            ],
        ]); ?>
    </div>
</div>