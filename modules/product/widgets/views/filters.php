<?
use yii\widgets\ActiveForm;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var \product\models\Attribute[] $attrs */
/** @var \product\search\UserSearch $us */
/** @var \product\models\Category $category */

?>
<?$form = ActiveForm::begin([
    'id'        => 'search-form',
    'action'    => ['/product/default/search', 'category' => $category->id],
])?>
<?foreach($attrs as $attr):?>
    <?if(!$attr->filterValues) { continue; } ?>
    <div class="filter">
        <h4><?=$attr->title?></h4>
        <?foreach($attr->filterValues as $idx => $filterValue):?>
            <div style="clear: both;">
                <input type="checkbox"
                       id="<?=Html::getInputId($us, "filters[{$attr->id}][{$idx}]")?>"
                       name="UserSearch[filters][<?=$attr->id?>][]"
                       value="<?=$idx?>"
                    <?=(!empty($us->filters[$attr->id]) && in_array($idx, $us->filters[$attr->id]))? 'checked' : '' ?>
                    />

                <label class="filter-value"
                       for="<?=Html::getInputId($us, "filters[{$attr->id}][{$idx}]")?>">
                    <?=$filterValue?>
                </label>
            </div>
        <?endforeach?>
        <div class="clear"></div>
    </div>
<?endforeach?>
<?$form->end()?>