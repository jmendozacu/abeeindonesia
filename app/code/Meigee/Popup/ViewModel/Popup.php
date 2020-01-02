<?php
namespace Meigee\Popup\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Stdlib\CookieManagerInterface;
use Magento\Framework\App\Request\Http as HttpRequest;
use Magento\Framework\View\Element\AbstractBlock;
use Magento\Cms\Block\Block;

/**
 * Class Popup
 * @package Meigee\Popup\ViewModel
 */
class Popup implements ArgumentInterface
{
    const CMS_INDEX_INDEX = 'cms_index_index';

    const POPUP_FLAG_COOKIE_NAME = 'popupFlag';

    const MODULE_PATH = 'meigee_popup/';

    const XML_PATH_POPUP_STATUS = 'general/status';

    const XML_PATH_POPUP_STATIC_IDENTIFIER = 'general/static_identifier';

    const XML_PATH_POPUP_EXPIRES = 'general/expires';

    const XML_PATH_POPUP_ONLY_HOME = 'general/home_only';

    const XML_PATH_POPUP_WIDTH = 'general/width';

    const XML_PATH_POPUP_HEIGHT = 'general/height';

    const XML_PATH_POPUP_MOBILE = 'general/mobile';

    const XML_PATH_POPUP_TABLET = 'general/tablet';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var CookieManagerInterface
     */
    private $cookieManager;

    /**
     * @var HttpRequest
     */
    private $httpRequest;

    /**
     * @var Block
     */
    private $block;

    private $popupStaticBlock;

    /**
     * Popup constructor.
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param CookieManagerInterface $cookieManager
     * @param HttpRequest $httpRequest
     * @param Block $block
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        CookieManagerInterface $cookieManager,
        HttpRequest $httpRequest,
        Block $block
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->cookieManager = $cookieManager;
        $this->httpRequest = $httpRequest;
        $this->block = $block;
    }
    /**
     * @param $path
     * @param int $storeId
     * @return mixed
     */
    public function getModuleConfig($path, $storeId = null)
    {
        return $this->scopeConfig->getValue(
            self::MODULE_PATH . $path,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    /**
     * @return bool
     */
    public function isPopupEnable()
    {
        $config = (bool)$this->getModuleConfig(self::XML_PATH_POPUP_STATUS);
        return $config;
    }

    /**
     * @return mixed
     */
    public function getPopupStaticIdentifier()
    {
        $config = $this->getModuleConfig(self::XML_PATH_POPUP_STATIC_IDENTIFIER);
        return $config;
    }

    /**
     * @return mixed
     */
    function getPopupExpires()
    {
        $config = $this->getModuleConfig(self::XML_PATH_POPUP_EXPIRES);
        return $config;
    }

    /**
     * @return bool
     */
    function isPopupHomeOnly()
    {
        $config = (bool)$this->getModuleConfig(self::XML_PATH_POPUP_ONLY_HOME);
        return $config;
    }

    /**
     * @return mixed
     */
    function getPopupWidth()
    {
        $config = $this->getModuleConfig(self::XML_PATH_POPUP_WIDTH);
        return $config;
    }

    /**
     * @return mixed
     */
    function getPopupHeight()
    {
        $config = $this->getModuleConfig(self::XML_PATH_POPUP_HEIGHT);
        return $config;
    }

    /**
     * @return bool
     */
    function isPopupMobile()
    {
        $config = (bool)$this->getModuleConfig(self::XML_PATH_POPUP_MOBILE);
        return $config;
    }

    /**
     * @return bool
     */
    function isPopupTablet()
    {
        $config = (bool)$this->getModuleConfig(self::XML_PATH_POPUP_TABLET);
        return $config;
    }

    /**
     * @return bool
     */
    function isCanShow()
    {
        if (!$this->getCookie(self::POPUP_FLAG_COOKIE_NAME)) {
            if ($this->isPopupHomeOnly()) {
                if ($this->isFullActionName(self::CMS_INDEX_INDEX)) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return true;
            }
        }
        return false;
    }

    /**
     * @param $fullActionName
     * @return bool
     */
    public function isFullActionName($fullActionName)
    {
        if ( $this->httpRequest->getFullActionName() == $fullActionName ) {
            return true;
        }
        return false;
    }

    /**
     * @param $name
     * @return null|string
     */
    public function getCookie($name)
    {
        return $this->cookieManager->getCookie($name);
    }


    /**
     * Render popup statick block form HTML
     *
     * @return string
     */
    public function getPopupStaticBlockHtml()
    {
        if (!$this->popupStaticBlock) {
            $this->popupStaticBlock = $this->block->setBlockId($this->getPopupStaticIdentifier());
        }

        if ($this->popupStaticBlock instanceof AbstractBlock) {
            return $this->popupStaticBlock->toHtml();
        }
        return '';
    }
}
