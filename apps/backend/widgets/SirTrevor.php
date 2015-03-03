<?php


namespace backend\widgets;

use yii\base\InvalidConfigException;
use yii\base\Widget;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\helpers\Json;
use yii\widgets\InputWidget;


/**
 * Sir Trevor widget
 *
 * @package backend\widgets
 */
class SirTrevor extends InputWidget
{
    /**
     * @var array HTML attributes to be applied to the text input field.
     */
    public $options = [];

    protected $fiedSelector = 'sir-trevor';

    public $blockTypes = [];

    public $defaultType = '';

    public $blockLimit  = 0;

    public $blockTypeLimits = [];

    public $required = [];

    public $onEditorRender = '';

    public $uploadUrl = '';

    public $mainImageUrl = '/uploadUrlMainImg';

    public function init()
    {
        parent::init();

        if (!isset($this->options['id'])) {
            $this->options['id'] = $this->hasModel() ? Html::getInputId($this->model, $this->attribute) : $this->getId();
        }
        if (!isset($this->options['class'])) {
            $this->options['class'] = '';
        }
        $this->options['class'] .= ' sir-trevor';
    }


    public function run()
    {
        \common\assets\SirTrevor::register($this->view);

        $this->view->registerJs('window.editor = new SirTrevor.Editor('.$this->getOptionsInJson().');');

        if ($this->hasModel()) {
            $input = Html::activeTextarea($this->model, $this->attribute, $this->options);
        } else {
            $input = Html::textarea($this->name, $this->value, $this->options);
        }

        echo $input;
    }

    protected function getOptionsInJson()
    {
        $options = array('el' => new JsExpression('$(".'.$this->fiedSelector.'")'));
        if (!empty($this->blockTypes)) {
            $options['blockTypes'] = $this->blockTypes;
        }

        if (!empty($this->defaultType) && is_string($this->defaultType)) {
            $options['defaultType'] = $this->defaultType;
        }

        if (!empty($this->blockLimit) && is_int($this->blockLimit)) {
            $options['blockLimit'] = $this->blockLimit;
        }

        if (!empty($this->blockTypeLimits) && is_array($this->blockTypeLimits)) {
            $options['blockTypeLimits'] = $this->blockTypeLimits;
        }

        if (!empty($this->required) && is_array($this->required)) {
            $options['required'] = $this->required;
        }

        if (!empty($this->uploadUrl) && is_string($this->uploadUrl)) {
            $this->view->registerJs('SirTrevor.setDefaults({uploadUrl: "'.$this->uploadUrl.'"});');
        }
        if (!empty($this->mainImageUrl) && is_string($this->mainImageUrl)) {
            $this->view->registerJs("SirTrevor.DEFAULTS.mainImageUrl = '{$this->mainImageUrl}'");
        }

        if (!empty($this->onEditorRender) && is_string($this->onEditorRender)) {
            $options['onEditorRender'] = $this->onEditorRender instanceof JsExpression
                ? $this->onEditorRender
                : new JsExpression($this->onEditorRender);
        }
        return ($options)? Json::encode($options):'';
    }
}