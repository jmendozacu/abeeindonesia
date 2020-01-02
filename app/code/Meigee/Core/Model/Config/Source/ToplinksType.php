<?php
namespace Meigee\Core\Model\Config\Source;

class ToplinksType implements \Magento\Framework\Data\OptionSourceInterface
{
    public function toOptionArray()
    {
		return [
			  ['value' => 0, 'label' => __('Custom')],
			  ['value' => 1, 'label' => __('Default')]
		];
    }
}
