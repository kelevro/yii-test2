<?php

Yii::setAlias('root', ROOT);

Yii::setAlias('common', ROOT . '/common');
Yii::setAlias('console', ROOT . '/apps/console');
Yii::setAlias('frontend', ROOT . '/apps/frontend');
Yii::setAlias('backend', ROOT . '/apps/backend');
Yii::setAlias('extensions', ROOT . '/common/extensions');

// special dirs
Yii::setAlias('storage',  ROOT . '/apps/storage');

Yii::setAlias('user',  '@backend/modules/user');