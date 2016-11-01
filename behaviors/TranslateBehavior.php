<?php

namespace nhockizi\translatemanager\behaviors;

use Yii;
use yii\db\BaseActiveRecord;
use yii\behaviors\AttributeBehavior;
use nhockizi\translatemanager\helpers\Language;


class TranslateBehavior extends AttributeBehavior
{

    /**
     * @var array|string
     */
    public $translateAttributes;

    /**
     * @var string Category of message.
     */
    public $category = 'database';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        $this->category = str_replace(['{', '%', '}'], '', $this->category);
    }

    /**
     * @inheritdoc
     */
    public function events()
    {

        return [
            BaseActiveRecord::EVENT_AFTER_FIND => 'translateAttributes',
            BaseActiveRecord::EVENT_BEFORE_INSERT => 'saveAttributes',
            BaseActiveRecord::EVENT_BEFORE_UPDATE => 'saveAttributes',
        ];
    }

    /**
     * Translates a message to the specified language.
     * @param \yii\base\Event $event
     */
    public function translateAttributes($event)
    {
        /* @var $owner BaseActiveRecord */
        $owner = $this->owner;
        foreach ($this->translateAttributes as $attribute) {
            $owner->{$attribute} = Yii::t($this->category, $owner->attributes[$attribute]);
        }
    }

    /**
     * Saveing new language element by category.
     * @param \yii\base\Event $event
     */
    public function saveAttributes($event)
    {
        /* @var $owner BaseActiveRecord */
        $owner = $this->owner;
        foreach ($this->translateAttributes as $attribute) {
            if ($owner->isAttributeChanged($attribute)) {
                Language::saveMessage($owner->attributes[$attribute], $this->category);
            }
        }
    }

}
