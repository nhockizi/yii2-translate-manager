<?php

namespace nhockizi\translatemanager\controllers\actions;

use Yii;
use nhockizi\translatemanager\models\searches\LanguageSearch;
use nhockizi\translatemanager\bundles\LanguageAsset;
use nhockizi\translatemanager\bundles\LanguagePluginAsset;

class ListAction extends \yii\base\Action {

    /**
     * @inheritdoc
     */
    public function init() {

        LanguageAsset::register($this->controller->view);
        LanguagePluginAsset::register($this->controller->view);
        parent::init();
    }

    /**
     * List of languages
     * @return string
     */
    public function run() {

        $searchModel = new LanguageSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());
        $dataProvider->sort = ['defaultOrder' => ['status'=>SORT_DESC]];

        return $this->controller->render('list', [
                    'dataProvider' => $dataProvider,
                    'searchModel' => $searchModel,
        ]);
    }

}
