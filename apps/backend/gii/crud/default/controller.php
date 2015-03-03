<?php

use yii\helpers\StringHelper;

/**
 * This is the template for generating a CRUD controller class file.
 *
 * @var yii\web\View $this
 * @var yii\gii\generators\crud\Generator $generator
 */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
	$searchModelAlias = $searchModelClass.'Search';
}

$pks = $generator->getTableSchema()->primaryKey;
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use <?= ltrim($generator->modelClass, '\\') ?>;
use <?= ltrim($generator->searchModelClass, '\\') ?><?php if (isset($searchModelAlias)):?> as <?= $searchModelAlias ?><?php endif ?>;
use <?= ltrim($generator->baseControllerClass, '\\') ?>;

/**
 * <?= $controllerClass ?> implements the CRUD actions for <?= $modelClass ?> model.
 */
class <?= $controllerClass ?> extends <?= StringHelper::basename($generator->baseControllerClass) . "\n" ?>
{

    /**
    * @inheritdoc
    */
    public function sectionTitle()
    {
        return ['url alias here', '<?=$controllerClass?>'];
    }


	/**
	 * Lists all <?= $modelClass ?> models.
	 * @return mixed
	 */
	public function actionIndex()
	{
		$searchModel = new <?= isset($searchModelAlias) ? $searchModelAlias : $searchModelClass ?>;
		$dataProvider = $searchModel->search($_GET);

        $this->pageTitle = 'List';
		return $this->render('index', [
			'dataProvider' => $dataProvider,
			'searchModel' => $searchModel,
		]);
	}

	/**
	 * Displays a single <?= $modelClass ?> model.
	 * @return mixed
	 */
	public function actionView()
	{
        /** @var <?=$modelClass?> $model */
        $model = $this->loadModel('<?=ltrim($generator->modelClass, '\\')?>');

        $this->pageTitle = $model->title;
		return $this->render('view', [
			'model' => $model,
		]);
	}

	/**
	 * Updates an existing <?= $modelClass ?> model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @return mixed
	 */
	public function actionUpdate()
	{
        /** @var <?=$modelClass?> $model */
        $model = $this->loadOrCreateModel('<?=ltrim($generator->modelClass, '\\')?>');

        if ($model->load($_POST)) {
            /*
            if ($model->isNewRecord) {
                $model->project_id = \Y::multisite()->getProjectId();
            }
            */
            if ($model->save()) {
                $this->flash = "{$model->title} successful saved";
                return $this->redirect(['view', 'id' => $model->id]);
            }
            $this->errorFlash = 'Error saving';
        }


        $this->pageTitle = $model->isNewRecord ? 'Create new ' : ('Edit ' . $model->title);
        return $this->render('update', [
            'model' => $model,
        ]);
	}

	/**
	 * Deletes an existing <?= $modelClass ?> model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @return mixed
	 */
	public function actionDelete()
	{
        /** @var <?=$modelClass?> $model */
        $model = $this->loadModel('<?=ltrim($generator->modelClass, '\\')?>');

		$model->delete();

		return $this->redirect(['index']);
	}
}
