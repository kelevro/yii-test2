<?
use yii\helpers\Html;
use product\search\GeneralSearch;
/** @var yii\web\View $this */
/** @var GeneralSearch $gs*/
?>
<div class="search">
    <?$form = \yii\widgets\ActiveForm::begin(['action' => ['/product/default/general-search']])?>
    <?=Html::activeTextInput($gs, 's')?>
    <?=Html::submitButton('',['class' => 'serch'])?>
    <?$form->end()?>
</div>