<?php

namespace nhockizi\translatemanager\bundles;

use yii\web\AssetBundle;

class FrontendTranslationPluginAsset extends AssetBundle {

    /**
     * @inheritdoc
     */
    public $sourcePath = '@nhockizi/translatemanager/assets';

    /**
     * @inheritdoc
     */
    public $js = [
        'javascripts/helpers.js',
        'javascripts/frontend-translation.js',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\jui\JuiAsset',
        'nhockizi\translatemanager\bundles\TranslationPluginAsset',
    ];

}
