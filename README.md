How To Create A Custom CSV Import Option In Admin In Magento 2:-
================================================================
## File Structure View:-
```plaintext
YourVendorName[Eg: WonderAndInstaSoft]
|-- YourModuleName[Eg: CustomImportCategory]
|   |-- composer.json
|   |-- registration.php
|   |-- etc
|       |-- adminhtml
|       |   |-- routes.xml
|       |   |-- menu.xml
|       |-- acl.xml
|       |-- db_schema.xml
|       |-- db_schema_whitelist.json
|       |-- module.xml
|   |-- Block
|       |-- Adminhtml
|       |   |-- ImportCategory
|       |   |   |-- Grid.php
|       |   |   |-- ImportCategoryForm.php
|       |   |   |-- StatusDataRenderer.php
|   |-- Controller
|       |-- Adminhtml
|       |   |-- ImportCategory
|       |   |   |-- AddImportCategory.php
|       |   |   |-- Index.php
|       |   |   |-- MassDelete.php
|       |   |   |-- SaveImportCategory.php
|       |   |   |-- UpdateImportCategory.php
|   |-- Model
|       |-- ResourceModel
|       |   |-- ImportCategory
|       |   |   |-- Collection.php
|       |   |-- ImportCategory.php
|       |-- ImportCategory.php
|   |-- view
|       |-- adminhtml
|       |   |-- layout
|       |   |   |-- customimportcategory_importcategory_index.xml
|       |   |-- templates
|       |   |   |-- customimportcategory_view.phtml
|       |   |-- web
|       |   |   |-- ImportCategorySampleCsvFile
|       |   |   |   |-- ImportCategorySampleCsvFile.csv
|       |   |   |   |-- ImportCategorySampleCsvFile2.csv
```

## Procedures
<b>WonderAndInstaSoft_CustomImportCategory [Note: My current vendor name is "WonderAndInstaSoft" and Module Name is "CustomImportCategory"]</b><br /><br />
<b>Step1:-</b> Create composer.json, registration.php and etc/module.xml files.<br />
[<b>Reference Blog Link:-</b> https://www.thecoachsmb.com/create-module/].<br /><br />
<b>Step2:-</b> Create etc/adminhtml/routes.xml and etc/adminhtml/menu.xml files.<br />
[<b>Reference Blog Link:-</b> https://www.thecoachsmb.com/how-to-create-a-new-admin-menu-submenu-in-magento-2/].<br /><br />
<b>Step3:-</b> Create etc/acl.xml file.<br />
[<b>Reference Blog Link:-</b> https://www.mageplaza.com/devdocs/magento-2-acl-access-control-lists.html].<br />

## Admin Menu and Submenu Output:-
![Final_Output](https://github.com/mohudoomnaina2/how-to-create-a-new-admin-menu-submenu-in-magento-2/assets/70482911/47328b0a-7b5e-47e3-afa1-f5ef1dfc1772)
<br>
## Admin ACL Output:-
![Final_Output1](https://github.com/mohudoomnaina2/how-to-create-a-new-admin-menu-submenu-in-magento-2/assets/70482911/c7047162-9abf-4b2d-89da-0110c96fc9f8)
