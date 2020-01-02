<?php
namespace Meigee\Core\Model\Config\Source;

class RTLsupport implements \Magento\Framework\Data\OptionSourceInterface
{
    public function toOptionArray()
    {
		return [
			  ['value' => 'rtl-enabled', 'label' => __('Enabled')],
			  ['value' => '', 'label' => __('Disabled')]
		];
    }
}
