<?php
namespace WonderAndInstaSoft\CustomImportCategory\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ImportCategory extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('importcategory', 'id'); // 'importcategory' is the main table name, 'id' is the primary key field
    }
}