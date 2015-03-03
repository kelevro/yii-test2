<?
/** @var yii\web\View $this */
/** @var news\models\News $new */

?>
<div class="newsconteiner">
    <div class="news-date"><?=date('d.m.Y', strtotime($new->date_created))?></div>
    <h1><?=$new->title?></h1>
    <img src="<?=$new->getMainPhotoUrlBySize('medium')?>" alt="<?=$new->img_alt?>" title="<?=$new->img_title?>"/>

    <?=$new->content?>
    <div class="clear line"></div>
    <div class="navnews">
        <a href="">
            <div class="buttonnews subscribe-button">
                Подписаться на новости
            </div>
        </a>

    </div>
</div>