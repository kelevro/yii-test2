<?php
namespace common\parsers;

class Parser extends BaseParser
{
    public function parse()
    {
        /** @var \Spreadsheet_Excel_Reader $data */
        $data = new $this->adapterName($this->fileName);
        $rowcount = $data->rowcount($sheet_index=0);

        $colcount = $data->colcount($sheet_index=0);
    }
}