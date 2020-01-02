<?php
namespace Meigee\Core\Model\Config\Source;

class StockStatus implements \Magento\Framework\Data\OptionSourceInterface
{
    public function toOptionArray()
    {
		return [
			  ['value' => '1', 'label' => __('Grid Only')],
			  ['value' => '2', 'label' => __('List Only')],
			  ['value' => '3', 'label' => __('Grid and List Only')],
			  ['value' => '4', 'label' => __('Disable')]
		];
    }
}
