<?php
namespace Meigee\Sirena\Block\Frontend\Customer\Form;

use Magento\Customer\Block\Form\Register as MagentoRegister;
use Magento\Framework\View\Element\AbstractBlock;

class Register extends MagentoRegister
{
    /**
     * Prepare layout
     *
     * @return MagentoRegister|AbstractBlock
     */
    protected function _prepareLayout()
    {
        return AbstractBlock::_prepareLayout();
    }
}
