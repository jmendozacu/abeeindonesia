<?php
namespace Meigee\Core\Model\Config\Source;

class HeaderSearchType implements \Magento\Framework\Data\OptionSourceInterface
{
    public function toOptionArray()
    {
		return [
			  ['value' => 'type-1', 'label' => __('Type 1')],
			  ['value' => 'type-2', 'label' => __('Type 2')]
		];
    }
}
