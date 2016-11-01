<?php

namespace nhockizi\translatemanager\bundles;

use yii\web\AssetBundle;

class ScanPluginAsset extends AssetBundle {

    /**
     * @inheritdoc
     */
    public $sourcePath = '@nhockizi/translatemanager/assets';

    /**
     * @inheritdoc
     */
    public $js = [
        'javascripts/scan.js',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\JqueryAsset',
        'nhockizi\translatemanager\bundles\TranslationPluginAsset',
    ];

}
