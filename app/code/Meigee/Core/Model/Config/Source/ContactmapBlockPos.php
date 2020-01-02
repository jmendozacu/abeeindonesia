<?php
namespace Meigee\Core\Model\Config\Source;

class ContactmapBlockPos implements \Magento\Framework\Data\OptionSourceInterface
{
    public function toOptionArray()
    {
		return [
			  ['value' => 'left-top', 'label' => __('Left Top')],
              ['value' => 'left-center', 'label' => __('Left Center')],
              ['value' => 'left-bottom', 'label' => __('Left Bottom')],
			  ['value' => 'right-top', 'label' => __('Right Top')],
              ['value' => 'right-center', 'label' => __('Right Center')],
			  ['value' => 'right-bottom', 'label' => __('Right Bottom')]
		];
    }
}
