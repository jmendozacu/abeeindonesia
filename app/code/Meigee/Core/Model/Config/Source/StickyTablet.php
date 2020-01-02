<?php
namespace Meigee\Core\Model\Config\Source;

class StickyTablet implements \Magento\Framework\Data\OptionSourceInterface
{
    public function toOptionArray()
    {
		return [
			  ['value' => 'sticky-tablet', 'label' => __('Enable')],
			  ['value' => '', 'label' => __('Disable')]
		];
    }
}
