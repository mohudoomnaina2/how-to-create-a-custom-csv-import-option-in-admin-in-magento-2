<?php
namespace WonderAndInstaSoft\CustomImportCategory\Block\Adminhtml\ImportCategory;

use Magento\Backend\Block\Template\Context;
use Magento\Framework\Registry;
use Magento\Framework\Data\FormFactory;
use Magento\Framework\View\Asset\Repository;
use Magento\Backend\Block\Widget\Form\Generic;
use Magento\Backend\Block\Widget\Button;
use Magento\Framework\App\Request\Http;

class ImportCategoryForm extends Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    protected $_assetRepo;
    protected $request;

    public function __construct(
        Context $context,
        Registry $registry,
        FormFactory $formFactory,
        Repository $assetRepo,
        Http $request,
        array $data = []
    ) {
        $this->_assetRepo = $assetRepo;
        $this->request = $request;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $this->getToolbar()->addChild(
            'update_status',
            Button::class,
            [
                'label' => __('Back'),
                'onclick' => "setLocation('" . $this->_urlBuilder->getUrl('*/*/index') . "')",
                'class' => 'back',
            ]
        );

        $this->getToolbar()->addChild(
            'save_category',
            Button::class,
            [
                'label' => __('Save Import Category'),
                'onclick' => 'document.getElementById("import_category_form").submit();', // Use submit instead of click
                'class' => 'action-scalable primary',
                'type' => 'button',
            ]
        );

        return $this;
    }

    protected function _prepareForm()
    {
        $form = $this->_formFactory->create(['data' => ['id' => 'import_category_form','action' => $this->getUrl('*/*/saveImportCategory'),'method' => 'post','enctype' => 'multipart/form-data',],]);
        $fieldset = $form->addFieldset(
            'base_fieldset',
            [
                'legend' => __('Import Category CSV'),
                'class'  => 'fieldset-wide'
            ]
        );

        $importDataField = $fieldset->addField(
            'file',
            'file',
            [
                'name'  => 'file',
                'label' => __('Upload CSV File'),
                'title' => __('Upload CSV File'),
                'required' => true,
            ]
        );

        //Sample CSV File[File Path: app/code/WonderAndInstaSoft/CustomImportCategory/view/adminhtml/web/ImportCategorySampleCsvFile/ImportCategorySampleCsvFile.csv]
        $path = $this->_assetRepo->getUrl("WonderAndInstaSoft_CustomImportCategory::ImportCategorySampleCsvFile/ImportCategorySampleCsvFile.csv");
        
        $importDataField->setAfterElementHtml("
           <span id='sample-file-span'><a id='sample-file-link' href='" . $path . "' >Download Sample CSV File</a></span>
           <br><br>
           <b style='color:red;' id='sample-file-span'>Note: In the CSV data, there must be only 500 data or row(s) in a single upload.</b>
       ");

        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }

    public function getTabLabel()
    {
        return __('Category CSV');
    }

    public function getTabTitle()
    {
        return $this->getTabLabel();
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }
}
