<?php
namespace Meigee\Core\Model\Config\Source;

class StickyHeader implements \Magento\Framework\Data\OptionSourceInterface
{
    public function toOptionArray()
    {
		return [
			  ['value' => 'sticky-header', 'label' => __('Enable')],
			  ['value' => '', 'label' => __('Disable')]
		];
    }
}
