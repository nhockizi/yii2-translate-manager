<?php

namespace nhockizi\translatemanager\bundles;

use yii\web\AssetBundle;

class LanguageItemPluginAsset extends AssetBundle {

    /**
     * @inheritdoc
     */
    public $sourcePath = '@nhockizi/translatemanager/assets';

    /**
     * @inheritdoc
     */
    public $publishOptions = [
        'forceCopy' => true
    ];

    /**
     * @inheritdoc
     */
    public function init() {

        $this->sourcePath = \Yii::$app->getModule('translatemanager')->getLanguageItemsDirPath();
        if (file_exists(\Yii::getAlias($this->sourcePath . \Yii::$app->language . '.js'))) {
            $this->js = [
                \Yii::$app->language . '.js'
            ];
        } else {
            $this->sourcePath = null;
        }

        parent::init();
    }

}
