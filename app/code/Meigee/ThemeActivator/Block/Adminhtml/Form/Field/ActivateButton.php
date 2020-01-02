<?php
namespace Meigee\ThemeActivator\Block\Adminhtml\Form\Field;

use Magento\Framework\View\Element\AbstractBlock;
use Magento\Framework\View\Element\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Backend\Block\TemplateFactory;

class ActivateButton extends AbstractBlock
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
     * @var TemplateFactory
     */
    private $blockTemplate;

    /**
     * ActivateButton constructor.
     *
     * @param Context                   $context
     * @param ScopeConfigInterface      $scopeConfig
     * @param StoreManagerInterface     $storeManager
     * @param TemplateFactory           $blockTemplate
     * @param array                     $data
     */
    public function __construct(
        Context $context,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        TemplateFactory $blockTemplate,

        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->scopeConfig = $scopeConfig;
        $this->storeManager = $storeManager;
        $this->blockTemplate = $blockTemplate;
    }

    /**
     * @return $this|\Magento\Framework\View\Element\AbstractBlock
     */
    public function _prepareLayout()
    {
        parent::_prepareLayout();
        if (!$this->getTemplate()) {
            $this->setTemplate('system/config/reportlink.phtml');
        }

        return $this;
    }

    /**
     * @return string
     */
    protected function _toHtml()
    {
        if (!$this->_beforeToHtml()) {
            return '';
        }
        $html = '<input type="hidden" name="' . $this->getData('input_name') . '" value="false"/><button type="submit" name="activate_row" value="<%- _id %>">Activate</button>';
        return $html;
    }
}
