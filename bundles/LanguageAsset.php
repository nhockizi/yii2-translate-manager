<?php

namespace nhockizi\translatemanager\bundles;

use yii\web\AssetBundle;

class LanguageAsset extends AssetBundle {

    /**
     * @inheritdoc
     */
    public $sourcePath = '@nhockizi/translatemanager/assets';

    /**
     * @inheritdoc
     */
    public $css = [
        'stylesheets/helpers.css',
        'stylesheets/language.css',
    ];

}