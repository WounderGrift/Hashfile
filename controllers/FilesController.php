<?php

namespace app\controllers;

use app\models\Files;
use yii\filters\Cors;
use yii\helpers\Json;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class FilesController extends Controller
{
    public function behaviors()
    {
        return [
            'corsFilter' => [
                'class' => Cors::class,
            ],
        ];
    }

    public function beforeAction($action)
    {
        return parent::beforeAction($action);
    }

    public function actionUpload()
    {
        $request   = \Yii::$app->request->bodyParams;
        if (!$request['content'])
            throw new ForbiddenHttpException('Failed to create hash from content');

        $hash      = hash_file('sha256', $request['content']);
        $fileModel = Files::find()->where(['hash' => $hash])->limit(1)->one();

        $info = 'файл существует';
        if (!$fileModel)
        {
            $fileModel = new Files();
            $date      = (new \DateTime())->format('Y-m-d H:i:s');
            $fileModel->setAttributes(array_merge($request, [
                'hash'        => $hash,
                'date_create' => $date
            ]));

            if (!$fileModel->validate())
                throw new ForbiddenHttpException($fileModel->errors);

            $fileContent = file_get_contents($request['content']);
            if (!$fileContent)
                throw new ForbiddenHttpException('Failed to read file content');

            $fileModel->content = $fileContent;
            $fileModel->save();

            $info = 'файл создан';
        }

        return Json::encode([
            'name'        => $fileModel->name,
            'description' => $fileModel->description,
            'type'        => $fileModel->type,
            'size'        => $fileModel->size,
            'date_create' => $fileModel->date_create,
            'info'        => $info
        ]);
    }
}