<?php
namespace Meigee\Core\Model\Config\Source;

class ImageHoverType implements \Magento\Framework\Data\OptionSourceInterface
{
    public function toOptionArray()
    {
		return [
			  ['value' => 0, 'label' => __('Simple')],
			  ['value' => 1, 'label' => __('Scale')]
		];
    }
}
