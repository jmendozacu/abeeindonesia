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
use Magento\Framework\View\Design\Theme\ThemeProviderInterface;
use Magento\Framework\App\Filesystem\DirectoryList;

class SkinLocaleSetSingleTheme extends Field
{
    /**
     * @var string
     */
    protected $_template = 'Meigee_ThemeActivator::system/config/form/field/skin_locale_set_single.phtml';

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
     * @var ThemeProviderInterface
     */
    private $themeProvider;

    /**
     * @var \Magento\Framework\App\Filesystem\DirectoryList
     */
    private $directoryList;

    /**
     * SkinLocaleSetSingleTheme constructor.
     *
     * @param Context                $context
     * @param ScopeConfigInterface   $scopeConfig
     * @param ThemeCollectionFactory $themeCollectionFactory
     * @param StoreManagerInterface  $storeManager
     * @param SerializerInterface    $serializer
     * @param ThemeProviderInterface $themeProvider
     * @param DirectoryList          $directoryList
     * @param array                  $data
     */
    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig,
        ThemeCollectionFactory $themeCollectionFactory,
        StoreManagerInterface $storeManager,
        SerializerInterface $serializer,
        ThemeProviderInterface $themeProvider,
        DirectoryList $directoryList,
        array $data = []
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->themeCollectionFactory = $themeCollectionFactory;
        $this->storeManager = $storeManager;
        $this->serializer = $serializer;
        $this->themeProvider = $themeProvider;
        $this->directoryList = $directoryList;
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
     * @return array
     */
    public function getThemesList()
    {

        $config = $this->scopeConfig->getValue(ConfigPhp::XML_PATH_ACTIVATOR_THEME);
        if (!empty($config)) {
            $themeList =[];
            foreach ($config as $theme => $skins) {
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

// Getting formatted list of activated themes with stores and locales
        $stores = $this->storeManager->getStores();
        $themeList2 =[];
        foreach ($stores as $store) {
            $themeId = $this->scopeConfig->getValue(ConfigPhp::XML_PATH_THEME_ID, ScopeInterface::SCOPE_STORE
                , $store->getId());

            $theme = $this->themeProvider->getThemeById($themeId);
            $themeName = str_replace('/', '_', $theme->getCode());
            if (!$theme->getThemePath()) {
                continue;
            }
            $localeConfig = $this->scopeConfig->getValue(ConfigPhp::XML_PATH_LOCALE, ScopeInterface::SCOPE_STORE
                , $store->getId());
            $themeList2[$themeName]['stores'][$store->getCode()] = $localeConfig;
        }

// Getting formatted list of activated skins (through the activator) on locales
        $skinLocaleSetConfig = $this->scopeConfig->getValue(ConfigPhp::XML_PATH_SKIN_LOCALE_SET);
        $skinLocaleSetConfig = $this->decodeParam($skinLocaleSetConfig);
        $activatedSkins = [];
        foreach ($skinLocaleSetConfig as $config => $locale) {
            $config = explode('___', $config);
            $themeN = $config[0];
            $skin = $config[1];
            $activatedSkins[$themeN]['skins'][$skin] = $locale;
        }
        foreach ($activatedSkins as $theme => $key) {
            $activatedSkins[$theme]['skins'] = array_slice($key['skins'], -1);
        }

// Merging with all skins
        foreach ($themes as $theme => $skins) {
            $theme = str_replace('/', '_', $theme);
            if (!key_exists($theme, $themeList2)) {
                continue;
            }
            $themeList2[$theme]['skins'] = $skins;

            foreach ($skins as $skin => $value) {

                if (key_exists($theme, $activatedSkins)) {
                    if (key_exists($skin, $activatedSkins[$theme]['skins'])) {
                        $themeList2[$theme]['skins'][$skin] = $activatedSkins[$theme]['skins'][$skin];
                        break;
                    }
                }
            }
        }

        return $themeList2;
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
            $importedDemosArray = $this->decodeParam($importedDemos);
            if (in_array($skinScope, $importedDemosArray)) {
                return true;
            }
        }
        return false;
    }

    /**
     * @return string
     */
    public function getMagentoRootDir()
    {
        return $this->getRootDirectory()->getAbsolutePath();
    }

    /**
     * @param AbstractElement $element
     *
     * @return string
     */
    protected function _getElementHtml(AbstractElement $element)
    {
        return $this->_toHtml();
    }
}
