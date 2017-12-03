<?php

namespace yeesoft\menu\controllers;

use yeesoft\controllers\CrudController;

/**
 * LinkController implements the CRUD actions for Post model.
 */
class LinkController extends CrudController
{
    public $modelClass = 'yeesoft\models\MenuLink';
    public $enableOnlyActions = ['delete', 'update', 'create'];

    protected function getRedirectPage($action, $model = null)
    {
        switch ($action) {
            case 'delete':
                return ['default/index', 'menu_id' => $model->menu_id];
                break;
            case 'update':
                return ['update', 'id' => $model->id];
                break;
            case 'create':
                return ['update', 'id' => $model->id];
                break;
            default:
                return parent::getRedirectPage($action, $model);
        }
    }
}