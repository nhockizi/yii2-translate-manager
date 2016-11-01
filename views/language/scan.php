<?php
$this->title = Yii::t('language', 'Scanning project');
$this->params['breadcrumbs'][] = ['label' => Yii::t('language', 'Languages'), 'url' => ['list']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div id="w2-info" class="alert-info alert fade in">
<?= Yii::t('language', '{n, plural, =0{No new entries} =1{One new entry} other{# new entries}} were added!', ['n' => $newDataProvider->totalCount])?>
</div>

<?= $this->render('__scanNew', [
    'newDataProvider' => $newDataProvider
])?>

<div id="w2-danger" class="alert-danger alert fade in">
<?= Yii::t('language', '{n, plural, =0{No entries} =1{One entry} other{# entries}} remove!', ['n' => $oldDataProvider->totalCount])?>
</div>

<?= $this->render('__scanOld', [
    'oldDataProvider' => $oldDataProvider
])?>