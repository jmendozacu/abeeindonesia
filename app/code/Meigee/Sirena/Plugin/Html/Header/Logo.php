<?php

namespace Meigee\Sirena\Plugin\Html\Header;

use Meigee\Sirena\ViewModel\ThemeConfigPhp;
use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\UrlInterface;
use Magento\MediaStorage\Helper\File\Storage\Database;
use Magento\Framework\Filesystem;
use Magento\Framework\Filesystem\Directory\ReadInterface;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Theme\Block\Html\Header\Logo as MagentoLogo;

/**
 * Class Logo
 * @package Meigee\Sirena\Plugin\Html\Header
 */
class Logo
{
    const CMS_INDEX_INDEX = 'cms_index_index';

    const CHECKOUT_INDEX_INDEX = 'checkout_index_index';

    const LOGO_PATH = 'logo/';

    /**
     * @var ThemeConfigPhp
     */
    private $themeConfig;

    /**
     * @var HttpRequest
     */
    private $httpRequest;

    /**
     * @var StoreManagerInterface
     */
    private $storeManagerInterface;

    /**
     * Url Builder
     *
     * @var UrlInterface
     */
    private $urlBuilder;

    /**
     * @var Database
     */
    private $fileStorageHelper;

    /**
     * @var Filesystem
     */
    private $filesystem;

    /**
     * Logo constructor.
     * @param ThemeConfigPhp $themeConfig
     * @param HttpRequest $httpRequest
     * @param StoreManagerInterface $storeManagerInterface
     * @param UrlInterface $urlBuilder
     * @param Database $fileStorageHelper
     * @param Filesystem $filesystem
     */
    public function __construct(
        ThemeConfigPhp $themeConfig,
        HttpRequest $httpRequest,
        StoreManagerInterface $storeManagerInterface,
        UrlInterface $urlBuilder,
        Database $fileStorageHelper,
        Filesystem  $filesystem
    ) {
        $this->themeConfig = $themeConfig;
        $this->httpRequest = $httpRequest;
        $this->storeManagerInterface = $storeManagerInterface;
        $this->urlBuilder = $urlBuilder;
        $this->fileStorageHelper = $fileStorageHelper;
        $this->filesystem = $filesystem;
    }

    /**
     * @param \Magento\Theme\Block\Html\Header\Logo $subject
     * @param $result
     * @return string
     */
    public function afterGetLogoSrc(MagentoLogo $subject, $result)
    {
        if($this->getMeigeeLogoSrc()){
            $path = self::LOGO_PATH . $this->getMeigeeLogoSrc();
            $logoUrl = $this->urlBuilder
                    ->getBaseUrl(['_type' => UrlInterface::URL_TYPE_MEDIA]) . $path;
            $result = $logoUrl;
        }
        return $result;
    }

    /**
     * @param \Magento\Theme\Block\Html\Header\Logo $subject
     * @param $result
     * @return string
     */
    public function afterGetLogoAlt(MagentoLogo $subject, $result)
    {
        if($this->getMeigeeLogoAlt()){
            return $this->getMeigeeLogoAlt();
        }
        return $result;
    }

    /**
     * @return bool|string
     */
    public function getMeigeeLogoSrc()
    {
        if(!$this->themeConfig->getLogoCustom() && !$this->themeConfig->getLogoCheckout()){
            return false;
        }
        if(
            $this->themeConfig->getLogoCheckout()
            && $this->themeConfig->getLogoCheckoutSrc()
            && $this->isFullActionName(self::CHECKOUT_INDEX_INDEX)
            && $this->isFile($this->themeConfig->getLogoCheckoutSrc())
        ){
            return $this->themeConfig->getLogoCheckoutSrc();
        }
        if(
            $this->themeConfig->getLogoCustom()
            && $this->themeConfig->getSecondLogoCustomSrc()
            && !$this->isFullActionName(self::CMS_INDEX_INDEX)
            && $this->isFile($this->themeConfig->getSecondLogoCustomSrc())
        ){
            return $this->themeConfig->getSecondLogoCustomSrc();
        }
        if(
            $this->themeConfig->getLogoCustom()
            && $this->themeConfig->getLogoCustomSrc()
            && $this->isFile($this->themeConfig->getLogoCustomSrc())
        ){
            return $this->themeConfig->getLogoCustomSrc();
        }
        return false;
    }

    /**
     * @return bool|string
     */
    public function getMeigeeLogoAlt()
    {
        if(!$this->themeConfig->getLogoCustomAlt()){
            return false;
        }
        return $this->themeConfig->getLogoCustomAlt();
    }

    /**
     * @param $fullActionName
     * @return bool
     */
    public function isFullActionName($fullActionName)
    {
        if($this->httpRequest->getFullActionName() == $fullActionName){
            return true;
        }
        return false;
    }

    /**
     * If DB file storage is on - find there, otherwise - just file_exists
     *
     * @param string $filename relative path
     * @return bool
     */
    protected function isFile($filename)
    {
        $filename = self::LOGO_PATH . $filename;
        if ($this->fileStorageHelper->checkDbUsage() && !$this->getMediaDirectory()->isFile($filename)) {
            $this->fileStorageHelper->saveFileToFilesystem($filename);
        }

        return $this->getMediaDirectory()->isFile($filename);
    }

    /**
     * @return ReadInterface
     */
    protected function getMediaDirectory()
    {
        return $this->filesystem->getDirectoryRead(DirectoryList::MEDIA);
    }
}
