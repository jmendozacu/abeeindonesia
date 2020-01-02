<?php
namespace Meigee\BackgroundSlider\ViewModel;

use Meigee\Sirena\ViewModel\ThemeConfigPhp;
use Meigee\Core\Model\Config\Source\HeaderLayout;
use Meigee\Core\Model\Config\Source\ContentLayout;
use Meigee\Core\Model\Config\Source\FooterLayout;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\UrlInterface;
use Magento\Framework\App\Request\Http as HttpRequest;

class Slider implements ArgumentInterface
{
    const BODY_CSS_CLASS = 'backstretch-loaded';

    const CMS_INDEX_INDEX = 'cms_index_index';

    const MODULE_PATH = 'background_slider/';

    const XML_PATH_HEADER_BACKGROUND_SLIDER_STATUS = 'slider_options/slider_status';

    const XML_PATH_HEADER_BACKGROUND_SLIDER_HOMEPAGE_ONLY = 'slider_options/slider_homepage_only';

    const XML_PATH_HEADER_BACKGROUND_SLIDES = 'slider_options/slider_slides_src';

    const XML_PATH_HEADER_BACKGROUND_SLIDER_FADE = 'slider_options/slider_fade';

    const XML_PATH_HEADER_BACKGROUND_SLIDER_DURATION = 'slider_options/slider_duration';

    /**
     * @var ThemeConfigPhp
     */
    private $themeConfig;

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var HttpRequest
     */
    private $httpRequest;

    /**
     * Slider constructor.
     * @param ThemeConfigPhp $themeConfig
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param HttpRequest $httpRequest
     */
    public function __construct(
        ThemeConfigPhp $themeConfig,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        HttpRequest $httpRequest
    ) {
        $this->themeConfig = $themeConfig;
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->httpRequest = $httpRequest;
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
    public function getBackgroundSliderEnable()
    {
        $config = (bool)$this->getModuleConfig(self::XML_PATH_HEADER_BACKGROUND_SLIDER_STATUS);
        return $config;
    }

    /**
     * @return bool
     */
    public function getBackgroundSliderHomepageOnlyConfig()
    {
        $config = (bool)$this->getModuleConfig(self::XML_PATH_HEADER_BACKGROUND_SLIDER_HOMEPAGE_ONLY);
        return $config;
    }

    /**
     * @return bool
     */
    public function getBackgroundSlider()
    {
        if ($this->getBackgroundSliderEnable()) {
            if ($this->getBackgroundSliderHomepageOnlyConfig()) {
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
     * @return mixed
     */
    public function getSlidesConfig()
    {
        $config = $this->getModuleConfig(self::XML_PATH_HEADER_BACKGROUND_SLIDES);
        return $config;
    }

    /**
     * @return mixed
     */
    function getFade()
    {
        $config = $this->getModuleConfig(self::XML_PATH_HEADER_BACKGROUND_SLIDER_FADE);
        return $config;
    }

    /**
     * @return mixed
     */
    function getDuration()
    {
        $config = $this->getModuleConfig(self::XML_PATH_HEADER_BACKGROUND_SLIDER_DURATION);
        return $config;
    }

    /**
     * @return bool
     */
    function getIsBoxedContentThemeLayout()
    {
        if ($this->themeConfig->getHeaderLayout() != HeaderLayout::HEADER_BOXED) {
            return false;
        }
        if ($this->themeConfig->getContentLayout() != ContentLayout::CONTENT_BOXED) {
            return false;
        }
        if ($this->themeConfig->getFooterLayout() != FooterLayout::FOOTER_BOXED) {
            return false;
        }
        return true;
    }

    /**
     * @return mixed
     */
    function getThemeSiteWidth()
    {
        $config = $this->themeConfig->getSiteWidth();
        return $config;
    }

    /**
     * @return bool|string
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    function getSlides()
    {
        if (!$this->getBackgroundSliderEnable()) {
            return false;
        }

        $slides = $this->getSlidesConfig();

        if (!empty($slides)) {
            $slides =  unserialize($slides);
            $base_url = $this->storeManager->getStore()->getBaseUrl(UrlInterface::URL_TYPE_MEDIA);
            $html_arr = array();

            foreach ($slides AS $slide) {
                $html_arr[] = $base_url . $slide;
            }
            return implode(',', $html_arr);
        }
        return false;
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
}
