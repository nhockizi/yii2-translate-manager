<?php

namespace nhockizi\translatemanager\controllers\actions;

use Yii;
use yii\widgets\ActiveForm;

class UpdateAction extends \yii\base\Action {

    /**
     * Updates an existing Language model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function run($id) {
        $model = $this->controller->findModel($id);
        
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        } else if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->controller->redirect(['view', 'id' => $model->language_id]);
        } else {
            return $this->controller->render('update', [
                        'model' => $model,
            ]);
        }
    }

}
