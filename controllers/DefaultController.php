<?php

namespace yeesoft\menu\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yeesoft\models\Menu;
use yeesoft\models\MenuLink;
use yeesoft\controllers\CrudController;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class DefaultController extends CrudController
{

    public $modelClass = 'yeesoft\models\Menu';
    public $disabledActions = ['view', 'bulk-activate', 'bulk-deactivate', 'toggle-attribute'];

    public function behaviors()
    {
        return ArrayHelper::merge(parent::behaviors(), [
                    'verbs' => [
                        'class' => VerbFilter::className(),
                        'actions' => [
                            'save-orders' => ['post'],
                        ],
                    ],
        ]);
    }

    protected function getRedirectPage($action, $model = null)
    {
        switch ($action) {
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

    /**
     * Lists all models.
     * 
     * @return mixed
     */
    public function actionIndex()
    {
        $menus = Menu::find()->indexBy('id')->indexBy('id')->all();
        $menuId = Yii::$app->request->get('menu_id', ArrayHelper::getValue(array_keys($menus), 0));

        $links = MenuLink::find()
                ->joinWith('translations')
                ->andWhere(['menu_id' => $menuId])
                ->andWhere(['parent_id' => null])
                ->orderBy('order')
                ->all();

        return $this->renderIsAjax('index', compact('menuId', 'menus', 'links'));
    }

    public function actionSaveOrders()
    {
        if (Yii::$app->getRequest()->isAjax) {
            $n = 1;
            $params = [];
            $select = [];
            $db = Yii::$app->db;
            $orders = Yii::$app->getRequest()->post('orders');

            foreach ($orders as $order) {
                $order = (object) $order;
                $select[] = "SELECT :id_{$n} as 'id', :order_{$n} as 'order', :parent_{$n} as 'parent_id'";
                $params[":id_{$n}"] = $order->id;
                $params[":order_{$n}"] = (int) $order->order;
                $params[":parent_{$n}"] = (!empty($order->parent)) ? $order->parent : null;
                $n++;
            }

            $linkTable = MenuLink::tableName();
            $db->createCommand("UPDATE {$linkTable} m INNER JOIN (" . implode(' UNION ', $select) . ") t ON m.id=t.id SET m.order=t.order, m.parent_id=t.parent_id", $params)->execute();
        }

        return false;
    }

}
