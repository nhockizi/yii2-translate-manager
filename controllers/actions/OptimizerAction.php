<?php

namespace nhockizi\translatemanager\controllers\actions;

use nhockizi\translatemanager\services\Optimizer;

class OptimizerAction extends \yii\base\Action {

    /**
     * Removing unused language elements.
     * @return string
     */
    public function run() {
        $optimizer = new Optimizer;
        $optimizer->run();

        $removedLanguageElements = $optimizer->getRemovedLanguageElements();
        return $this->controller->render('optimizer', [
                    'newDataProvider' => $this->controller->createLanguageSourceDataProvider($removedLanguageElements)
        ]);
    }

}
