<?php
namespace WonderAndInstaSoft\CustomImportCategory\Controller\Adminhtml\ImportCategory;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
class AddImportCategory extends Action
{
    protected $resultPageFactory;
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    )
    {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }
    public function execute()
    {
        // $this->_view->loadLayout();
        $resultPage = $this->resultPageFactory->create();
        
        // Set the active menu
        $resultPage->setActiveMenu('WonderAndInstaSoft_CustomImportCategory::import_category_sub');
        
        // Add breadcrumb
        $resultPage->addBreadcrumb(__('WonderAndInstaSoft Add Import Category'), __('WonderAndInstaSoft Add Import Category'));
        $resultPage->addBreadcrumb(__('WonderAndInstaSoft Manage Add Import Category'), __('WonderAndInstaSoft Manage Add Import Category'));
        
        //Set Page Title
        $resultPage->getConfig()->getTitle()->prepend(__('WonderAndInstaSoft Add Import Category'));
        
        //Set Block File Code to this page using php file way without xml file
        $this->_addContent($this->_view->getLayout()->createBlock('WonderAndInstaSoft\CustomImportCategory\Block\Adminhtml\ImportCategory\ImportCategoryForm'));
        
        return $resultPage;
        
        // $this->_view->renderLayout();
    }
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('WonderAndInstaSoft_CustomImportCategory::import_category_sub');
    }
}