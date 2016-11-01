<?php

namespace nhockizi\translatemanager\controllers\actions;

use Yii;
use yii\web\Response;
use nhockizi\translatemanager\services\Generator;
use nhockizi\translatemanager\models\LanguageTranslate;

class SaveAction extends \yii\base\Action {

    /**
     * Saving translated language elements.
     * @return Json
     */
    public function run() {

        Yii::$app->response->format = Response::FORMAT_JSON;

        $id = Yii::$app->request->post('id', 0);
        $languageId = Yii::$app->request->post('language_id', Yii::$app->language);

        $languageTranslate = LanguageTranslate::findOne(['id' => $id, 'language' => $languageId]) ? :
                new LanguageTranslate(['id' => $id, 'language' => $languageId]);

        $languageTranslate->translation = Yii::$app->request->post('translation', '');
        if ($languageTranslate->validate() && $languageTranslate->save()) {
            $generator = new Generator($this->controller->module, $languageId);

            $generator->run();
        }

        return $languageTranslate->getErrors();
    }

}
