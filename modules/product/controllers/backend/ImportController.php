<?php

namespace product\controllers\backend;

use backend\components\Controller;
use common\helpers\Stringy;
use product\models\Category;
use product\models\Product;
use yii\web\UploadedFile;

class ImportController extends Controller
{

    public function actionIndex()
    {
        ini_set("memory_limit", "712M");

        $this->pageTitle = 'Import';
        if ($file = UploadedFile::getInstanceByName('import')) {
            $fileName = \Yii::getAlias('@app/runtime').'/'.$file->name;
            if ($file->saveAs($fileName, true)) {
                $objReader = \PHPExcel_IOFactory::createReaderForFile($fileName);
                $objReader->setReadDataOnly(true);

                $objPHPExcel = $objReader->load($fileName);
                $objWorksheet = $objPHPExcel->getActiveSheet();

                $highestRow = $objWorksheet->getHighestRow();
                $highestColumn = $objWorksheet->getHighestColumn();

                $highestColumnIndex = \PHPExcel_Cell::columnIndexFromString($highestColumn);
                $fiedsName = [];
                for ($row = 1; $row <= $highestRow; ++$row) {
                    if ($row == 1) {
                        for ($col = 0; $col <= $highestColumnIndex; ++$col) {
                            switch($objWorksheet->getCellByColumnAndRow($col, $row)->getValue()){
                                case "ID":
                                    $fiedsName['id'] = $col;
                                    break;
                                case "Сортировка":
                                    $fiedsName['position'] = $col;
                                    break;
                                case "Позиция":
                                    $fiedsName['title'] = $col;
                                    break;
                                case "Описание":
                                    $fiedsName['description'] = $col;
                                    break;
                                case "Категория":
                                    $fiedsName['category'] = $col;
                                    break;
                                case "Цена для сайта":
                                    $fiedsName['price'] = $col;
                                    break;
                                case "Опт":
                                    $fiedsName['wholesale'] = $col;
                                    break;
                                case "М.Опт":
                                    $fiedsName['small_wholesale'] = $col;
                                    break;
                                case "Количество":
                                    $fiedsName['count'] = $col;
                                    break;
                                case "Производитель":
                                    $fiedsName['producer'] = $col;
                                    break;
                                case "Удален":
                                    $fiedsName['is_deleted'] = $col;
                                    break;
                            }
                        }
                    } else {
                        $priceId = $objWorksheet->getCellByColumnAndRow($fiedsName['id'], $row)->getValue();
                        if (!$priceId) {
                            continue;
                        }
                        $categoryName = $objWorksheet->getCellByColumnAndRow($fiedsName['category'], $row)->getValue();
                        $category = $this->getOrCreateCategory($categoryName);

                        if (!$product = Product::findOne(['price_id' => $priceId])) {
                            $product = new Product();
                        }

                        if (isset($fiedsName['position'])
                            && ($position = $objWorksheet->getCellByColumnAndRow($fiedsName['position'], $row)->getValue())) {
                            $product->position = $position;
                        } else {
                            $product->position = $priceId;
                        }

                        $product->title = $objWorksheet->getCellByColumnAndRow($fiedsName['title'], $row)->getValue();
                        $product->description = $objWorksheet->getCellByColumnAndRow($fiedsName['description'], $row)->getValue();
                        $product->is_enabled = 1;
                        $product->category_id = $category->id;
                        $product->price_id = $priceId;

                        if (!empty($fiedsName['is_deleted'])) {
                            $product->is_deleted = ($objWorksheet->getCellByColumnAndRow($fiedsName['is_deleted'], $row)->getValue())
                                ? ($objWorksheet->getCellByColumnAndRow($fiedsName['is_deleted'], $row)->getValue())
                                : 0;
                        } else {
                            if ($product->isNewRecord) {
                                $product->is_deleted = 1;
                            } else {
                                $product->is_deleted = 0;
                            }
                        }

                        if (!empty($fiedsName['price'])) {
                            $product->price =  ($objWorksheet->getCellByColumnAndRow($fiedsName['price'], $row)->getFormattedValue())?:0;
                        }

                        if (!empty($fiedsName['wholesale'])) {
                            $product->wholesale =  ($objWorksheet->getCellByColumnAndRow($fiedsName['wholesale'], $row)->getFormattedValue())?:0;
                        }

                        if (!empty($fiedsName['small_wholesale'])) {
                            $product->small_wholesale =  ($objWorksheet->getCellByColumnAndRow($fiedsName['small_wholesale'], $row)->getFormattedValue())?:0;
                        }

                        if (!empty($fiedsName['count'])) {
                            $product->count =  ($objWorksheet->getCellByColumnAndRow($fiedsName['count'], $row)->getFormattedValue())?:0;
                        }

                        if (!empty($fiedsName['producer'])) {
                            $product->producer =  ($objWorksheet->getCellByColumnAndRow($fiedsName['producer'], $row)->getFormattedValue())?:null;
                        }

                        $product->slug = (string)Stringy::create($product->title)->safeTruncate(50)->slugify();
                        $product->save(false);

                    }

                }
                $this->setFlash('Products upload successfully');

                if (file_exists($fileName)) {
                    unlink($fileName);
                }
            }
        }

        return $this->render('index');
    }

    protected function getOrCreateCategory($name)
    {
        if ($category = Category::findOne(['title' => $name])) {
            return $category;
        }
        $parent = Category::findOne(['slug' => 'catalog']);
        $category = new Category();
        $category->title = $name;
        $category->slug  = (string)Stringy::create($name)->safeTruncate(50)->slugify();
        $category->is_enabled = 1;
        $category->appendTo($parent);
        return $category;
    }
}
