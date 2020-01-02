<?php
namespace Meigee\Core\Model\Config\Source;

class StickyElements implements \Magento\Framework\Data\OptionSourceInterface
{
    public function toOptionArray()
    {
		return [
			  ['value' => 'sticky-logo', 'label' => __('Logo')],
			  ['value' => 'sticky-nav', 'label' => __('Navigation Menu')],
			  ['value' => 'sticky-cart', 'label' => __('Cart')],
			  ['value' => 'sticky-search', 'label' => __('Search box')]
		];
    }
}
