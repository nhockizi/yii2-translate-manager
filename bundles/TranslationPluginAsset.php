<?php

namespace nhockizi\translatemanager\bundles;

use yii\web\AssetBundle;

class TranslationPluginAsset extends AssetBundle {

    /**
     * @inheritdoc
     */
    public $sourcePath = '@nhockizi/translatemanager/assets';

    /**
     * @inheritdoc
     */
    public $js = [
        'javascripts/md5.js',
        'javascripts/nhockizi.js',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'nhockizi\translatemanager\bundles\LanguageItemPluginAsset',
    ];

}
