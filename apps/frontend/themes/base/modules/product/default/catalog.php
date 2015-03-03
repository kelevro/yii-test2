<?
use yii\helpers\Url;
use backend\components\Html;

/** @var yii\web\View $this */
/** @var product\models\Category[] $categories */
?>

<div style="display: table-cell;">
    <div class="categoryconteiner">
        <?foreach($categories as $category):?>
            <a href="<?=Url::toRoute(['/product/default/category', 'category' => $category->id])?>">
                <div class="category">
                    <p class="categorytext"><?=$category->title?></p>
                    <hr noshade="" size="1px" color="#ddd">
                    <?= Html::img($category->getMainPhotoUrlBySize('small'),
                        ['title' => $category->img_title, 'alt' => $category->img_alt])?>
                </div>
            </a>
        <?endforeach?>
    </div>
</div>