Yii2 - Translate Manager
========================
Online Translations

Introduction
------------

This module provides a simple translating interface for the multilingual elements of your project. It can auto-detect new language elements (project scan).
Duplications are filtered out automatically during project scanning.
Unused language elements can be removed from the database with a single click (database optimisation) and translations can be imported and exported.
It is possible to translate client side messages too (those stored in JavaScript files) as the project scan collects language elements to be translated from JavaScript files as well.

It also allows you to translate text on the client side (on the live webpage) without having to log in to the translating interface. (frontendTranslation).

On the server side it can handle database or one-dimensional/multidimensional array elements and Yii::t functions.
You can exclude files, folders or categories to prevent them from being translated.

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist nhockizi/yii2-translate-manager "1.*"
```

or add

```json
"nhockizi/yii2-translate-manager": "1.*"
```

to the require section of your `composer.json` file.

###Migration


Run the following command in Terminal for database migration:

Linux/Unix:
```
yii migrate/up --migrationPath=@vendor/nhockizi/yii2-translate-manager/migrations
```

Windows:
```
yii.bat migrate/up --migrationPath=@vendor/nhockizi/yii2-translate-manager/migrations
```

###Config

A simple exmple of turning on Yii database multilingual.

```php
'language' => 'en-US',
'components' => [
    'i18n' => [
        'translations' => [
            '*' => [
                'class' => 'yii\i18n\DbMessageSource',
                'db' => 'db',
                'sourceLanguage' => 'xx-XX', // Developer language
                'sourceMessageTable' => '{{%language_source}}',
                'messageTable' => '{{%language_translate}}',
                'cachingDuration' => 86400,
                'enableCaching' => true,
            ],
        ],
    ],
],
```


Turning on the TranslateManager Module:


Simple example:

```php
'modules' => [
    'translatemanager' => [
        'class' => 'nhockizi\translatemanager\Module',
    ],
],
```

A more complex example including database table with multilingual support is below:
```php
'modules' => [
    'translatemanager' => [
        'class' => 'nhockizi\translatemanager\Module',
        'root' => '@app',               // The root directory of the project scan.
        'scanRootParentDirectory' => true, // Whether scan the defined `root` parent directory, or the folder itself.
                                           // IMPORTANT: for detailed instructions read the chapter about root configuration.
        'layout' => 'language',         // Name of the used layout. If using own layout use 'null'.
        'allowedIPs' => ['127.0.0.1'],  // IP addresses from which the translation interface is accessible.
        'roles' => ['@'],               // For setting access levels to the translating interface.
        'tmpDir' => '@runtime',         // Writable directory for the client-side temporary language files.
                                        // IMPORTANT: must be identical for all applications (the AssetsManager serves the JavaScript files containing language elements from this directory).
        'phpTranslators' => ['::t'],    // list of the php function for translating messages.
        'jsTranslators' => ['nhockizi.t'], // list of the js function for translating messages.
        'patterns' => ['*.js', '*.php'],// list of file extensions that contain language elements.
        'ignoredCategories' => ['yii'], // these categories won't be included in the language database.
        'ignoredItems' => ['config'],   // these files will not be processed.
        'scanTimeLimit' => null,        // increase to prevent "Maximum execution time" errors, if null the default max_execution_time will be used
        'searchEmptyCommand' => '!',    // the search string to enter in the 'Translation' search field to find not yet translated items, set to null to disable this feature
        'defaultExportStatus' => 1,     // the default selection of languages to export, set to 0 to select all languages by default
        'defaultExportFormat' => 'json',// the default format for export, can be 'json' or 'xml'
        'tables' => [                   // Properties of individual tables
            [
                'connection' => 'db',   // connection identifier
                'table' => '{{%language}}',         // table name
                'columns' => ['name', 'name_ascii'],// names of multilingual fields
                'category' => 'database-table-name',// the category is the database table name
            ]
        ],
        'scanners' => [ // define this if you need to override default scanners (below)
            '\nhockizi\translatemanager\services\scanners\ScannerPhpFunction',
            '\nhockizi\translatemanager\services\scanners\ScannerPhpArray',
            '\nhockizi\translatemanager\services\scanners\ScannerJavaScriptFunction',
            '\nhockizi\translatemanager\services\scanners\ScannerDatabase',
        ],
        'googleApiKey' => 'your_google_API_Key', // if set - google translation will be inserted into translation field when you click on the source field.  
    ],
],
```

#### Configuring the scan root

The root path can be an alias or a full path (e.g. `@app` or `/webroot/site/`).

The file scanner will scan the configured folders for translatable elements. The following two options
determine the scan root directory: `root`, and `scanRootParentDirectory`. These options are defaults to
values that works with the Yii 2 advanced project template. If you are using basic template, you have to modify
these settings.

The `root` options tells which is the root folder for project scan. It can contain a single directory (string),
or multiple directories (in an array).

The `scanRootParentDirectory` **is used only** if a single root directory is specified in a string.

**IMPORTANT: Changing these options could cause loss of translated items,
as optimize action removes the missing items.** So be sure to double check your configuration!

**a)** Single root directory:

It is possible to define one root directory as string in the `root` option. In this case the `scanRootParentDirectory`
will be used when determining the actual directory to scan.

If `scanRootParentDirectory` is set to `true` (which is the default value), the scan will run on the parent directory.
This is desired behavior on advanced template, because the `@app` is the root for the current app, which is a subfolder
inside the project (so the entire root of the project is the parent directory of `@app`).

For basic template the `@app` is also the root for the entire project. Because of this with the default value
of `scanRootParentDirectory`, the scan runs outside the project folder. This is not desired behavior, and
changing the value to `false` solves this.

**IMPORTANT: Changing the `scanRootParentDirectory` from `true` to `false` could cause loss of translated items,
as the root will be a different directory.**

For example:

| `root` value | `scanRootParentDirectory` value| Scanned directory |
|---|---|---|
| `/webroot/site/frontend` | `true` | `/webroot/site` |
| `/webroot/site/frontend` | `false` | `/webroot/site/frontend` |

**b)** Multiple root directories:

Multiple root directories can be defined in an array. In this case all items must point to the exact directory,
as `scanRootParentDirectory` **will be omitted**.

For example:

```php
'root' => [
    '@frontend',
    '@vendor',
    '/some/external/folder',
],
```

#### Using of [authManager](http://www.yiiframework.com/doc-2.0/guide-security-authorization.html)

Examples:

PhpManager:
```php
'components' => [
    'authManager' => [
        'class' => 'yii\rbac\PhpManager',
    ],
    // ...
],
```

DbManager:
```php
'components' => [
    'authManager' => [
        'class' => 'yii\rbac\DbManager',
    ],
    // ...
],
```

#### Front end translation:

```php
'bootstrap' => ['translatemanager'],
'components' => [
    'translatemanager' => [
        'class' => 'nhockizi\translatemanager\Component'
    ]
]
```

Usage
-----
###Register client scripts

To translate static messages in JavaScript files it is necessary to register the files.

To register your scripts, call the following method in each action:

```php
\nhockizi\translatemanager\helpers\Language::registerAssets();
```

A simple example for calling the above method at each page load:
```php
namespace common\controllers;

use nhockizi\translatemanager\helpers\Language;

// IMPORTANT: all Controllers must originate from this Controller!
class Controller extends \yii\web\Controller {

    public function init() {
        Language::registerAssets();
        parent::init();
    }
}
```

###ToggleTranslate button

Simple example for displaying a button to switch to front end translation mode.
(The button will only appear for users who have the necessary privileges for translating!)

```php
\nhockizi\translatemanager\widgets\ToggleTranslate::widget();
```

A more complex example for displaying the button:

```php
\nhockizi\translatemanager\widgets\ToggleTranslate::widget([
 'position' => \nhockizi\translatemanager\widgets\ToggleTranslate::POSITION_TOP_RIGHT,
 'template' => '<a href="javascript:void(0);" id="toggle-translate" class="{position}" data-language="{language}" data-url="{url}"><i></i> {text}</a><div id="translate-manager-div"></div>',
 'frontendTranslationAsset' => 'nhockizi\translatemanager\bundles\FrontendTranslationAsset',
 'frontendTranslationPluginAsset' => 'nhockizi\translatemanager\bundles\FrontendTranslationPluginAsset',
]);
```

###Placing multilingual elements in the source code.

JavaScript:

```php
nhockizi.t('Apple');
nhockizi.t('Hello {name}!', {name:'World'});
nhockizi.t("Don't be so upset.");
```

PHP methods:

```php
Yii::t('category', 'Apple');
Yii::t('category', 'Hello {name}!', ['name' => 'World']);
Yii::t('category', "Don't be so upset.");
```

PHP functions for front end translation:

```php
use nhockizi\translatemanager\helpers\Language as Lx;

Lx::t('category', 'Apple');
Lx::t('category', 'Hello {name}!', ['name' => 'World']);
Lx::t('category', "Don't be so upset.");
```

**IMPORTANT: The nhockizi\translatemanager\helpers\Language::t() (Lx::t()) function currently does not support the translation of HTMLattributes**

PHP arrays:

```php
/**
 * @translate
 */
private $_STATUSES = [
    self::STATUS_INACTIVE => 'Inactive',
    self::STATUS_ACTIVE => 'Active',
    self::STATUS_DELETED => 'Deleted'
];

/**
 * Returning the 'status' array on the site's own language.
 * return array
 */
public function getStatuses() {
    return \nhockizi\translatemanager\helpers\Language::a($this->_STATUSES);
}

/**
 * @translate
 */
private $_GENDERS = ['Male', 'Female'];

/**
 * Returning the 'genders' array in German
 * return array
 */
public function getGenders() {
    return \nhockizi\translatemanager\helpers\Language::a($this->_GENDERS, 'de-DE');
}
```

PHP Database:

* With new attributes:

```php
namespace common\models;

use nhockizi\translatemanager\helpers\Language;

/**
 * This is the model class for table "category".
 *
 * @property string $category_id
 * @property string $name
 * @property string $description
 */
class Category extends \yii\db\ActiveRecord {

    // afterFind & beforeSave:

    /**
     * @var Returning the 'name' attribute on the site's own language.
     */
    public $name_t;

    /**
     * @var Returning the 'description' attribute on the site's own language.
     */
    public $description_t;

    /* ... */

    public function afterFind() {
        $this->name_t = Language::d($this->name);
        $this->description_t = Language::d($this->descrioption);

        // or If the category is the database table name.
        // $this->name_t = Language::t(static::tableName(), $this->name);
        // $this->description_t = Language::t(static::tableName(), $this->description);
        parent::afterFind();
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            Language::saveMessage($this->name);
            Language::saveMessage($this->description);

            // or If the category is the database table name.
            // Language::saveMessage($this->name, static::tableName());
            // Language::saveMessage($this->description, static::tableName());

            return true;
        }

        return false;
    }

    // or GETTERS:

    /**
     * @return string Returning the 'name' attribute on the site's own language.
     */
    public function getName($params = [], $language = null) {
        return Language::d($this->name, $params, $language);

        // or If the category is the database table name.
        // return Language::t(static::tableName(), $this->name, $params, $language);
    }

    /**
     * @return string Returning the 'description' attribute on the site's own language.
     */
    public function getDescription($params = [], $language = null) {
        return Language::d($this->description, $params, $language);

        // or If the category is the database table name.
        // return Language::t(static::tableName(), $this->description, $params, $language);
    }
}
```


* With behavior (since 1.5.3):

    **Note:** This will replace the model's original attribute values!

```php
namespace common\models;

/**
 * This is the model class for table "category".
 *
 * @property string $category_id
 * @property string $name
 * @property string $description
 */
class Category extends \yii\db\ActiveRecord {

    // TranslateBehavior

    public function behaviors()
    {
        return [
            [
                'class' => \nhockizi\translatemanager\behaviors\TranslateBehavior::className(),
                'translateAttributes' => ['name', 'description'],
            ],

            // or If the category is the database table name.
            // [
            //     'class' => \nhockizi\translatemanager\behaviors\TranslateBehavior::className(),
            //     'translateAttributes' => ['name', 'description'],
            //     'category' => static::tableName(),
            // ],
        ];
    }

}
```

###URLs

URLs for the translating tool:

```php
/translatemanager/language/list         // List of languages and modifying their status
/translatemanager/language/create       // Create languages
/translatemanager/language/scan         // Scan the project for new multilingual elements
/translatemanager/language/optimizer    // Optimise the database
```

Example implementation of the Yii2 menu into your own menu.

```php
$menuItems = [
    ['label' => Yii::t('language', 'Language'), 'items' => [
            ['label' => Yii::t('language', 'List of languages'), 'url' => ['/translatemanager/language/list']],
            ['label' => Yii::t('language', 'Create'), 'url' => ['/translatemanager/language/create']],
        ]
    ],
    ['label' => Yii::t('language', 'Scan'), 'url' => ['/translatemanager/language/scan']],
    ['label' => Yii::t('language', 'Optimize'), 'url' => ['/translatemanager/language/optimizer']],
    ['label' => Yii::t('language', 'Im-/Export'), 'items' => [
        ['label' => Yii::t('language', 'Import'), 'url' => ['/translatemanager/language/import']],
        ['label' => Yii::t('language', 'Export'), 'url' => ['/translatemanager/language/export']],
    ]
];
```

###Console commands

Register the command

```php
'controllerMap' => [
    'translate' => \nhockizi\translatemanager\commands\TranslatemanagerController::className()
],
```

Use it with the Yii CLI

```
./yii translate/scan
./yii translate/optimize
```

###Using google translate api

Google translate api is a paid service. At the moment of writing the price is $20 USD per 1 million characters trsanslated.

In order to activate the feature you need to have Google account, generate google Api Key, and enable this feature
by adding 'googleApiKey' to 'translatemanager' module configuration: 

```php

'modules' => [

    'translatemanager' => [
    
        // ...
        
        'googleApiKey' => `Your_Google_API_Key',
     ],
],
```
Once feature is enabled it will insert google translation of the source into the empty translation field 
(instead of original text) when you click on source field.


Known issues
-----------

* Scanner is scanning parent root directory [#12](https://github.com/nhockizi/yii2-translate-manager/pull/12).

  You can overwrite this behavior with the `scanRootParentDirectory` option. (See Config section for details.)
* Frontend translation of strings in hidden tags corrupts HTML. [#45](https://github.com/nhockizi/yii2-translate-manager/issues/45)

Screenshots
-----------

###List of languages
![translate-manager-0 2-screen-1](https://res.cloudinary.com/nhockizi/image/upload/v1421343987/admin-languages_ikxjqz.png)


###Scanning project
![translate-manager-0 2-screen-2](https://res.cloudinary.com/nhockizi/image/upload/v1424605567/admin-scan-2_lig4wn.png)


###Optimise database
![translate-manager-0 2-screen-3](https://res.cloudinary.com/nhockizi/image/upload/v1424606158/admin-optimise-2_nf6u3t.png)


###Translate on the admin interface
![translate-manager-0 2-screen-4](https://res.cloudinary.com/nhockizi/image/upload/v1421382395/admin-translation_p9uavl.png)


###Front end in translating mode
![translate-manager-0 2-screen-6](https://res.cloudinary.com/nhockizi/image/upload/v1421343986/frontend-translation-toggle_fsqflh.png)


###Translate on the front end
![translate-manager-0 2-screen-7](https://res.cloudinary.com/nhockizi/image/upload/v1421343987/frontend-translation-dialog_jivgkh.png)


Links
-----

- [GitHub](https://github.com/nhockizi/yii2-translate-manager)
- [Api Docs](http://nhockizi.github.io/yii2-translate-manager)
- [Packagist](https://packagist.org/packages/nhockizi/yii2-translate-manager)
- [Yii Extensions](http://www.yiiframework.com/extension/yii2-translate-manager)
