<?php
namespace Meigee\Core\Model\Config\Source;

class LabelsType implements \Magento\Framework\Data\OptionSourceInterface
{
    public function toOptionArray()
    {
		return [
			  ['value' => 'label-type-1', 'label' => __('Type 1'), 'img' => 'Meigee_Core::images/label_type_1.png'],
			  ['value' => 'label-type-2', 'label' => __('Type 2'), 'img' => 'Meigee_Core::images/label_type_2.png'],
			  ['value' => 'label-type-3', 'label' => __('Type 3'), 'img' => 'Meigee_Core::images/label_type_3.png'],
			  ['value' => 'label-type-4', 'label' => __('Type 4'), 'img' => 'Meigee_Core::images/label_type_4.png']
		];
    }
}
