<?php
namespace WonderAndInstaSoft\CustomImportCategory\Model\ResourceModel\ImportCategory;
 
class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('WonderAndInstaSoft\CustomImportCategory\Model\ImportCategory', 'WonderAndInstaSoft\CustomImportCategory\Model\ResourceModel\ImportCategory');
    }
}