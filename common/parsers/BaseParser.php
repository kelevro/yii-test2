<?php
namespace common\parsers;

use yii\base\Object;
use yii\base\Exception;

abstract class BaseParser extends Object
{
    protected $adapterName;

    /** @var  string */
    protected $fileName;

    public function init()
    {
        $alias              = $this->getAliasByFileName($this->fileName);
        $this->adapterName  = $this->loadAdapterByAlias($alias);
    }

    public function __construct($fileName, $config = [])
    {
        $this->fileName = $fileName;
        parent::__construct($config);
    }

    abstract public function parse();

    public function getAdaptersConfigList()
    {
        return [
            'xlsx' => '\\Spreadsheet_Excel_Reader',
            'xls'  => '\\Spreadsheet_Excel_Reader',
        ];
    }

    public function loadAdapterByAlias($alias)
    {
        if (!$config = $this->getAdaptersConfigList()[$alias]) {
            throw new Exception("Can't find adapter by alias #$alias");
        }

        return $config[$config];
    }

    protected function getAliasByFileName($fileName)
    {
        $path_info = pathinfo($fileName);
        if (empty($path_info['extension'])) {
            throw new Exception("File '$fileName' don't have extension");
        }
        return $path_info['extension'];
    }
}