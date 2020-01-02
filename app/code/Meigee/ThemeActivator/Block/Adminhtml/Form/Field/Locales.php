<?php
namespace Meigee\ThemeActivator\Block\Adminhtml\Form\Field;

use Magento\Framework\View\Element\Html\Select;
use Magento\Framework\View\Element\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Locale\AvailableLocalesInterface;
use Magento\Store\Model\StoreManagerInterface;

class Locales extends Select
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * Locales constructor.
     *
     * @param Context                   $context
     * @param ScopeConfigInterface      $scopeConfig
     * @param AvailableLocalesInterface $availableLocales
     * @param StoreManagerInterface     $storeManager
     * @param array                     $data
     */
    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig,
        AvailableLocalesInterface $availableLocales,
        StoreManagerInterface $storeManager,

        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->scopeConfig = $scopeConfig;
        $this->availableLocales = $availableLocales;
        $this->storeManager = $storeManager;
    }

    /**
     * @return string
     */
    public function _toHtml()
    {
        $websites = $this->storeManager->getWebsites();
        foreach ($websites as $website) {
            $this->addOption($website->getData('name'), $website->getData('name'), ['disabled' => 1]);
            foreach ($website->getGroups() as $group) {
                $stores = $group->getStores();
                foreach ($stores as $store) {
                    $locale = $this->scopeConfig->getValue('general/locale/code', \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $store->getData('store_id'));
                    $this->addOption($locale, $group->getData('name') . ' / ' .$store->getData('name') . ' ( ' . $locale . ' )');
                }

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
