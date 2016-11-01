<?php

namespace nhockizi\translatemanager\bundles;

use yii\web\AssetBundle;

class AllLanguageItemPluginAsset extends LanguageItemPluginAsset {

    public function init() {

        parent::init();
        $this->js = [];
        $this->sourcePath = \Yii::$app->getModule('translatemanager')->getLanguageItemsDirPath();

        $langs = \nhockizi\translatemanager\models\Language::findAll(['status'=>  \nhockizi\translatemanager\models\Language::STATUS_ACTIVE]);

        foreach ($langs as $key => $lang){
            if (file_exists(\Yii::getAlias($this->sourcePath . $lang->language_id . '.js'))) {
                $this->js[] = $lang->language_id . '.js';
            }
        }

    }

}
