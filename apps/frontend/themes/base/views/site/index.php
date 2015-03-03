<?php
use slider\widgets\Slider;
use common\helpers\Stringy;
use yii\helpers\Html;
use yii\helpers\Url;

/** $var yii\web\View $this */
/** @var \news\models\News[] $news */

?>

<?=Slider::widget()?>

<div style="margin-top: -85px">
    <?foreach($news as $new):?>
        <div class="newsconteiner">
            <div class="news-date"><?=date('d.m.Y', strtotime($new->date_created))?></div>
            <a href="<?=Url::toRoute(['/news/default/view', 'new' => $new->id])?>">
                <img src="<?=$new->getMainPhotoUrlBySize('medium')?>"
                     alt="<?=$new->img_alt?>"
                     title="<?=$new->img_title?>"/>
            </a>
            <a href="<?=Url::toRoute(['/news/default/view', 'new' => $new->id])?>">
                <h1><?=Html::encode($new->title)?></h1>
            </a>

            <p><?=Html::encode(Stringy::create(strip_tags($new->content))->truncate(350, '...'))?></p>
            <hr noshade color="#ddd" size="1px" style="margin: 15px 0"/>
            <div class="navnews">
                <a href="">
                    <div class="buttonnews subscribe-button">
                        Подписаться на новости
                    </div>
                </a>
                <a href="<?=Url::toRoute(['/news/default/view', 'new' => $new->id])?>">
                    <div class="buttonnews">
                        Читать полностью
                    </div>
                </a>
            </div>
        </div>
    <?endforeach?>
</div>
