<?php
namespace app\base\components;


use yii\base\Component;
use yii\base\Model;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\helpers\StringHelper;
use yii\web\UploadedFile;

class FileComponent extends Component
{
    public $directory;

    private function getFileName(UploadedFile $file)
    {
        return Html::encode($file->baseName) . "_" . uniqid() . "." . $file->getExtension();
    }

    private function getFilePath(UploadedFile $file)
    {
        $dir = \Yii::getAlias('@webroot') . "/" . $this->directory;
        FileHelper::createDirectory($dir);

        return $dir . '/' . $this->getFileName($file);
    }

    /**
     * @param $model Model
     * @param $attribute string
     * @return UploadedFile|null
     */
    private function getUploadedFile($model, $attribute)
    {
        return UploadedFile::getInstance($model, $attribute);
    }

    /**
     * @param $model Model
     * @param $attribute string
     * @return UploadedFile[]|null
     */
    private function getUploadedFiles($model, $attribute)
    {
        return UploadedFile::getInstances($model, $attribute);
    }

    private function saveUploadedFile(UploadedFile $file, &$fileName)
    {
        $fileName = $this->getFilePath($file);
        return $file->saveAs($fileName);
    }

    /**
     * @param $model Model
     * @param $attribute string
     * @return void
     */
    public function saveFiles(&$model, $attribute)
    {
        $arFiles = array();
        $model->$attribute = $this->getUploadedFiles($model, $attribute);

        if($model->validate([$attribute])) {
            foreach ($model->$attribute as $code => $file) {
                /**
                 * @var $file UploadedFile
                 */
                $res = $this->saveUploadedFile($file, $fileName);
                if($res) {
                    $arFiles[] = $fileName;
                } else {
                    $model->addError($attribute, 'Не удалось загрузить файл ' . $file->getBaseName());
                }
            }
            $model->setAttributes(array($attribute => $arFiles));
        }
    }


    /**
     * @param $model Model
     * @param $attribute string
     * @return array|bool
     */
    public function saveFile(&$model, $attribute)
    {
        $arFiles = array();
        $model->$attribute = $this->getUploadedFiles($model, $attribute);

        if($model->validate([$attribute])) {
            $file = $model->$attribute;
            /**
             * @var $file UploadedFile
             */
            $res = $this->saveUploadedFile($file);
            if($res) {
                $arFiles[] = $this->getFilePath($file);
            } else {
                $model->addError($attribute, 'Не удалось загрузить файл ' . $file->getBaseName());
            }
        }
        $model->setAttributes(array($attribute => $arFiles));
        return false;
    }
}