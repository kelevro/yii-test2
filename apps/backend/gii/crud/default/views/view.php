<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View $this
 * @var yii\gii\generators\crud\Generator $generator
 */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use backend\components\Html;

/**
 * @var yii\web\View $this
 * @var <?= ltrim($generator->modelClass, '\\') ?> $model
 */
?>

<div class="<?=Inflector::camel2id(StringHelper::basename($generator->modelClass))?> view col-md-10 col-lg-10 column">
    <div class="row">
        <h4 class="pull-left title">Title</h4>
        <div class="pull-left col-md-offset-1 col-xs-offset-1">
           <?="<?="?>Html::a('Edit', ['update', 'id' => $model->id],
                ['class' => 'btn gray btn-flat', 'icon' => 'fa-pencil-square-o']) ?>
        </div>
    </div>


    <div class="row">
        <form class="form-horizontal col-md-6 column" role="form">
            <?foreach($generator->getTableSchema()->columns as $column):?>
<div class="form-group">
                <label class="col-md-4 control-label"><?=$column->name?></label>
                <div class="col-md-8">
                    <p class="form-control-static">
                        <?="<?="?>$model-><?=$column->name?>?>
                    </p>
                </div>
            </div>
            <?endforeach?>
        </form>
    </div>

</div>

