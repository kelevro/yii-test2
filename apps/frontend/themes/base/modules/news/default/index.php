<?
use yii\helpers\Url;
use common\helpers\Stringy;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */
/** @var news\models\News $item */
$models = $dataProvider->getModels();
?>

<?if($dataProvider->pagination->pageCount > 1):?>
    <div class="news-nav-conteiner">
        <?=\yii\widgets\LinkPager::widget([
            'pagination'        => $dataProvider->pagination,
            'nextPageLabel'     => '',
            'prevPageLabel'     => '',
            'options'           => [],
            'prevPageCssClass'  => 'prev1',
            'nextPageCssClass'  => 'next1',
        ])?>
    </div>
<?endif?>

<?foreach($models as $item):?>
    <div class="newsconteiner">
        <div class="news-date"><?=date('d.m.Y', strtotime($item->date_created))?></div>
        <a href="<?=Url::toRoute(['/news/default/view', 'new' => $item->id])?>">
            <img src="<?=$item->getMainPhotoUrlBySize('small')?>"
                 alt="<?=$item->img_alt?>"
                 title="<?=$item->img_title?>"/>
        </a>
        <a href="<?=Url::toRoute(['/news/default/view', 'new' => $item->id])?>">
            <h2><?=$item->title?></h2>
        </a>
        <p><?=Html::encode(Stringy::create(strip_tags($item->content))->truncate(350, '...'))?></p>
        <hr noshade color="#ddd" size="1px" />
        <div class="navnews">
            <a href="">
                <div class="buttonnews subscribe-button">
                    Подписаться на новости
                </div>
            </a>
            <a href="<?=Url::toRoute(['/news/default/view', 'new' => $item->id])?>">
                <div class="buttonnews">
                    Читать полностью
                </div>
            </a>
        </div>
    </div>
<?endforeach?>

<?if($dataProvider->pagination->pageCount > 1):?>
    <div class="news-nav-conteiner">
        <?=\yii\widgets\LinkPager::widget([
            'pagination'        => $dataProvider->pagination,
            'nextPageLabel'     => '',
            'prevPageLabel'     => '',
            'options'           => [],
            'prevPageCssClass'  => 'prev1',
            'nextPageCssClass'  => 'next1',
        ])?>
    </div>
<?endif?>