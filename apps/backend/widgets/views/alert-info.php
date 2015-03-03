<?
/**
 * @var int $count
 * @var Alert[] $last
 */
use backend\components\Html;
use backend\models\Alert;

?>
<li class="notification-dropdown hidden-xs hidden-sm">
    <a href="#" class="trigger">
        <i class="fa fa-exclamation-triangle"></i>
        <?if($count):?><span class="count"><?=$count?></span><?endif?>
    </a>
    <div class="pop-dialog">
        <div class="pointer right">
            <div class="arrow"></div>
            <div class="arrow_border"></div>
        </div>
        <div class="body">
            <a href="#" class="close-icon"><i class="fa fa-times"></i></a>
            <div class="notifications">
                <h3>You have <?=$count?> new notifications</h3>

                <?foreach($last as $item):?>
                <span class="item <?=$item->type?>">
                    <?if($item->type == Alert::TYPE_WARNING):?>
                        <i class="fa fa-exclamation-triangle"></i>
                    <?else:?>
                        <i class="fa fa-info-circle"></i>
                    <?endif?>
                    <?=$item->getMessagePreview()?>
                    <span class="time"><i class="icon-time"></i> <?=\Y::format()->asTime($item->date_created)?></span>
                </span>
                <?endforeach?>
                <div class="footer">
                    <a href="<?=\yii\helpers\Url::to(['/alert/index'])?>" class="logout">View all notifications</a>
                </div>
            </div>
        </div>
    </div>
</li>