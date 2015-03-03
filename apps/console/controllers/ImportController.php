<?php

namespace console\controllers;



use common\helpers\Stringy;
use product\models\Documentation;
use product\models\DocumentationCategory;

class ImportController extends \yii\console\Controller
{
    public function actionDocumentation()
    {
        $fileName = \Yii::getAlias('@app/runtime').'/documentation.xlsx';
        \L::trace('Start parse file: ' . $fileName);
        $objReader = \PHPExcel_IOFactory::createReaderForFile($fileName);
        $objReader->setReadDataOnly(true);

        $objPHPExcel = $objReader->load($fileName);
        $objWorksheet = $objPHPExcel->getActiveSheet();

        $highestRow = $objWorksheet->getHighestRow();
        $highestColumn = $objWorksheet->getHighestColumn();

        $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);

        for ($row = 1; $row <= $highestRow; ++$row) {
            if ($row == 1) {
                continue;
            }

            \L::trace('Parse row # ' . $row);
            $categoryName = $objWorksheet->getCellByColumnAndRow(1, $row)->getValue();
            $category = $this->getOrCreateCategory($categoryName);
            $doc = new Documentation();
            $doc->link = $objWorksheet->getCellByColumnAndRow(0, $row)->getValue();
            $doc->category_id = $category->id;
            $doc->save(false);
        }
        \L::success('Parse finished successfully');
    }

    protected function getOrCreateCategory($name)
    {
        if ($category = DocumentationCategory::findOne(['title' => $name])) {
            return $category;
        }
        $category = new DocumentationCategory();
        $category->title = $name;
        $category->slug  = (string)Stringy::create($name)->safeTruncate(50)->slugify();
        $category->save(false);
        return $category;
    }
}