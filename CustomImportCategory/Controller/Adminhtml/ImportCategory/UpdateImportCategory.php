<?php
namespace WonderAndInstaSoft\CustomImportCategory\Controller\Adminhtml\ImportCategory;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use WonderAndInstaSoft\CustomImportCategory\Model\ResourceModel\ImportCategory\Collection as ImportCategoryCollection;

class UpdateImportCategory extends Action
{
    protected $resultPageFactory;
    protected $importCategoryCollection;

    public function __construct(
        Context $context,
        PageFactory $resultPageFactory,
        ImportCategoryCollection $importCategoryCollection
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->importCategoryCollection = $importCategoryCollection;
    }

    public function execute()
    {
        $resource = $this->_objectManager->get('Magento\Framework\App\ResourceConnection');
        $connection = $resource->getConnection();
        $date=date("Y-m-d");
        $sql="SELECT * FROM importcategory WHERE status='0' and date='$date'";
        $res = $connection->fetchAll($sql);
       // print_r($res);
       // exit;
        
        if(count($res)>0){
        foreach($res as $value){
            $auto_id=$value['id']; 
          // $barcode=preg_replace('/[\x00-\x1F\x80-\xFF]/','',$value->barcode); 
            $articlecode=preg_replace('/[\x00-\x1F\x80-\xFF]/','',$value['articlecode']); 
            $category_1=$value['category_1'];
            $category_2=$value['category_2'];
            $category_3=$value['category_3'];
            $category_4=$value['category_4'];
            $sku=$connection->fetchAll("SELECT entity_id FROM catalog_product_entity WHERE sku='$articlecode' order by entity_id desc");
            if(count($sku) > 0) {
            foreach($sku as $sku1) {   
             $cat_array=array();      
            $entity_id=$sku1->entity_id;    
            
            $category=$connection->fetchAll("SELECT catalog_category_entity.entity_id as cat_id  FROM `catalog_category_entity_varchar` INNER JOIN catalog_category_entity ON catalog_category_entity_varchar.entity_id=catalog_category_entity.entity_id WHERE catalog_category_entity_varchar.attribute_id='45' and catalog_category_entity_varchar.store_id='0' and catalog_category_entity_varchar.value='$category_1' and catalog_category_entity.level='2'");
            $check=true;
            if(count($category)>0){
                $category_id=$category[0]['cat_id'];  
                $check=true;
                array_push($cat_array,$category_id);
            }else{
                $check=false;
            }
            
            if(!empty($category_2)){
             $category1=$connection->fetchAll("SELECT catalog_category_entity.entity_id as cat_id  FROM `catalog_category_entity_varchar` INNER JOIN catalog_category_entity ON catalog_category_entity_varchar.entity_id=catalog_category_entity.entity_id WHERE catalog_category_entity_varchar.attribute_id='45' and catalog_category_entity_varchar.store_id='0' and catalog_category_entity_varchar.value='$category_2' and catalog_category_entity.level='3'");
            $check1=true;
            if(count($category1)>0){
                $category_id=$category1[0]['cat_id']; 
                $check1=true;
                array_push($cat_array,$category_id);
            }else{
                $check1=false;
            }
            }else{
               $check1=false; 
            }
            
            if($check1==true){
             $category2=$connection->fetchAll("SELECT catalog_category_entity.entity_id as cat_id  FROM `catalog_category_entity_varchar` INNER JOIN catalog_category_entity ON catalog_category_entity_varchar.entity_id=catalog_category_entity.entity_id WHERE catalog_category_entity_varchar.attribute_id='45' and catalog_category_entity_varchar.store_id='0' and catalog_category_entity_varchar.value='$category_3' and catalog_category_entity.level='4'");
            $check2=true;
            if(count($category2)>0){
                $category_id=$category2[0]['cat_id']; 
                $check2=true;
                array_push($cat_array,$category_id);
            }else{
                $check2=false;
            }
            }else{
              $check2=false;  
            }
            
            if($check1==true && $check2==true){
             $category3=$connection->fetchAll("SELECT catalog_category_entity.entity_id as cat_id  FROM `catalog_category_entity_varchar` INNER JOIN catalog_category_entity ON catalog_category_entity_varchar.entity_id=catalog_category_entity.entity_id WHERE catalog_category_entity_varchar.attribute_id='45' and catalog_category_entity_varchar.store_id='0' and catalog_category_entity_varchar.value='$category_4' and catalog_category_entity.level='5'");
            $check3=true;
            if(count($category3)>0){
                $category_id=$category3[0]['cat_id'];
                $check3=true;
                array_push($cat_array,$category_id);
            }else{
                $check3=false;
            }
            }else{
               $check3=false; 
            }
if(($check==true && $check1==true && $check2==true && $check3==true) ||  ($check==true && $check1==true && $check2==true && $check3==false) || ($check==true && $check1==true && $check2==false && $check3==false) || ($check==true && $check1==false && $check2==false && $check3==false)){

$connection->query("DELETE FROM catalog_category_product WHERE product_id='$entity_id'");

$stores=$connection->fetchAll("SELECT * FROM store WHERE store_id!='0' and is_active='1'");
 
foreach($stores as $stores1){
$store_id=$stores1['store_id'];    
$catalog1='catalog_category_product_index_store'.$store_id;
$connection->query("DELETE FROM $catalog1 WHERE product_id='$entity_id'");
}
  
foreach($stores as $stores1){
$store_id=$stores1['store_id'];     
$catalog1='catalog_category_product_index_store'.$store_id;    
#store1    
$checkitem=$connection->fetchAll("SELECT * FROM $catalog1 WHERE category_id='2' and product_id='$entity_id' and store_id='$store_id'");
if(count($checkitem)==0){
$connection->query("INSERT INTO $catalog1(category_id,product_id,position,is_parent,store_id,visibility) VALUES('2','$entity_id','0','0','$store_id','4')");
}
}

foreach($cat_array as $cat){
#default    
$checkitemnumber=$connection->fetchAll("SELECT * FROM catalog_category_product WHERE category_id='$cat' and product_id='$entity_id'");
if(count($checkitemnumber)==0){
 $connection->query("INSERT INTO catalog_category_product(category_id,product_id) VALUES('$cat','$entity_id')");
}else{
$catup=$checkitemnumber[0]['category_id'];
$entity_idup=$checkitemnumber[0]['product_id'];

$connection->query("UPDATE catalog_category_product SET category_id='$catup',product_id='$entity_idup' WHERE category_id='$cat' and product_id='$entity_id'");   
}

foreach($stores as $stores1){
$store_id=$stores1['store_id'];    
$catalog1='catalog_category_product_index_store'.$store_id;
#store1    
$checkitemnumber1=$connection->fetchAll("SELECT * FROM $catalog1 WHERE category_id='$cat' and product_id='$entity_id' and store_id='$store_id'");
if(count($checkitemnumber1)==0){
$connection->query("INSERT INTO $catalog1(category_id,product_id,position,is_parent,store_id,visibility) VALUES('$cat','$entity_id','0','1','$store_id','4')");    
}else{
$catup=$checkitemnumber1[0]['category_id'];
$entity_idup=$checkitemnumber1[0]['product_id'];    

$connection->query("UPDATE $catalog1 SET category_id='$catup',product_id='$entity_idup' WHERE category_id='$cat' and product_id='$entity_id' and store_id='$store_id'");   

}
}
}

            $remarks="Product updated successfully.";
            $connection->query("UPDATE importcategory SET status='1',remarks='$remarks' WHERE id='$auto_id'"); 
             //$this->messageManager->addSuccessMessage(__($remarks));
            }else{
            $remarks="Category not matching";
            $connection->query("UPDATE importcategory SET status='2',remarks='$remarks' WHERE id='$auto_id'"); 
            //$this->messageManager->addErrorMessage(__($remarks));
            }
            unset($cat_array);
            }
            }else{
            $remarks="ArticleCode not matching";
            $connection->query("UPDATE importcategory SET status='2',remarks='$remarks' WHERE id='$auto_id'");   
             //$this->messageManager->addErrorMessage(__($remarks));
            }
        }
        $this->messageManager->addSuccessMessage(__("Updated successfully. Suppose If any category has not been updated, please check the remarks status."));
        }else{
            $this->messageManager->addErrorMessage(__("No records could be found."));
        }
        
        // Redirect to the form page
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*/index');

        return $resultRedirect;
    }
    
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('WonderAndInstaSoft_CustomImportCategory::import_category_sub');
    }
}
