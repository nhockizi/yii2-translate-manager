<?php

namespace nhockizi\translatemanager\bundles;

use yii\web\AssetBundle;

class LanguagePluginAsset extends AssetBundle {

    /**
     * @inheritdoc
     */
    public $sourcePath = '@nhockizi/translatemanager/assets';

    /**
     * @inheritdoc
     */
    public $js = [
        'javascripts/helpers.js',
        'javascripts/language.js',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
