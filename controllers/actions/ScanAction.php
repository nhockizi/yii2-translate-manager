<?php

namespace nhockizi\translatemanager\controllers\actions;

use yii\data\ArrayDataProvider;
use nhockizi\translatemanager\services\Scanner;
use nhockizi\translatemanager\models\LanguageSource;
use nhockizi\translatemanager\bundles\ScanPluginAsset;

class ScanAction extends \yii\base\Action {

    /**
     * @inheritdoc
     */
    public function init() {

        ScanPluginAsset::register($this->controller->view);
        parent::init();
    }

    /**
     * Detecting new language elements.
     * @return string
     */
    public function run() {

        $scanner = new Scanner;
        $scanner->run();

        $newDataProvider = $this->controller->createLanguageSourceDataProvider($scanner->getNewLanguageElements());
        $oldDataProvider = $this->_createLanguageSourceDataProvider($scanner->getRemovableLanguageSourceIds());

        return $this->controller->render('scan', [
                    'newDataProvider' => $newDataProvider,
                    'oldDataProvider' => $oldDataProvider,
        ]);
    }

    /**
     * Returns an ArrayDataProvider consisting of language elements.
     * @param array $languageSourceIds
     * @return ArrayDataProvider
     */
    private function _createLanguageSourceDataProvider($languageSourceIds) {
        $languageSources = LanguageSource::find()->with('languageTranslates')->where(['id' => $languageSourceIds])->all();

        $data = [];
        foreach ($languageSources as $languageSource) {
            $languages = [];
            if ($languageSource->languageTranslates) {
                foreach ($languageSource->languageTranslates as $languageTranslate) {
                    $languages[] = $languageTranslate->language;
                }
            }

            $data[] = [
                'id' => $languageSource->id,
                'category' => $languageSource->category,
                'message' => $languageSource->message,
                'languages' => implode(', ', $languages)
            ];
        }

        return new ArrayDataProvider([
            'allModels' => $data,
            'pagination' => false,
        ]);
    }

}
