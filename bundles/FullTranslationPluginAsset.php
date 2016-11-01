<?php

namespace nhockizi\translatemanager\bundles;

use yii\web\AssetBundle;

class FullTranslationPluginAsset extends TranslationPluginAsset {

    /**
     * @inheritdoc
     */
    public $depends = [
        'nhockizi\translatemanager\bundles\AllLanguageItemPluginAsset',
    ];

}
