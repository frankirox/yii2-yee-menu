<?php

use yeesoft\helpers\Html;
use yeesoft\menu\assets\MenuAsset;

/* @var $this yii\web\View */
/* @var $menu \yeesoft\models\Menu */

$this->title = Yii::t('yee/menu', 'Menus');
$this->params['breadcrumbs'][] = $this->title;

$this->params['description'] = 'YeeCMS 0.2.0';
$this->params['header-content'] = Html::a(Yii::t('yee/menu', 'Add New Menu'), ['create'], ['class' => 'btn btn-sm btn-primary']);

//Yii::t('yee/menu', 'An error occurred during saving menu!') 
//Yii::t('yee/menu', 'The changes have been saved.') 


MenuAsset::register($this);
?>

<div class="row menu-page">
    <div class="col-sm-4">
        <div class="box box-primary">
            <div class="box-body">
                <ul class="nav nav-pills nav-stacked menu-nav">
                    <?php foreach ($menus as $id => $menu) : ?>
                        <li class="clearfix <?= ($menuId === $id) ? 'active' : '' ?>">
                            <?= Html::a($menu->title, ['index', 'menu_id' => $menu->id]) ?>
                            <div class="actions">
                                <?= Html::a('[' . Yii::t('yee', 'Update') . ']', ['update', 'id' => $menu->id]) ?>
                                <?=
                                Html::a('[' . Yii::t('yee', 'Delete') . ']', ['delete', 'id' => $menu->id], [
                                    'data-confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
                                    'data-method' => 'post',
                                    'data-pjax' => '0',
                                ])
                                ?>
                            </div>
                        </li>
                    <?php endforeach;
                    ?>
                </ul>
            </div>
        </div>
    </div>

    <div class="col-sm-8">
        <div class="box box-primary">
            <div class="box-body">
                <div class="text-right">
                    <?php if ($menuId): ?>
                        <?= Html::a(Yii::t('yee/menu', 'Add New Link'), ['link/create', 'menu_id' => $menuId], ['class' => 'btn btn-sm btn-primary']) ?>
                    <?php endif; ?>
                </div>

                <div class="menu-box">
                    <?php if (!empty($links)): ?>
                        <?= $this->render('_link', compact('links')) ?>
                    <?php else: ?>
                        <?= Yii::t('yee/menu', 'No menu links have been created yet.') ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

</div>