<?
use product\models\Documentation;
use product\models\DocumentationCategory;

/** @var yii\web\View $this */
/** @var DocumentationCategory[] $docsCat */

$this->registerJs(<<<JS
$(".cat-but").on('click', function(e){
    var container = $(this).closest('.doc_category-conteiner');
    var docBlock  = container.find('.doc_item-conteiner');
    var catBlock  = container.find('.doc_kategory-open-button');

    if (docBlock.hasClass('hide')) {
        docBlock.removeClass('hide');
        catBlock.html("-");
    } else {
        docBlock.addClass('hide');
        catBlock.html("+");
    }

});
JS
);

?>

<div class="newsconteiner" style="text-align: left;">

    <?foreach($docsCat as $dc):?>
        <?$docs = $dc->documentations?>
        <div class="doc_category-conteiner">
            <div class="cat-but">
                <div class="doc_kategory-open-button">+</div>
                <div class="doc_kategory-name">
                    <?=\yii\helpers\Html::encode($dc->title)?> (<?=count($docs)?>)
                </div>
            </div>
            <div class="doc_item-conteiner hide">
                <?if($docs):?>
                    <?foreach($docs as $doc):?>
                        <a href="<?=\common\helpers\Storage::getStorageUrlTo('documentation') . '/' . $doc->link?>"
                           target="_blank" class="doc_item-name">
                            <?=($doc->title)?$doc->title:$doc->link?>
                        </a>
                    <?endforeach?>
                <?endif?>
            </div>
        </div>
    <?endforeach?>
</div>