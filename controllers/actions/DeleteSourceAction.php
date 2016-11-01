<?php

namespace nhockizi\translatemanager\controllers\actions;

use Yii;
use yii\web\Response;
use nhockizi\translatemanager\models\LanguageSource;

class DeleteSourceAction extends \yii\base\Action {

    /**
     * Deletes an existing LanguageSource model.
     * If deletion is successful, the browser will be redirected to the 'list' page.
     * @return json
     */
    public function run() {

        Yii::$app->response->format = Response::FORMAT_JSON;

        $ids = Yii::$app->request->post('ids');

        LanguageSource::deleteAll(['id' => (array) $ids]);

        return [];
    }

}
