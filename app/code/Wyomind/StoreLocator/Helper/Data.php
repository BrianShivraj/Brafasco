<?php

/**
 * Copyright © 2019 Wyomind. All rights reserved.
 * See LICENSE.txt for license details.
 */
namespace Wyomind\StoreLocator\Helper;

/**
 * Core general helper
 */
class Data extends \Magento\Framework\App\Helper\AbstractHelper
{
    /**
     *
     */
    const TEXTAREA = 0;
    /**
     *
     */
    const WYSIWYG = 1;
    /**
     *
     */
    const TEXT = 2;
    /**
     * @var \Magento\Framework\Image\AdapterFactory|null
     */
    protected $imageAdapterFactory = null;
    /**
     * @var \Wyomind\StoreLocator\Model\ResourceModel\Attributes\CollectionFactory
     */
    protected $collectionFactory;
    public function __construct(\Wyomind\StoreLocator\Helper\Delegate $wyomind, \Magento\Framework\App\Helper\Context $context, \Wyomind\StoreLocator\Model\ResourceModel\AttributesValues\CollectionFactory $collectionFactory, \Magento\Framework\Image\AdapterFactory $imageAdapterFactory)
    {
        $wyomind->constructor($this, $wyomind, __CLASS__);
        parent::__construct($context);
        $this->imageAdapterFactory = $imageAdapterFactory;
        $this->collectionFactory = $collectionFactory;
    }
    /**
     * @param $src
     * @param int $xSize
     * @param int $ySize
     * @param bool $keepRatio
     * @param string $styles
     * @return string|void
     * @throws \Magento\Framework\Exception\FileSystemException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getImage($src, $xSize = 150, $ySize = 150, $keepRatio = true, $styles = "")
    {
        if ($src != "") {
            $path = $this->_getMediaDir() . DIRECTORY_SEPARATOR . $src;
            if ($this->file->fileExists($path)) {
                $part = explode("/", $src);
                $basename = $xSize . DIRECTORY_SEPARATOR . $ySize . DIRECTORY_SEPARATOR . array_pop($part);
                $cachePath = $this->_getMediaDir() . DIRECTORY_SEPARATOR . "stores" . DIRECTORY_SEPARATOR . "cache" . DIRECTORY_SEPARATOR . $basename;
                $image = new \Magento\Framework\Image($this->imageAdapterFactory->create(), $path);
                $image->constrainOnly(false);
                $image->keepAspectRatio($keepRatio);
                $image->setImageBackgroundColor(0xffffff);
                $image->keepTransparency(true);
                $image->resize($xSize, $ySize);
                $image->save($cachePath);
                $baseurl = $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA, false);
                return "<img style='" . $styles . "' src='" . $baseurl . "stores/cache/" . $basename . "'/>";
            } else {
                return;
            }
        } else {
            return;
        }
    }
    /**
     * @param $daysOff
     * @param $param
     * @return mixed
     */
    public function getDaysOff($daysOff, $param)
    {
        $dates = [];
        foreach (explode("
", $daysOff) as $dayOff) {
            $time = null;
            if (strpos($dayOff, " ") !== false) {
                $hours = substr($dayOff, strpos($dayOff, " "));
                $dayOff = substr($dayOff, 0, strpos($dayOff, " "));
                list($from, $to) = explode("-", $hours);
                $format = $this->framework->getStoreConfig(\Wyomind\StoreLocator\Helper\Config::SETTINGS_TIME);
                $time = " " . __("from") . " " . date($format, strtotime($from)) . " " . __("to") . " " . date($format, strtotime($to));
            }
            $dates[] = $this->objectManager->create('Magento\\Framework\\Stdlib\\DateTime\\TimezoneInterface')->formatDate(date("Y-m-d H:i:s", strtotime($dayOff)), \IntlDateFormatter::LONG, false) . $time;
        }
        return implode("<br>", $dates);
    }
    /**
     * @param $pattern
     * @param $placeholder
     * @param array $parameters
     * @return array
     */
    public function parsePlaceholder($pattern, $placeholder, $parameters = [])
    {
        $param = [];
        foreach ($parameters as $parameter => $value) {
            $param[$parameter] = $value;
        }
        if (preg_match("#{{" . $placeholder . " [^{]*}}#", $pattern, $fullMatch)) {
            preg_match_all("#(\\S+)=[\"']?((?:.(?![\"']?\\s+(?:\\S+)=|[>\"']))+.)[\"']?#", $fullMatch[0], $matches);
            $pattern = str_replace($fullMatch[0], "{{" . $placeholder . "}}", $pattern);
            foreach ($matches[0] as $k => $parameter) {
                $param[$matches[1][$k]] = $matches[2][$k];
            }
        }
        return [$pattern, $param];
    }
    /**
     * @param $source
     * @param null $template
     * @return mixed
     * @throws \Magento\Framework\Exception\FileSystemException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function parseTemplate($source, $type, $useConfig)
    {
        if ($type != \Wyomind\StoreLocator\Api\Data\SourceInterface::PAGE) {
            if (!$useConfig) {
                $pattern = $source->getDescription();
            } else {
                $pattern = $this->framework->getStoreConfig(\Wyomind\StoreLocator\Helper\Config::DESCRIPTION_TEMPLATE);
            }
        } else {
            if (!$useConfig) {
                $pattern = $source->getPage() ?: $source->getExtensionAttributes()->getSource()->getPage();
            } else {
                $pattern = $this->framework->getStoreConfig(\Wyomind\StoreLocator\Helper\Config::PAGE_TEMPLATE);
            }
        }
        // common {{placeholders}}
        return $this->parse($pattern, $source);
        //        // widgets/variables/blocks....
        //        $pattern=$this->filterProvider->getBlockFilter()
        //            ->setStoreId($this->storeManager->getStore()->getId())
        //            ->filter($pattern);
    }
    /**
     * @param $pattern
     * @param $source
     * @return mixed
     * @throws \Magento\Framework\Exception\FileSystemException
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function parse($pattern, $source)
    {
        $replace = [];
        $image = $source->getImage() ?? ($source->getExtensionAttributes() !== null ? $source->getExtensionAttributes()->getSource()->getImage() : null);
        $hours = $source->getBusinessHours() ?? ($source->getExtensionAttributes() !== null ? $source->getExtensionAttributes()->getSource()->getBusinessHours() : null);
        $urlKey = $source->getUrlKey() ?? ($source->getExtensionAttributes() !== null ? $source->getExtensionAttributes()->getSource()->getUrlKey() : null);
        $pageEnabled = $source->getEnablePage() ?? ($source->getExtensionAttributes() !== null ? $source->getExtensionAttributes()->getSource()->getEnablePage() : null);
        $streetAdditional = $source->getStreetAdditional() ?? ($source->getExtensionAttributes() !== null ? $source->getExtensionAttributes()->getSource()->getStreetAdditional() : null);
        $daysOff = $source->getDaysOff() ?? ($source->getExtensionAttributes() !== null ? $source->getExtensionAttributes()->getSource()->getDaysOff() : null);
        list($pattern, $param) = $this->parsePlaceholder($pattern, "image", ["width" => 150, "height" => 150, "style" => null]);
        $search[] = '{{image}}';
        $replace[] = $this->getImage($image, $param["width"], $param["height"], true, $param["style"]);
        $search[] = '{{name}}';
        $replace[] = $source->getName();
        $search[] = '{{code}}';
        $replace[] = $source->getSourceCode();
        $search[] = '{{address_1}}';
        $replace[] = $source->getStreet();
        $search[] = '{{zipcode}}';
        $replace[] = $source->getPostcode();
        $search[] = '{{city}}';
        $replace[] = $source->getCity();
        $regionCode = $source->getRegionCode() ?? ($source->getExtensionAttributes() !== null ? $source->getExtensionAttributes()->getSource()->getRegionCode() : null);
        $countryId = $source->getCountryId();
        if ($regionCode) {
            $search[] = '{{state}}';
            $replace[] = $this->regionModel->loadByCode($regionCode, $countryId)->getName();
        } else {
            $search[] = '{{state}}';
            $replace[] = null;
        }
        $search[] = '{{country}}';
        $replace[] = $this->localeLists->getCountryTranslation($countryId);
        $search[] = '{{phone}}';
        $replace[] = $source->getPhone();
        $search[] = '{{email}}';
        $replace[] = $source->getEmail();
        $search[] = '{{address_2}}';
        $replace[] = $streetAdditional;
        $search[] = '{{business_hours}}';
        $replace[] = $this->getHours($hours);
        list($pattern, $param) = $this->parsePlaceholder($pattern, "dasy_off", ["date" => "", "time" => ""]);
        $search[] = '{{days_off}}';
        $replace[] = $this->getDaysOff($daysOff, $param);
        list($pattern, $param) = $this->parsePlaceholder($pattern, "link", ["class" => "", "title" => $source->getName(), "style" => ""]);
        if ($pageEnabled == 1) {
            $search[] = '{{link}}';
            $replace[] = '<a style="' . $param["style"] . '"class="' . $param["class"] . '" href="/' . $urlKey . '">' . $param["title"] . "</a>";
        } else {
            $search[] = '{{link}}';
            $replace[] = "";
        }
        $search[] = '{{google_map}}';
        $replace[] = '<div id="map_canvas_storelocator" "></div>';
        // additional attributes placeholders
        foreach ($this->attributesRepository->list() as $attribute) {
            $collectionFactory = $this->collectionFactory->create();
            $value = $collectionFactory->getBySourceId($source->getSourceCode(), $attribute->getId())->getFirstItem();
            $search[] = '{{' . $attribute->getCode() . '}}';
            if ($attribute->getType() == \Wyomind\StoreLocator\Helper\Data::TEXT || $attribute->getType() == \Wyomind\StoreLocator\Helper\Data::TEXTAREA) {
                $replace[] = htmlentities($value->getValue());
            } elseif ($attribute->getType() == \Wyomind\StoreLocator\Helper\Data::WYSIWYG) {
                $replace[] = $this->filterProvider->getBlockFilter()->setStoreId($this->storeManager->getStore()->getId())->filter($value->getValue());
            }
        }
        return str_replace($search, $replace, $pattern);
    }
    /**
     * @param $data
     * @return null|string
     */
    public function getHours($data)
    {
        $data = json_decode($data);
        $content = null;
        if ($data !== null) {
            foreach ($data as $day => $hours) {
                $content .= __($day);
                $f = explode(':', $hours->from);
                $t = explode(':', $hours->to);
                $from = $f[0] * 60 * 60 + $f[1] * 60 + 1;
                $to = $t[0] * 60 * 60 + $t[1] * 60 + 1;
                $lfrom = 0;
                $lto = 0;
                if (isset($hours->lunch_from) && isset($hours->lunch_to)) {
                    $lf = explode(':', $hours->lunch_from);
                    $lt = explode(':', $hours->lunch_to);
                    $lfrom = $lf[0] * 60 * 60 + $lf[1] * 60 + 1;
                    $lto = $lt[0] * 60 * 60 + $lt[1] * 60 + 1;
                }
                $content .= ' ' . $this->coreDate->gmtDate($this->framework->getStoreConfig(\Wyomind\StoreLocator\Helper\Config::SETTINGS_TIME), $from) . ($lfrom != 0 ? ' - ' . date($this->framework->getStoreConfig(\Wyomind\StoreLocator\Helper\Config::SETTINGS_TIME), $lfrom) : '') . ' - ' . ($lto != 0 ? date($this->framework->getStoreConfig(\Wyomind\StoreLocator\Helper\Config::SETTINGS_TIME), $lto) . ' - ' : '') . date($this->framework->getStoreConfig(\Wyomind\StoreLocator\Helper\Config::SETTINGS_TIME), $to) . "<br>";
            }
        }
        return $content;
    }
    /**
     * @return string
     * @throws \Magento\Framework\Exception\FileSystemException
     */
    protected function _getMediaDir()
    {
        return $this->directoryList->getPath(\Magento\Framework\App\Filesystem\DirectoryList::MEDIA);
    }
    /**
     * @return \Wyomind\Framework\Helper\type
     */
    public function getGoogleApiKey()
    {
        return $this->framework->getStoreConfig(\Wyomind\StoreLocator\Helper\Config::GOOGLE_API);
    }
    /**
     * Get the handling fee of the shipping method
     * @return float|null
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @deprecated
     */
    public function getHandlingFee()
    {
        $storeId = $this->storeManager->getStore()->getId();
        return $this->framework->getStoreConfig('carriers/clickncollect/handling_fee', $storeId);
    }
    /**
     * @return string
     */
    public function getGoogleMapsAPIScript()
    {
        if (!$this->registry->registry('GoogleMapsAPILoaded')) {
            $this->registry->register('GoogleMapsAPILoaded', true);
            return '<script type="text/javascript" type="text/javascript" src="' . '/' . '/' . 'maps.googleapis.com/maps/api/js?v=3&key=' . $this->getGoogleApiKey() . '"></script>';
        } else {
            return "";
        }
    }
}
