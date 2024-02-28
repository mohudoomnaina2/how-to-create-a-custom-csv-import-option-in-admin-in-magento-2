<?php
namespace WonderAndInstaSoft\CustomImportCategory\Block\Adminhtml\ImportCategory;
use Magento\Backend\Block\Widget\Grid\Extended;
use Magento\Backend\Block\Template\Context;
use Magento\Backend\Helper\Data;
use Magento\Framework\Registry;
use Magento\Framework\ObjectManagerInterface;
use WonderAndInstaSoft\CustomImportCategory\Model\ResourceModel\ImportCategory\Collection as ImportCategoryCollection;
use WonderAndInstaSoft\CustomImportCategory\Block\Adminhtml\ImportCategory\StatusDataRenderer;

class Grid extends Extended
{
    protected $registry;
    protected $_objectManager = null;
    protected $demoFactory;
    public function __construct(
        Context $context,
        Data $backendHelper,
        Registry $registry,
        ObjectManagerInterface $objectManager,
        ImportCategoryCollection $demoFactory,
        array $data = []
    ) {
        $this->_objectManager = $objectManager;
        $this->registry = $registry;
        $this->demoFactory = $demoFactory;
        parent::__construct($context, $backendHelper, $data);
    }
    protected function _construct()
    {
        parent::_construct();
        $this->setId('index');
        $this->setDefaultSort('id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        // Add "Add New" button
        $this->getToolbar()->addChild(
            'update_status',
            'Magento\Backend\Block\Widget\Button',
            [
                'label' => __('Update'),
                'onclick' => "setLocation('" . $this->_urlBuilder->getUrl('*/*/UpdateImportCategory') . "')",
                'class' => 'action- scalable primary',
            ]
        );
        
        $this->getToolbar()->addChild(
            'add_new',
            'Magento\Backend\Block\Widget\Button',
            [
                'label' => __('Import Category'),
                'onclick' => "setLocation('" . $this->_urlBuilder->getUrl('*/*/AddImportCategory') . "')",
                'class' => 'action- scalable primary',
            ]
        );

        return $this;
    }
    protected function _prepareCollection()
    {
        $todayDate = date('Y-m-d');
        // $demo = $this->demoFactory->create();
        $demo = $this->demoFactory;
        $demo->addFieldToSelect('*');
        $demo->addFieldToFilter('id', array('neq' => ''));
        $demo->addFieldToFilter('date', ['eq' => $todayDate]);
        $this->setCollection($demo);
        return parent::_prepareCollection();
    }
    protected function _prepareColumns()
    {
        $this->addColumn(
            'id',
            [
                'header_css_class' => 'a-center',
                'type' => 'checkbox',
                'name' => 'id',
                'align' => 'center',
                'index' => 'id'
            ]
        );
        $this->addColumn(
            'id',
            [
                'header' => __('ID'),
                'type' => 'number',
                'index' => 'id',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        $this->addColumn(
            'articlecode',
            [
                'header' => __('Article Code'),
                'type' => 'text',
                'index' => 'articlecode',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        // $this->addColumn(
        //     'eancode',
        //     [
        //         'header' => __('EAN Code'),
        //         'type' => 'text',
        //         'index' => 'eancode',
        //         'header_css_class' => 'col-id',
        //         'column_css_class' => 'col-id',
        //     ]
        // );
        $this->addColumn(
            'category_1',
            [
                'header' => __('Category1'),
                'type' => 'text',
                'index' => 'category_1',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        $this->addColumn(
            'category_2',
            [
                'header' => __('Category2'),
                'type' => 'text',
                'index' => 'category_2',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        $this->addColumn(
            'category_3',
            [
                'header' => __('Category3'),
                'type' => 'text',
                'index' => 'category_3',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        $this->addColumn(
            'category_4',
            [
                'header' => __('Category4'),
                'type' => 'text',
                'index' => 'category_4',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        $this->addColumn(
            'status',
            [
                'header' => __('Status'),
                'index' => 'status',
                'type' => 'int',
                'renderer' => StatusDataRenderer::class, // Use the custom data value renderer
                'filter_condition_callback' => [$this, '_filterStatusCondition'], // Add this line
            ]
        );
        $this->addColumn(
            'remarks',
            [
                'header' => __('Remarks'),
                'type' => 'text',
                'index' => 'remarks',
                'header_css_class' => 'col-id',
                'column_css_class' => 'col-id',
            ]
        );
        $this->addColumn(
            'date',
            [
                'header' => __('Date'),
                'index' => 'date',
                'type' => 'date',
            ]
        );
        
        $this->addColumn(
            'action',
            [
                'header' => __('Action'),
                'width' => '100px',
                'type' => 'action',
                'getter' => 'getId',
                'actions' => [
                    [
                        'caption' => __('Delete'),
                        'url' => ['base' => '*/*/massDelete'],
                        'field' => 'id',
                        'confirm' => __('Are you sure you want to delete selected items?')
                    ]
                ],
                'filter' => false,
                'sortable' => false,
                'index' => 'id',
                'is_system' => true
            ]
        );
        
        return parent::_prepareColumns();
    }
    
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('id');

        $this->getMassactionBlock()->addItem(
            'delete',
            [
                'label' => __('Delete'),
                'url' => $this->getUrl('*/*/massDelete'),
                'confirm' => __('Are you sure you want to delete selected items?')
            ]
        );

        return $this;
    }
    
    public function getGridUrl()
    {
        return $this->getUrl('*/*/index', ['_current' => true]);
    }
    
    public function _filterStatusCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return $this;
        }

        // Change the conditions based on your requirements
        $value = strtolower($value);

        if (strpos(strtolower(__('Updated')), $value) !== false) {
            $value = 1;
        } elseif (strpos(strtolower(__('Not updated')), $value) !== false) {
            $value = 0;
        }

        $this->getCollection()->addFieldToFilter($column->getIndex(), ['like' => "%$value%"]);

        return $this;
    }
}