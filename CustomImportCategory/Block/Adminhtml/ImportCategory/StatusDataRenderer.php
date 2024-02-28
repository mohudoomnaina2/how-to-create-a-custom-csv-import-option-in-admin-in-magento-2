<?php
namespace WonderAndInstaSoft\CustomImportCategory\Block\Adminhtml\ImportCategory;

use Magento\Backend\Block\Widget\Grid\Column\Renderer\AbstractRenderer;

class StatusDataRenderer extends AbstractRenderer
{
    public function render(\Magento\Framework\DataObject $row)
    {
        $status = $row->getData($this->getColumn()->getIndex());

        // Change the condition based on your requirements
        if(isset($status)){
            if ($status == 1) {
                $statusLabel = __('Updated');
            } else {
                $statusLabel = __('Not updated');
            }
        }else{
            $statusLabel = __('Not updated');
        }

        return $statusLabel;
    }
}
