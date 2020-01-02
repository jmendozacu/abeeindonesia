<?php
namespace Meigee\Core\Model\Config\Source;

class TimerListType implements \Magento\Framework\Data\OptionSourceInterface
{
    public function toOptionArray()
    {
		return [
			  ['value' => '0', 'label' => __('Hours: Minutes: Seconds')],
			  ['value' => '1', 'label' => __('Days: Hours: Minutes: Seconds')]
		];
    }
}
