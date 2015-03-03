<?php

namespace mail\widgets;

use mail\models\Subscriber;
use yii\base\Widget;

/**
 * Subscription widget
 *
 * @package mail\widgets
 */
class Subscribe extends Widget
{
    public $viewFile = 'subscribe';

    /**
     * @inheritdoc
     */
    public function run()
    {
        $model = new Subscriber;

        echo $this->render($this->viewFile, [
            'model' => $model,
        ]);
    }
}
