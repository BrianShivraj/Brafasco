<?php
/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */

namespace Wyomind\StoreLocator\Controller\Adminhtml\Source;

use Magento\InventoryApi\Api\Data\SourceInterface;
use \Wyomind\StoreLocator\Helper\Acl;

/**
 * Class ExportCsv
 * @package Wyomind\StoreLocator\Controller\Adminhtml\Source
 */
class ExportCsv extends \Wyomind\StoreLocator\Controller\Adminhtml\Source
{

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\RawFactory|\Magento\Framework\Controller\ResultInterface|mixed
     */
    public function execute()
    {


        $fileName="source.csv";


        $content="";
        $sources=$this->collection->create();
        foreach ($sources as $source) {
            $header="";
            foreach ($source->getData() as $key=>$value) {

                if ($key != SourceInterface::CARRIER_LINKS) {
                    $header.=$key . "\t";
                    $content.=str_replace("\t", "\\t", $value) . "\t";
                }
            }
            $content.="\r\n";
        }

        return $this->framework->sendUploadResponse($fileName, $header . "\r\n" . $content);
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed(Acl::SOURCE_EXPORT);
    }
}
