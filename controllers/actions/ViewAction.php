<?php

namespace nhockizi\translatemanager\controllers\actions;

class ViewAction extends \yii\base\Action {

    /**
     * Displays a single Language model.
     * @param string $id
     * @return mixed
     */
    public function run($id) {
        return $this->controller->render('view', [
                    'model' => $this->controller->findModel($id),
        ]);
    }

}
