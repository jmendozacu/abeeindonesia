<?php
namespace Meigee\ThemeActivator\Block\Adminhtml\Form\Field;

use Magento\Framework\View\Element\Html\Select;
use Magento\Framework\View\Element\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Meigee\ThemeActivator\Model\Config\ConfigPhp;
use Magento\Theme\Model\Theme;
use Magento\Framework\View\Design\Theme\ThemeProvider;
use Magento\Theme\Model\ResourceModel\Theme\CollectionFactory;

class Skins extends Select
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var \Magento\Theme\Model\Theme
     */
    private $themeModel;

    /**
     * @var \Magento\Framework\View\Design\Theme\ThemeProvider
     */
    private $themeProvider;

    /**
     * @var \Magento\Theme\Model\ResourceModel\Theme\CollectionFactory
     */
    private $themeCollectionFactory;

    /**
     * Skins constructor.
     *
     * @param Context                                                    $context
     * @param ScopeConfigInterface                                       $scopeConfig
     * @param \Magento\Theme\Model\Theme                                 $themeModel
     * @param \Magento\Framework\View\Design\Theme\ThemeProvider         $themeProvider
     * @param \Magento\Theme\Model\ResourceModel\Theme\CollectionFactory $themeCollectionFactory
     * @param array                                                      $data
     */
    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig,
        Theme $themeModel,
        ThemeProvider $themeProvider,
        CollectionFactory $themeCollectionFactory,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->scopeConfig = $scopeConfig;
        $this->themeModel = $themeModel;
        $this->themeProvider = $themeProvider;
        $this->themeCollectionFactory = $themeCollectionFactory;
    }

    /**
     * @return string
     */
    public function _toHtml()
    {
        if (!$this->getOptions()) {
            $config = $this->scopeConfig->getValue(ConfigPhp::XML_PATH_ACTIVATOR_THEME);
            if (!empty($config)) {

                foreach ($config as $theme => $skins) {


                    $this->addOption($theme, $theme, ['disabled' => 1]);
                    foreach ($skins as $skin => $label) {
//                        $themeWithoutVendor = explode('Meigee/', $theme);
                        $this->addOption($theme . '___' . $skin, ucfirst(str_replace('_', '/', $theme)) . ': ' . $skin . ' skin');
                    }

                    $parentThemeId = $this->themeCollectionFactory->create()->getThemeByFullPath('frontend/' . str_replace('_', '/', $theme))->getId();

                    $childThemes = $this->themeCollectionFactory->create()->addFilter('parent_id', $parentThemeId)->getItems();
                    if (!empty($childThemes)) {
                        foreach ($childThemes as $childTheme) {
                            $childThemeCode = $childTheme->getData('code');
                            $this->addOption($childThemeCode, $childThemeCode, ['disabled' => 1]);
                            foreach ($skins as $skin => $label) {
//                                $childThemeWithoutVendor = explode('Meigee/', $childThemeCode);
                                $this->addOption($childThemeCode . '___' . $skin, $childThemeCode . ': ' . $skin);
                            }
                        }
                    }
                }

            } else {
                $this->addOption('notheme', __('No themes found'));
            }
        }
        return parent::_toHtml();
    }

    /**
     * @param $value
     *
     * @return mixed
     */
    public function setInputName($value) {
        return $this->setName($value);
    }
}
