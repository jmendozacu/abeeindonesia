<?php
namespace Meigee\Sirena\Block\Frontend\Customer\Form;

use Magento\Customer\Block\Form\Login as MagentoLogin;
use Magento\Framework\View\Element\AbstractBlock;

class Login extends MagentoLogin
{
    /**
     * Prepare layout
     *
     * @return MagentoLogin|AbstractBlock
     */
    protected function _prepareLayout()
    {
        return AbstractBlock::_prepareLayout();
    }
}
