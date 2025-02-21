<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Popup $model */

$this->title = 'Create Popup';
$this->params['breadcrumbs'][] = ['label' => 'Popups', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="popup-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
