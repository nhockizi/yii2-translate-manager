<?php

namespace nhockizi\translatemanager\controllers\actions;

use Yii;
use yii\web\Response;
use nhockizi\translatemanager\models\Language;

class ChangeStatusAction extends \yii\base\Action {

    /**
     * Modifying the state of language.
     * @return Json
     */
    public function run() {

        Yii::$app->response->format = Response::FORMAT_JSON;

        $language = Language::findOne(Yii::$app->request->post('language_id', ''));
        if ($language !== null) {
            $language->status = Yii::$app->request->post('status', Language::STATUS_BETA);
            if ($language->validate()) {
                $language->save();
            }
        }

        return $language->getErrors();
    }

}
