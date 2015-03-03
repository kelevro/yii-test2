<?
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var product\models\forms\ProductUpdate $model */
/** @var array $attrs */
?>

<?foreach($attrs as $id => $attr):?>
    <div class="field-box field-productupdate-description">
        <?=Html::label($attr['title'], Html::getInputId($model, "attrs[{$id}]"),
            ['class' => 'control-label'])?>
        <div class="col-md-5">
            <?if($attr['is_selectable']):?>
                <?=Html::dropDownList(Html::getInputName($model, "attrs[{$id}]"), $attr['value'], $attr['values'],[
                    'prompt' => 'select value',
                    'id'   => Html::getInputId($model, "attrs[{$id}]"),
                    'class' => 'form-control',
                ])?>
            <?else:?>
                <?=Html::textInput(Html::getInputName($model, "attrs[{$id}]"), $attr['value'], [
                    'id'   => Html::getInputId($model, "attrs[{$id}]"),
                    'class' => 'form-control',
                ])?>
            <?endif?>
        </div>
        <?if(!$attr['is_selectable']):?>
            <div class="col-md-4">
                <?if($filters = $model->getAttributeFilter($id)):?>
                    <?=Html::dropDownList(Html::getInputName($model, "filters[{$id}]"), $filters['currentValue'],
                        $filters['filters'],['prompt' => 'select value', 'id' => Html::getInputId($model, "filters[{$id}]"),'class' => 'form-control',])?>
                <?endif?>
            </div>
        <?endif?>
    </div>
<?endforeach?>