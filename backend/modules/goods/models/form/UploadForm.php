<?php
namespace backend\modules\goods\models\form;

use yii\base\Model;
use yii\web\UploadedFile;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $file;

    public function rules()
    {
        return [
            [['file'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png,jpg,gif'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $name = 'uploads/' .time().rand(100,999). '.'. $this->file->extension;
            $this->file->saveAs($name);
            return $name;
        } else {
            return false;
        }
    }
}