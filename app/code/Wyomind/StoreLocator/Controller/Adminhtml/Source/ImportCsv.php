<?php
/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Wyomind\StoreLocator\Controller\Adminhtml\Source;

use \Wyomind\StoreLocator\Helper\Acl;

/**
 * Class ImportCsv
 * @package Wyomind\StoreLocator\Controller\Adminhtml\Source
 */
class ImportCsv extends \Wyomind\StoreLocator\Controller\Adminhtml\Source
{
    /**
     * @var \Magento\Framework\File\Uploader
     */
    private $uploader;


    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\ResultInterface
     * @throws \Exception
     */
    public function execute()
    {

        $this->uploader=new \Magento\Framework\File\Uploader("csv-file");
        if ($this->uploader->getFileExtension() != "csv") {
            $this->messageManager->addError(__("Wrong file type (") . $this->_uploader->getFileExtension() . __(").<br>Choose a csv file."));
        } else {
            $path=$this->filesystem->getDirectoryRead(\Magento\Framework\App\Filesystem\DirectoryList::TMP)->getAbsolutePath();
            $this->uploader->save($path, "import-source.csv");
            $file=new \Magento\Framework\Filesystem\Driver\File;
            $csv=new \Magento\Framework\File\Csv($file);
            $csv->setDelimiter("\t");
            $content=$csv->getData($path . $this->uploader->getUploadedFileName());

            $fields=$content[0];

            $i=1;
            while (isset($content[$i])) {

                foreach ($content[$i] as $key=>$value) {
                    if (isset($fields[$key])) {

                        $source=$this->source->setData($fields[$key], $value);
                    }
                }

                $this->sourceRepository->save($source);


                $i++;
            }


            $file->deleteFile($path . $this->uploader->getUploadedFileName());
        }
        $this->messageManager->addSuccess(($i - 1) . __(" places have been imported."));
        $result=$this->resultRedirectFactory->create()->setPath("inventory/source");
        return $result;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(Acl::SOURCE_IMPORT);
    }

}
