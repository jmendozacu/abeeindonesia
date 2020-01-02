<?php
namespace Meigee\Core\Model\Config\Source;

class MinicartType implements \Magento\Framework\Data\OptionSourceInterface
{
    public function toOptionArray()
    {
		return [
			  ['value' => 'default', 'label' => __('Dropdown')],
			  ['value' => 'fixed-right-pos', 'label' => __('Fixed Slide from Right')]
		];
    }
}
