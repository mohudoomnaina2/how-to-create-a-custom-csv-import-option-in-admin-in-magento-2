<?php
namespace WonderAndInstaSoft\CustomImportCategory\Controller\Adminhtml\ImportCategory;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use WonderAndInstaSoft\CustomImportCategory\Model\ResourceModel\ImportCategory\Collection as ImportCategoryCollection;

class SaveImportCategory extends Action
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
        if (isset($_FILES['file'])) {
            // File type and size validation
            $fileData = $_FILES['file']; // Use $_FILES to access file information

            // Check file type
            $allowedFileTypes = ['csv']; // Add more allowed file types if needed
            $fileType = pathinfo($fileData['name'], PATHINFO_EXTENSION);
            if (!in_array(strtolower($fileType), $allowedFileTypes)) {
                $this->messageManager->addErrorMessage(__('Invalid file type. Please upload a CSV file.'));
                return $this->_redirect('*/*/AddImportCategory');
            }

            // Check file size (in bytes)
            $maxFileSize = 1048576; // 1 MB, you can adjust as needed
            if ($fileData['size'] > $maxFileSize) {
                $this->messageManager->addErrorMessage(__('File size exceeds the allowed limit.'));
                return $this->_redirect('*/*/AddImportCategory');
            }
            
            // Process CSV data
            $csvData = $this->readCsvFile($fileData['tmp_name']);
            
            // Validate number of columns
            $currentCsvColumnCount=500;
            if (!$this->validateNumberOfColumns($csvData, $currentCsvColumnCount)) {
                $this->messageManager->addErrorMessage(__("Note: In the CSV data, there must be only $currentCsvColumnCount data or row(s) in a single upload."));
                return $this->_redirect('*/*/AddImportCategory');
            }
            
            // Insert CSV data into the database
            $this->insertCsvDataIntoDb($csvData);
            
            $this->messageManager->addSuccessMessage(__('Category inserted successfully.'));
        }else{
            $this->messageManager->addErrorMessage(__('Required field must.'));
            return $this->_redirect('*/*/AddImportCategory');
        }

        // Redirect to the form page
        $resultRedirect = $this->resultRedirectFactory->create();
        $resultRedirect->setPath('*/*/index');

        return $resultRedirect;
    }
    
    protected function readCsvFile($filePath)
    {
        $csvData = [];
        if (($handle = fopen($filePath, "r")) !== FALSE) {
            // Skip the first row
            fgetcsv($handle, 1000, ",");
    
            // Read the remaining rows
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $csvData[] = $data;
            }
            fclose($handle);
        }
        return $csvData;
    }

    protected function validateNumberOfColumns($csvData, $currentCsvColumnCount)
    {
        if(isset($currentCsvColumnCount) && $currentCsvColumnCount!="" && $currentCsvColumnCount!=null){
            $expectedColumns = $currentCsvColumnCount;
        }else{
            $expectedColumns = 500;
        }
        
        $currentDataCount = @count($csvData);
        if ($expectedColumns <= $currentDataCount) {
            return false;
        }
    
        return true;
    }

    protected function insertCsvDataIntoDb($csvData)
    {
        // $currentDate = date('Y-m-d H:i:s');
        $currentDate = date('Y-m-d');

        foreach ($csvData as $row) {
            $importCategory = $this->_objectManager->create(\WonderAndInstaSoft\CustomImportCategory\Model\ImportCategory::class);
            $importCategory->setData([
                'articlecode' => $row[0], // Replace with your actual column names
                // 'eancode' => $row[1],
                'category_1' => $row[1],
                'category_2' => $row[2],
                'category_3' => $row[3],
                'category_4' => $row[4],
                'date' => $currentDate,
                //'status' => 1
            ]);
            $importCategory->save();
        }
    }
    
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('WonderAndInstaSoft_CustomImportCategory::import_category_sub');
    }
}
