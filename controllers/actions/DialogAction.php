<?php

namespace nhockizi\translatemanager\controllers\actions;

use Yii;
use nhockizi\translatemanager\models\LanguageSource;
use nhockizi\translatemanager\models\LanguageTranslate;

class DialogAction extends \yii\base\Action {

    /**
     * Creating dialogue box.
     * @return View
     */
    public function run() 
    {
        $languageSource = LanguageSource::findOne([
            'category' => Yii::$app->request->post('category', ''),
            'MD5(message)' => Yii::$app->request->post('hash', '')
        ]);

        if (!$languageSource) {
            return '<div id="translate-manager-error">' . Yii::t('language', 'Text not found in database! Please run project scan before translating!') . '</div>';
        }

        return $this->controller->renderPartial('dialog', [
            'languageSource' => $languageSource,
            'languageTranslate' => $this->_getTranslation($languageSource),
        ]);
    }
    
    /**
     * @param LanguageSource $languageSource
     * @return LanguageTranslate
     */
    private function _getTranslation($languageSource) 
    {
        $languageId = Yii::$app->request->post('language_id', '');
        $languageTranslate = $languageSource
            ->getLanguageTranslates()
            ->andWhere(['language' => $languageId])
            ->one();
        
        if (!$languageTranslate) {
            $languageTranslate = new LanguageTranslate([
                'id' => $languageSource->id,
                'language' => $languageId
            ]);
        }
        
        return $languageTranslate;
    }

}
