<?php
namespace backend\controllers;

use yii;
use backend\components\BaseController;
use common\models\OptionGeneralForm;

class OptionController extends BaseController{

    public function actionIndex(){

        $model=new OptionGeneralForm();
        if(yii::$app->request->isPost){
            if($model->load(yii::$app->request->post())&&$model->saveForm()){
                $this->refresh();
            }
        }

        return $this->render('index',['model'=>$model]);
    }

}