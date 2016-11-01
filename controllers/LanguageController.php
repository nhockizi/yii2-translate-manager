<?php

namespace nhockizi\translatemanager\controllers;

use yii\web\Controller;
use yii\filters\AccessControl;

class LanguageController extends Controller {

    /**
     * @var \nhockizi\translatemanager\Module TranslateManager module
     */
    public $module;

    /**
     * @inheritdoc
     */
    public $defaultAction = 'list';

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['list', 'change-status', 'optimizer', 'scan', 'translate', 'save', 'dialog', 'message', 'view', 'create', 'update', 'delete', 'delete-source', 'import', 'export'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['list', 'change-status', 'optimizer', 'scan', 'translate', 'save', 'dialog', 'message', 'view', 'create', 'update', 'delete', 'delete-source', 'import', 'export'],
                        'roles' => $this->module->roles,
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'list' => [
                'class' => 'nhockizi\translatemanager\controllers\actions\ListAction',
            ],
            'change-status' => [
                'class' => 'nhockizi\translatemanager\controllers\actions\ChangeStatusAction',
            ],
            'optimizer' => [
                'class' => 'nhockizi\translatemanager\controllers\actions\OptimizerAction',
            ],
            'scan' => [
                'class' => 'nhockizi\translatemanager\controllers\actions\ScanAction',
            ],
            'translate' => [
                'class' => 'nhockizi\translatemanager\controllers\actions\TranslateAction',
            ],
            'save' => [
                'class' => 'nhockizi\translatemanager\controllers\actions\SaveAction',
            ],
            'dialog' => [
                'class' => 'nhockizi\translatemanager\controllers\actions\DialogAction',
            ],
            'message' => [
                'class' => 'nhockizi\translatemanager\controllers\actions\MessageAction',
            ],
            'view' => [
                'class' => 'nhockizi\translatemanager\controllers\actions\ViewAction',
            ],
            'create' => [
                'class' => 'nhockizi\translatemanager\controllers\actions\CreateAction',
            ],
            'update' => [
                'class' => 'nhockizi\translatemanager\controllers\actions\UpdateAction',
            ],
            'delete' => [
                'class' => 'nhockizi\translatemanager\controllers\actions\DeleteAction',
            ],
            'delete-source' => [
                'class' => 'nhockizi\translatemanager\controllers\actions\DeleteSourceAction',
            ],
            'import' => [
                'class' => 'nhockizi\translatemanager\controllers\actions\ImportAction',
            ],
            'export' => [
                'class' => 'nhockizi\translatemanager\controllers\actions\ExportAction',
            ],
        ];
    }

    /**
     * Finds the Language model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Language the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function findModel($id) {
        if (($model = \nhockizi\translatemanager\models\Language::findOne($id)) !== null) {
            return $model;
        } else {
            throw new \yii\web\NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
    /**
     * Returns an ArrayDataProvider consisting of language elements.
     * @param array $languageSources
     * @return \yii\data\ArrayDataProvider
     */
    public function createLanguageSourceDataProvider($languageSources) {

        $data = [];
        foreach ($languageSources as $category => $messages) {
            foreach ($messages as $message => $boolean) {
                $data[] = [
                    'category' => $category,
                    'message' => $message
                ];
            }
        }

        return new \yii\data\ArrayDataProvider([
            'allModels' => $data,
            'pagination' => false
        ]);
    }

}
