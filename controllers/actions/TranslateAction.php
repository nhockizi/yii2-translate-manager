<?php

namespace nhockizi\translatemanager\controllers\actions;

use Yii;
use nhockizi\translatemanager\bundles\TranslateAsset;
use nhockizi\translatemanager\bundles\TranslatePluginAsset;
use nhockizi\translatemanager\models\searches\LanguageSourceSearch;

class TranslateAction extends \yii\base\Action {

    /**
     * @inheritdoc
     */
    public function init() {

        TranslateAsset::register(Yii::$app->controller->view);
        TranslatePluginAsset::register(Yii::$app->controller->view);
        parent::init();
    }

    /**
     * List of language elements.
     * @return string
     */
    public function run() {

        $searchModel = new LanguageSourceSearch([
            'searchEmptyCommand' => $this->controller->module->searchEmptyCommand,
        ]);
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->controller->render('translate', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
                    'language_id' => Yii::$app->request->get('language_id', '')
        ]);
    }

}
