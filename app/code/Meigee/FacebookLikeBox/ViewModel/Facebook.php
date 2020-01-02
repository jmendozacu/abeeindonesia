<?php
namespace Meigee\FacebookLikeBox\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * Class Facebook
 * @package Meigee\FacebookLikeBox\ViewModel
 */
class Facebook implements ArgumentInterface
{
    const MODULE_PATH = 'meigee_facebook/';

    const XML_PATH_FACEBOOK_STATUS = 'general/status';

    const XML_PATH_FACEBOOK_URL = 'general/url';

    const XML_PATH_FACEBOOK_HEIGHT = 'general/height';

    const XML_PATH_FACEBOOK_FACES = 'general/faces';

    const XML_PATH_FACEBOOK_SMALL_HEADER = 'general/small_header';

    const XML_PATH_FACEBOOK_POSTS = 'general/posts';

    const XML_PATH_FACEBOOK_COVER = 'general/cover';

    const XML_PATH_FACEBOOK_ADAPTIVE_WIDTH = 'general/adaptive_width';

    const DEFAULT_WIDTH = '300';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * Facebook constructor.
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
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
    public function isFacebookEnable()
    {
        $config = (bool)$this->getModuleConfig(self::XML_PATH_FACEBOOK_STATUS);
        return $config;
    }

    /**
     * @return mixed
     */
    public function getFacebookUrl()
    {
        $config = $this->getModuleConfig(self::XML_PATH_FACEBOOK_URL);
        return $config;
    }

    /**
     * @return mixed
     */
    function getFacebookHeight()
    {
        $config = $this->getModuleConfig(self::XML_PATH_FACEBOOK_HEIGHT);
        return $config;
    }

    /**
     * @return mixed
     */
    function getFacebookFaces()
    {
        $config = $this->getModuleConfig(self::XML_PATH_FACEBOOK_FACES);
        return $config;
    }

    /**
     * @return mixed
     */
    function getFacebookSmallHeader()
    {
        $config = $this->getModuleConfig(self::XML_PATH_FACEBOOK_SMALL_HEADER);
        return $config;
    }

    /**
     * @return mixed
     */
    function getFacebookPosts()
    {
        $config = $this->getModuleConfig(self::XML_PATH_FACEBOOK_POSTS);
        return $config;
    }

    /**
     * @return mixed
     */
    function getFacebookCover()
    {
        $config = $this->getModuleConfig(self::XML_PATH_FACEBOOK_COVER);
        return $config;
    }

    /**
     * @return mixed
     */
    function getFacebookAdaptiveWidth()
    {
        $config = $this->getModuleConfig(self::XML_PATH_FACEBOOK_ADAPTIVE_WIDTH);
        return $config;
    }

    public function getFacebookData()
    {
        $facebookData = 'data-width="' . self::DEFAULT_WIDTH . '"';
        $facebookData .= ' data-height="' . $this->getFacebookHeight() . '"';
        $facebookData .= ' data-href="' . $this->getFacebookUrl() . '"';
        $facebookData .= ' data-show-facepile="' . $this->getFacebookFaces() . '"';
        $facebookData .= ' data-small-header="' . $this->getFacebookSmallHeader() . '"';
        $facebookData .= ' data-adapt-container-width="' . $this->getFacebookAdaptiveWidth() . '"';
        $facebookData .= ' data-hide-cover="' . $this->getFacebookCover() . '"';
        $facebookData .= ' data-show-posts="' . $this->getFacebookPosts() . '"';
        return $facebookData;
    }
}
