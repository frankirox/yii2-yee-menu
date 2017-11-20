<?php

use yeesoft\helpers\Html;
use yeesoft\helpers\FA;

/* @var $this \yii\web\View */
/* @var $link \yeesoft\models\MenuLink */
?>

<ul class="menu-list" data-parent-id="<?= isset($parentId) ? $parentId : '' ?>">
    <?php foreach ($links as $link) : ?>
        <li class="menu-link">
            <div data-link-id="<?= $link->id ?>">

                <?php if (!empty($link->image)): ?>
                    <div class="pull-left" style="padding: 7px 15px 0 0;">
                        <?= FA::icon($link->image)->size(FA::SIZE_LARGE)->fixedWidth() ?>
                    </div>
                <?php endif; ?>

                <div class="pull-left">
                    <b><?= $link->label ?></b><br>
                    <span class="url"><?= (empty($link->link) ? "(no link)" : "[{$link->link}]") ?></span>
                </div>
                <div class="actions">
                    <?= Html::a('[' . Yii::t('yee', 'Update') . ']', ['link/update', 'id' => $link->id], ['data-pjax' => 0]) ?>
                    <?=
                    Html::a('[' . Yii::t('yee', 'Delete') . ']', ['link/delete', 'id' => $link->id], [
                        'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                        'data-method' => 'post',
                        'data-pjax' => '0',
                    ])
                    ?>
                </div>
            </div>

            <?= $this->render('_link', ['links' => $link->getChildren(), 'parentId' => $link->id]) ?>
        </li>
    <?php endforeach; ?>
</ul>