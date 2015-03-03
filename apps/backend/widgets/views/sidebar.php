<!-- sidebar -->
<div id="sidebar-nav">
    <ul id="dashboard-menu">
        <?
        use yii\helpers\Html;
        foreach ($items as $item):
        $active = false;
        if (isset($item['active']) && $item['active'] instanceof Closure) {
            $active = $item['active']();
        }
        if (is_callable($item['url'])) {
            $url = $item['url']();
        } else {
            $url = \yii\helpers\Url::to($item['url']);
        }
        ?>
            <?if($active):?>
            <li class="active">
                <div class="pointer">
                    <div class="arrow"></div>
                    <div class="arrow_border"></div>
                </div>
            <?else:?>
                <li>
            <?endif?>
                <a class="<?if(!empty($item['subitems'])):?>dropdown-toggle<?endif?>"
                   <?if(!empty($sItem['new_tab'])):?> target="_blank"<?endif?>
                   href="<?=$url?>">
                    <i class="fa <?= $item['icon'] ?>"></i>
                    <span><?= $item['title'] ?></span>
                    <? if (!empty($item['subitems'])): ?><i class="fa fa-chevron-down"></i> <?endif?>
                </a>
                <? if (!empty($item['subitems'])): ?>
                    <ul class="submenu <?if($active):?>active<?endif?>">
                        <? foreach ($item['subitems'] as $sItem):
                            if (is_callable($sItem['url'])) {
                                $url = $sItem['url']();
                            } else {
                                $url = \yii\helpers\Url::to($sItem['url']);
                            }
                        ?>
                            <li><a href="<?=$url?>"<?if(!empty($sItem['new_tab'])):?> target="_blank"<?endif?>><?= $sItem['title']?></a></li>
                        <? endforeach ?>
                    </ul>
                <? endif ?>
            </li>
        <? endforeach ?>
    </ul>
</div>
<!-- end sidebar -->