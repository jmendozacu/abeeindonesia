<?php
namespace Meigee\ThemeActivator\Model\Config\Source;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Meigee\ThemeActivator\Model\Config\ConfigPhp;
use Magento\Theme\Model\ResourceModel\Theme\CollectionFactory;

class Themes implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var \Magento\Theme\Model\ResourceModel\Theme\CollectionFactory
     */
    private $themeCollectionFactory;

    /**
     * Themes constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     * @param CollectionFactory    $themeCollectionFactory
     */
    public function __construct(
        ScopeConfigInterface $scopeConfig,
        CollectionFactory $themeCollectionFactory
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->themeCollectionFactory = $themeCollectionFactory;
    }

    /**
     * @return array
     */
    public function toOptionArray () {
        $options = [];
        $config = $this->scopeConfig->getValue(ConfigPhp::XML_PATH_ACTIVATOR_THEME);
        if (!empty($config)) {

            foreach ($config as $theme => $skins) {

                $skinsArray = [];
                foreach ($skins as $skin => $label) {
                    $skinsArray[] = [
                        'label' => ucfirst($skin) . ' skin',
                        'value' => $theme . '___' . $skin
                    ];
                }
                $options[] =  [
                    'label' => $theme,
                    'value' => $skinsArray
                ];

                $parentThemeId = $this->themeCollectionFactory->create()->getThemeByFullPath('frontend/' . str_replace('_', '/', $theme))->getId();

                $childThemes = $this->themeCollectionFactory->create()->addFilter('parent_id', $parentThemeId)->getItems();
                if (!empty($childThemes)) {
                    $childSkinsArray = [];
                    foreach ($childThemes as $childTheme) {
                        $childThemeCode = str_replace('/', '_', $childTheme->getData('code'));
//                        $this->addOption($childThemeCode, $childThemeCode, ['disabled' => 1]);
                        foreach ($skins as $skin => $label) {
                            $childSkinsArray[] = [
                                'label' => ucfirst($skin) . ' skin',
                                'value' => $childThemeCode . '___' . $skin
                            ];
                        }
                        $options[] =  [
                            'label' => $childThemeCode,
                            'value' => $childSkinsArray
                        ];
                    }
                }


            }

        } else {
            $options = [
                'value' => 'no themes found'
            ];
        }
        return $options;
    }
}
