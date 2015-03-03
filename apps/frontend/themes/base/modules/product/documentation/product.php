<?

/** @var yii\web\View $this */
/** @var product\models\Product $product */

?>

<ul class="docs-product">
    <?foreach($product->findRelatedDocumentations() as $doc):?>
        <li><a href="<?=\common\helpers\Storage::getStorageUrlTo('documentation') . '/' . $doc->link?>"
               target="_blank">
                <?=($doc->title)?$doc->title:$doc->link?>
               </a>
        </li>
    <?endforeach?>
</ul>