<?php
namespace Meigee\Core\Model\Config\Source;

class ContactmapType implements \Magento\Framework\Data\OptionSourceInterface
{
    public function toOptionArray()
    {
		return [
			  ['value' => 'ROADMAP', 'label' => __('Normal street map')],
			  ['value' => 'SATELLITE', 'label' => __('Satellite images')],
			  ['value' => 'TERRAIN', 'label' => __('Map with physical features')]
		];
    }
}
