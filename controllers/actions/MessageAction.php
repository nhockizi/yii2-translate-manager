<?php

namespace nhockizi\translatemanager\controllers\actions;

use Yii;
use nhockizi\translatemanager\models\LanguageSource;
use nhockizi\translatemanager\models\LanguageTranslate;

class MessageAction extends \yii\base\Action {

    /**
     * Returning messages in the given language
     * @return string
     */
    public function run() {

        $languageTranslate = LanguageTranslate::findOne([
                    'id' => Yii::$app->request->get('id', 0),
                    'language' => Yii::$app->request->get('language_id', '')
        ]);

        if ($languageTranslate) {
            $translation = $languageTranslate->translation;
        } else {
            $languageSource = LanguageSource::findOne([
                        'id' => Yii::$app->request->get('id', 0)
            ]);

            $translation = $languageSource ? $languageSource->message : '';
        }

        return $translation;
    }

}
