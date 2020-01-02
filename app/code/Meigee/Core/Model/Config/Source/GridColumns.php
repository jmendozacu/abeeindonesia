<?php
namespace Meigee\Core\Model\Config\Source;

class GridColumns implements \Magento\Framework\Data\OptionSourceInterface
{
    public function toOptionArray()
    {
		return [
			  ['value' => 'columns-2', 'label' => __('2')],
			  ['value' => 'columns-3', 'label' => __('3')],
			  ['value' => 'columns-4', 'label' => __('4')],
			  ['value' => 'columns-5', 'label' => __('5')],
			  ['value' => 'columns-6', 'label' => __('6')],
			  ['value' => 'columns-7', 'label' => __('7')],
			  ['value' => 'columns-8', 'label' => __('8')]
		];
    }
}
