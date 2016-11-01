<?php

namespace nhockizi\translatemanager\bundles;

use yii\web\AssetBundle;

class TranslateAsset extends AssetBundle {

    /**
     * @inheritdoc
     */
    public $sourcePath = '@nhockizi/translatemanager/assets';

    /**
     * @inheritdoc
     */
    public $css = [
        'stylesheets/helpers.css',
        'stylesheets/translate.css',
    ];

}
