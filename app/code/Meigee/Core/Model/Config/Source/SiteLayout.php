<?php
namespace Meigee\Core\Model\Config\Source;

class SiteLayout implements \Magento\Framework\Data\OptionSourceInterface
{
    public function toOptionArray()
    {
		return [
			  ['value' => 'wide-layout', 'label' => __('Wide')],
			  ['value' => 'boxed-layout', 'label' => __('Boxed')]
		];
    }
}
