<?php
namespace WonderAndInstaSoft\CustomImportCategory\Controller\Adminhtml\ImportCategory;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;
use Magento\Framework\Message\ManagerInterface;
use WonderAndInstaSoft\CustomImportCategory\Model\ResourceModel\ImportCategory\Collection as CollectionFactory;

class MassDelete extends Action
{
    protected $filter;
    protected $collectionFactory;

    public function __construct(
        Context $context,
        Filter $filter,
        ManagerInterface $messageManager,
        CollectionFactory $collectionFactory
    ) {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        $this->messageManager = $messageManager;
        parent::__construct($context);
    }

    public function execute()
    {
        $selected = $this->getRequest()->getParam('id');
        if (!empty($selected)) {
            try {
                //$collection = $this->collectionFactory->create();
                $collection = $this->collectionFactory;
                $collection->addFieldToFilter('id', ['in' => $selected]);
                $collectionSize = $collection->getSize();
                
                foreach ($collection->getItems() as $item) {
                    $item->delete();
                }
                
                $this->messageManager->addSuccess(__('A total of %1 record(s) have been deleted.', $collectionSize));
                // $this->messageManager->addSuccessMessage(__('Selected items have been deleted.'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('An error occurred while deleting the items.'));
            }
        } else {
            $this->messageManager->addErrorMessage(__('Please select item(s) to delete.'));
        }

        return $this->_redirect('*/*/index');
    }

    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('WonderAndInstaSoft_CustomImportCategory::import_category_sub');
    }
}
