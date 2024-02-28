<?php
namespace WonderAndInstaSoft\CustomImportCategory\Model;
 
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;
class ImportCategory extends AbstractModel
{
    protected function _construct()
    {
        $this->_init('WonderAndInstaSoft\CustomImportCategory\Model\ResourceModel\ImportCategory');
    }
}