<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Meta */

$this->title = 'Add a new category';
?>
<div class="meta-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
