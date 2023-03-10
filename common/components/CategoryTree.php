<?php

namespace common\components;

use common\models\Category;
use yii;
class CategoryTree extends yii\base\Object{


    private $_allCategories=[];

    private $_parentCategoryIds=[];

    private $_childCategoryIds=[];


    protected  static $_instance;

    /**
     * @return self
     */
    public static function getInstance()
    {
        $class=get_called_class();

        if(!isset(self::$_instance[$class]))
        {

            self::$_instance[$class] = new $class;
        }
        return self::$_instance[$class];

    }


    public  function __construct(){
        parent::__construct();

        $allCategories=Category::find()->asArray()->all();

        //Circular acquisition hierarchy relation
        foreach($allCategories as $v){

            $this->_allCategories[$v['mid']]=$v;//the id as key

            if(!array_key_exists($v['mid'],$this->_childCategoryIds)){
                $this->_childCategoryIds[$v['mid']]=[];
            }
            $this->_childCategoryIds[$v['parent']][]=$v['mid'];
            $this->_parentCategoryIds[$v['mid']]=$v['parent'];

        }


    }


    public function getAllCategories(){
        $list=[];
        if(!empty($this->_childCategoryIds)){
            foreach($this->_childCategoryIds[0] as $v){
                $list=array_merge($list,$this->getChildCategories($v));
            }
        }
        return $list;

    }

    public function getChildCategories($parent,$depth=1){
        $parent=intval($parent);
        if($parent!=0&&!$this->isCategoryExist($parent)){
            return [];
        }

        $cate=$this->_allCategories[$parent];
        $cate['depth']=$depth;
        $list[]=$cate;

        foreach($this->_childCategoryIds[$parent] as $v){
            $list=array_merge($list,$this->getChildCategories($v,$depth+1));
        }
        return $list;
    }


    //Gets All Parent Classes
    public function getParentCategories($child){

        $child=intval($child);
        if($child!=0&&!$this->isCategoryExist($child)){
            return [];
        }
        $parent=array_key_exists($child,$this->_parentCategoryIds)?$this->_parentCategoryIds[$child]:0;
        $list=[];
        while($parent>0){
            $list[]=$this->isCategoryExist($parent)?$this->_allCategories[$parent]:[];
            $parent=array_key_exists($parent,$this->_parentCategoryIds)?$this->_parentCategoryIds[$parent]:0;
        }

        return $list;
    }

    //Get Parent Class
    public function getParentCategory($child){
        $parent=array_key_exists($child,$this->_parentCategoryIds)?$this->_parentCategoryIds[$child]:0;
        if($parent>0){
            return $this->isCategoryExist($parent)?$this->_allCategories[$parent]:null;
        }else{
            return null;
        }
    }

    /**
     * ??????id????????????????????????
     * @param string $id ??????id
     * @return bool
     */
    public function isCategoryExist($id){

        return array_key_exists($id,$this->_allCategories);

    }

    /**
     * ?????????????????????
     * @param $parent
     * @return array
     */
    public function getSubCategories($parent){
        $parent=intval($parent);
        if($parent!=0&&!$this->isCategoryExist($parent)){
            return [];
        }
        $list=[];
        if(!empty($this->_childCategoryIds)){
            foreach($this->_childCategoryIds[$parent] as $v){
                $list[$v]=$this->_allCategories[$v];
            }
        }
        return $list;

    }

    //Number of direct sub-classifications
    public function getSubCategoriesCount($parent){
        $parent=intval($parent);
        if($parent!=0&&!$this->isCategoryExist($parent)){
            return 0;
        }
        return count($this->_childCategoryIds[$parent]);
    }
}