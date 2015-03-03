<?
/** @var yii\web\View $this */
/** @var slider\models\Slider[] $sliders  */

?>

<div align="center" style="width: 100%; height:380px;">
    <div id="content">
        <div class="slider">
            <div class="sliderContent">
                <?foreach($sliders as $slider):?>
                    <div class="item">
                        <?if($slider->url):?>
                            <a href="<?=$slider->url?>">
                        <?endif?>
                        <img src="<?=$slider->getUrlBySize('big')?>"
                             alt="<?=$slider->alt?>"
                             title="<?=$slider->title?>"/>
                        <?if($slider->url):?>
                            </a>
                        <?endif?>
                    </div>
                <?endforeach?>
            </div>
        </div>
    </div>
</div>