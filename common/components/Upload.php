<?php
namespace common\components;
use yii;
use yii\web\UploadedFile;
use common\helpers\FileHelper;

/**
 * Class Upload
 * @property string fileMimeType
 * @property string fileExt
 * @property string newFileName
 * @property string originalFileName
 * @property integer filesize
 * @property string saveRelativePath
 * @package app\components
 */
class Upload extends yii\base\Object{

    public $allowExt=['jpg','png','jpeg','bmp','gif'];

//default 10Mb
    public $allowMaxSize=10485760;

//file input name
    public $fileInputName='file';

//path alias
    public $savePath='@webroot/upload';

    public $error;

    public $fileMimeType;

    /**
     * @var UploadedFile
     */
    private $_uploadFile;

    private $_newFileName;

    private $_saveRelativePath;


    public function init(){
        if(!$this->fileInputName){
            throw new yii\base\InvalidConfigException('fileInputNameproperty must be set');
        }
        if(!file_exists(Yii::getAlias($this->savePath))){
            throw new yii\base\InvalidConfigException('Save directory does not exist');
        }

        $this->_uploadFile=UploadedFile::getInstanceByName($this->fileInputName);

        if($this->_uploadFile){
            $this->fileMimeType=FileHelper::getMimeType($this->_uploadFile->tempName);
        }else{
            $this->error='No files uploaded';
        }

    }

    public function checkFileInfoAndSave(){

        if($this->error!=UPLOAD_ERR_OK){
            return false;
        }

        if(!$this->checkExt()||!$this->checkMimeType()){
            $this->error='Impermissible File Types';
            return false;
        }
        if(!$this->checkMaxSize()){
            $this->error='Size over limit';
            return false;
        }

        $result=$this->_uploadFile->saveAs(Yii::getAlias($this->savePath.'/'.$this->getSaveRelativePath()));
        $this->error=$this->_uploadFile->error;
        if($result){
            return true;
        }else{
            return false;
        }

    }

    private function checkExt(){
        return in_array(mb_strtolower($this->fileExt,'utf-8'),$this->allowExt);

    }

    private function checkMimeType(){

        $allowMimeType=[];
        foreach($this->allowExt as $v){
            $allowMimeType[]=FileHelper::getMimeTypeByExt($v);
        }
        return in_array($this->fileMimeType,$allowMimeType);
    }

    private function checkMaxSize(){
        return $this->allowMaxSize>=$this->filesize;
    }

    public function getFileExt(){
        if($this->_uploadFile){
            return $this->_uploadFile->getExtension();
        }
        return null;
    }

    public function getNewFileName(){
        if(!$this->_newFileName){
            $this->_newFileName=Yii::$app->security->generateRandomString().'.'.$this->_uploadFile->getExtension();
        }

        return $this->_newFileName;

    }

    public function getOriginalFileName(){
        if($this->_uploadFile){
            return $this->_uploadFile->name;
        }
        return null;
    }

    public function getFilesize(){
        if($this->_uploadFile){
            return $this->_uploadFile->size;
        }
        return null;
    }

    public function getSaveRelativePath(){
        if(!$this->_saveRelativePath){
            $subDir=date('Ym/');
            if(!file_exists(Yii::getAlias($this->savePath.$subDir))){
                FileHelper::createDirectory(Yii::getAlias($this->savePath.$subDir));
            }
            $this->_saveRelativePath= $subDir.$this->newFileName;

        }
        return $this->_saveRelativePath;

    }


}