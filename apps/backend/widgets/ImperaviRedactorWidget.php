<?php

namespace backend\widgets;

use yii\widgets\InputWidget;
use yii\helpers\Html;
use yii\helpers\Json;
use backend\widgets\assets\imperaviRedactor\ImperaviRedactorBundle;
use Yii;
/**
 * ImperaviRedactorWidget class file.
 *
 * @property string $assetsPath
 * @property string $assetsUrl
 * @property array $plugins
 *
 * @author Veaceslav Medvedev <slavcopost@gmail.com>
 * @author Alexander Makarov <sam@rmcreative.ru>
 *
 * @version 1.2.6
 *
 * @link https://github.com/yiiext/imperavi-redactor-widget
 * @link http://imperavi.com/redactor
 * @license https://github.com/yiiext/imperavi-redactor-widget/blob/master/license.md
 */
class ImperaviRedactorWidget extends InputWidget
{
    public $form;

    public $fieldOptions = [];

    /**
     * Assets package ID.
     */
    const PACKAGE_ID = 'imperavi-redactor';

    /**
     * @var array {@link http://imperavi.com/redactor/docs/ redactor options}.
     */
    public $options = [];

    /**
     * @var string|null Selector pointing to textarea to initialize redactor for.
     * Defaults to null meaning that textarea does not exist yet and will be
     * rendered by this widget.
     */
    public $selector;

    /**
     * @var array
     */
    public $package = [];

    /**
     * @var array
     */
    private $_plugins = [];

    /**
     * @var ImperaviRedactorBundle
     */
    private $bundle;


    public function init()
    {
        parent::init();

        if (!isset($this->fieldOptions['id'])) {
            $this->fieldOptions['id'] = $this->hasModel() ? Html::getInputId($this->model, $this->attribute) : $this->getId();
        }
        if (!isset($this->fieldOptions['class'])) {
            $this->fieldOptions['class'] .= ' imperavi-redactor';
        }
    }

    public function run()
    {
        $this->bundle = ImperaviRedactorBundle::register($this->view);

        $this->view->registerJs("$('#{$this->fieldOptions['id']}').redactor(".$this->getOptionsInJson().");");

        if ($this->hasModel()) {
            if (!empty($this->form)) {
                $input = $this->form->field($this->model, $this->attribute)->textarea($this->fieldOptions);
            } else {
                $input = Html::activeTextarea($this->model, $this->attribute, $this->options);
            }
        } else {
            $input = Html::textarea($this->name, $this->value, $this->options);
        }
        echo $input;
    }

    protected function getOptionsInJson()
    {
        $options = $this->options;
        if (!empty($this->options['lang'])) {
            $this->bundle->registerLangJsFile($this->options['lang']);
        }
        return ($options) ? Json::encode($options) : '';
    }
}
