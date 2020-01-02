<?php
namespace Meigee\ThemeActivator\Block\Adminhtml\System\Config\Form;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Meigee\ThemeActivator\Model\Config\ConfigPhp;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Theme\Model\ResourceModel\Theme\CollectionFactory as ThemeCollectionFactory;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Serialize\SerializerInterface;

class SkinLocaleSet extends Field
{
    /**
     * @var string
     */
    protected $_template = 'Meigee_ThemeActivator::system/config/form/field/skin_locale_set.phtml';

    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var ThemeCollectionFactory
     */
    private $themeCollectionFactory;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var string
     */
    private $themeName = '';

    /**
     * SkinLocaleSet constructor.
     *
     * @param Context                $context
     * @param ScopeConfigInterface   $scopeConfig
     * @param ThemeCollectionFactory $themeCollectionFactory
     * @param StoreManagerInterface  $storeManager
     * @param SerializerInterface    $serializer
     * @param array                  $data
     */
    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig,
        ThemeCollectionFactory $themeCollectionFactory,
        StoreManagerInterface $storeManager,
        SerializerInterface $serializer,
        array $data = []
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->themeCollectionFactory = $themeCollectionFactory;
        $this->storeManager = $storeManager;
        $this->serializer = $serializer;
        parent::__construct($context, $data);
    }

    /**
     * @param AbstractElement $element
     *
     * @return string
     */
    public function render(AbstractElement $element)
    {
        $element->unsScope()->unsCanUseWebsiteValue()->unsCanUseDefaultValue();
        return parent::render($element);
    }

    /**
     * @param bool $singleTheme
     *
     * @return array
     */
    public function getThemesList($singleTheme = false)
    {
        $config = $this->scopeConfig->getValue(ConfigPhp::XML_PATH_ACTIVATOR_THEME);
        $cleanConfig = [];
        if ($singleTheme && in_array($this->themeName, $config)) {
            $configCleaned = $config[$this->themeName];
        } else {
            $cleanConfig = $config;
        }
        if (!empty($config)) {
            $themeList =[];
            foreach ($cleanConfig as $theme => $skins) {
                $theme = str_replace('_', '/', $theme);
                $themeList[$theme] = $skins;
                $parentThemeId = $this->themeCollectionFactory->create()->getThemeByFullPath('frontend/' . $theme)->getId();
                $childThemes = $this->themeCollectionFactory->create()->addFilter('parent_id', $parentThemeId)->getItems();
                foreach ($childThemes as $childTheme) {
                    $themeList[$childTheme->getData('code')] = $skins;
                }
            }
        }
        return $themeList;
    }

    /**
     * @return array
     */
    public function getActivatedThemeList()
    {
        $themes = $this->getThemesList();

        $themeList = [];
        foreach ($themes as $theme => $skins) {
            $themeId = $this->themeCollectionFactory->create()->getThemeByFullPath('frontend/' . $theme)->getId();;
            $stores = $this->storeManager->getStores();
            foreach ($stores as $store) {
                $scopeConfig = $this->scopeConfig->getValue(ConfigPhp::XML_PATH_THEME_ID, ScopeInterface::SCOPE_STORE
                , $store->getId());
                $localeConfig = $this->scopeConfig->getValue(ConfigPhp::XML_PATH_LOCALE, ScopeInterface::SCOPE_STORE
                    , $store->getId());
                $defaultLocaleConfig = $this->scopeConfig->getValue(ConfigPhp::XML_PATH_LOCALE);
                if ($scopeConfig == $themeId) {
                    $localeConfig ? $localeConfig : $defaultLocaleConfig;
                    $skinLocaleSetConfig = $this->scopeConfig->getValue(ConfigPhp::XML_PATH_SKIN_LOCALE_SET);
                    $skinLocaleSetConfig = $this->decodeParam($skinLocaleSetConfig);
                    $activatedSkinFlag = false;
                    foreach ($skins as $skin => $value) {
                        $themeSkinUndescored = str_replace('/', '_', $theme) . '___' . $skin;
                        $themeList[$theme]['stores'][$store->getCode()] = $localeConfig;
                        if (key_exists( $themeSkinUndescored, $skinLocaleSetConfig)) {

                            if ($skinLocaleSetConfig[$themeSkinUndescored] === $localeConfig) {
                                if($activatedSkinFlag) {
                                    $themeList[$theme]['skins'][$activatedSkinFlag] = null;
                                    $activatedSkinFlag = false;
                                }

                                $lastOccurance = explode('___', array_search($localeConfig, array_reverse($skinLocaleSetConfig)));
                                $themeList[$theme]['skins'][$lastOccurance[1]] = $localeConfig;
                                $activatedSkinFlag = $skin;



                            } elseif ($skinLocaleSetConfig[$themeSkinUndescored] === null) {
                                $themeList[$theme]['skins'][$skin] = null;
                            }
                        } else {
                            $themeList[$theme]['skins'][$skin] = null;
                        }
                    }

                }
            }
        }

        return $themeList;
    }

    /**
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getButtonHtml()
    {
        $button = $this->getLayout()->createBlock(
            'Magento\Backend\Block\Widget\Button'
        )->setData(
            [
                'id' => 'collect_button',
                'label' => __('Collect Data'),
            ]
        );

        return $button->toHtml();
    }

    /**
     * @return string
     */
    public function getUniqId()
    {
        return uniqid();
    }

    /**
     * @param $data
     *
     * @return bool|string
     */
    public function encodeParam($data)
    {
        return $this->serializer->serialize($data);
    }


    /**
     * @param $data
     *
     * @return array|bool|float|int|string|null
     */
    public function decodeParam($data)
    {
        return $this->serializer->unserialize($data);
    }

    /**
     * @param $constName
     * @param $storeId
     *
     * @return mixed
     */
    public function getConfig($constName, $storeId)
    {
        $config = $this->scopeConfig->getValue(ConfigPhp::getConstantName($constName), ScopeInterface::SCOPE_STORE, $storeId);
        return $config;
    }

    /**
     * @param $skinScope
     *
     * @return bool
     */
    public function isDemoSet($skinScope)
    {
        if (!empty($importedDemos = $this->getConfig('XML_PATH_DEMO_IMPORTED', 0))) {
            
            return true;
        }
    }

    /**
     * Return element html
     *
     * @param  AbstractElement $element
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        return $this->_toHtml();
    }
}
