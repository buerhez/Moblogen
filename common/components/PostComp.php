<?php

namespace common\components;

use yii;
use common\models\Content;
use common\models\Relationship;

class PostComp extends BaseComp{


    /**
     * Get a list of articles
     * @param $offset
     * @param $limit
     * @param bool $isAllStatus All filtered by default, if false filters only articles in publishing status
     * @return array|yii\db\ActiveRecord[]
     */
    public function getPostList($offset,$limit,$isAllStatus=true,$withBodyContent=false){

        $whereArr=['type'=>Content::TYPE_POST];
        if(!$isAllStatus){
            $whereArr['status']=Content::STATUS_PUBLISH;
        }
        $select='cid,title,authorId,created,status,commentsNum';
        if($withBodyContent){
            $select.=',text';
        }
        return Content::find()->select($select)->where($whereArr)->orderBy('cid desc')->offset($offset)->limit($limit)->asArray()->all();
    }

    /**
     * Number of statistical articles
     * @param bool $isAllStatus All filtered by default, if false filters only articles in publishing status
     * @return int
     */
    public function getPostCount($isAllStatus=true){
        $whereArr=['type'=>Content::TYPE_POST];
        if(!$isAllStatus){
            $whereArr['status']=Content::STATUS_PUBLISH;
        }
        return Content::find()->where($whereArr)->count();
    }


    public function getPostCategoryName($cid){
        $categoryList=CategoryComp::getInstance()->getCategoryWithPostId($cid);
        $nameList=yii\helpers\ArrayHelper::getColumn($categoryList,'name');
        return join('&nbsp;&nbsp;',$nameList);
    }

    public function deletePost($cid){

        $model=Content::findOne(['cid'=>$cid,'type'=>Content::TYPE_POST]);
        if(!$model){
            return false;
        }
        //Delete the article's associated classification and tag
        CategoryComp::getInstance()->delCategoryWithPostId($cid);
        TagComp::getInstance()->delTagsWithPostId($cid);
        //Delete the article's associated classification and tag
        MediaComp::getInstance()->delMediaWithPostId($cid);
        return $model->delete();
    }
public function recentPublishedPost($limit){
        return $this->getPostList(0,$limit,false);
    }

    public function getPostByCategory($mid,$offset,$limit){

        $tablePrefix=Yii::$app->db->tablePrefix;


        $children=CategoryComp::getInstance()->getChildren($mid);


        if(empty($children)){
            return [];
        }
        $children=yii\helpers\ArrayHelper::getColumn($children,'mid');
        $list=(new yii\db\Query())
            ->select('c.cid,c.title,c.authorId,c.created,c.status,c.commentsNum,c.text')
            ->from($tablePrefix.'contents c')
            ->leftJoin($tablePrefix.'relationships r','c.cid = r.cid')
            ->where([
                'r.mid'=>$children,
                'c.type'=>Content::TYPE_POST,
                'c.status'=>Content::STATUS_PUBLISH
            ])
            ->groupBy('c.cid')
            ->orderBy('c.cid desc')
            ->offset($offset)
            ->limit($limit)
            ->all();

        return $list;

    }
    public function getPostCountByCategory($mid){
        $tablePrefix=Yii::$app->db->tablePrefix;
        $children=CategoryComp::getInstance()->getChildren($mid);

        if(empty($children)){
            return 0;
        }
        $children=yii\helpers\ArrayHelper::getColumn($children,'mid');

        return (new yii\db\Query())
            ->select('r.cid as rcid')
            ->from($tablePrefix.'contents c')
            ->leftJoin($tablePrefix.'relationships r','c.cid = r.cid')
            ->where([
                'r.mid'=>$children,
                'c.type'=>Content::TYPE_POST,
                'c.status'=>Content::STATUS_PUBLISH
            ])
            ->groupBy('c.cid')
            ->count();
    }


}