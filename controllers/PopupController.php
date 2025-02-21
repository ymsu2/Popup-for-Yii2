<?php

namespace app\controllers;

use app\models\Popup;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PopupController implements the CRUD actions for Popup model.
 */
class PopupController extends Controller
{
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Popup::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);

        $models = Popup::find()->all();
        return $this->render('index', ['models' => $models]);
    }

    public function actionCreate()
    {
        $model = new Popup();

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            $this->generateScript($model);
            return $this->redirect(['index']);
        }

        return $this->render('create', ['model' => $model]);
    }

    private function generateScript($model)
    {
        $js = <<<JS
document.addEventListener('DOMContentLoaded', function() {
    setTimeout(function() {
        fetch('/popup/get-config?id={$model->id}')
            .then(response => response.json())
            .then(data => {
                if(data.is_active) {
                    // Create modal logic here
                    const modal = document.getElementById('my-modal-popup');
                    if (modal) {
                       // Открыть модальное окно
                       $('#my-modal-popup').modal('show');
                    } else {
                      console.error('Элемент с id "my-modal-popup" не найден!');
                    }                     
                    incrementCounter({$model->id});
                }
            });
    }, {$model->show_after} * 1000);
});

function incrementCounter(popupId) {
    fetch('/popup/increment-counter?id=' + popupId);
}
JS;

        file_put_contents(\Yii::getAlias($_SERVER['DOCUMENT_ROOT'].'/web/js/popup-'.$model->id.'.js'), $js);
    }

    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    /**
     * Displays a single Popup model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Updates an existing Popup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Popup model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Popup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Popup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Popup::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionGetConfig($id)
    {
    \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
    $model = $this->findModel($id);
    return [
        'is_active' => $model->is_active,
        'title' => $model->title,
        'content' => $model->content,
        'width' => $model->width,
        'height' => $model->height
    ];
   }

   public function actionIncrementCounter($id)
   {
    $model = $this->findModel($id);
    $model->updateCounters(['display_count' => 1]);
   }

}
