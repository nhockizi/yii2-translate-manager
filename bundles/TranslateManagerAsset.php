<?php

namespace nhockizi\translatemanager\bundles;

use yii\web\AssetBundle;

class TranslateManagerAsset extends AssetBundle {

    /**
     * @inheritdoc
     */
    public $sourcePath = '@nhockizi/translatemanager/assets';

    /**
     * @inheritdoc
     */
    public $css = [
        'stylesheets/translate-manager.css',
    ];

    /**
     * @inheritdoc
     */
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];

}