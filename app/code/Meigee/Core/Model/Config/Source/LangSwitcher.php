<?php
namespace Meigee\Core\Model\Config\Source;

class LangSwitcher implements \Magento\Framework\Data\OptionSourceInterface
{
    public function toOptionArray()
    {
		return [
			  ['value' => 'language_select', 'label' => __('Select Box'), 'img' => 'Meigee_Core::images/language_select.png'],
			  ['value' => 'language_flags', 'label' => __('Flags'), 'img' => 'Meigee_Core::images/language_flags.png'],
			  ['value' => 'language_list', 'label' => __('List'), 'img' => 'Meigee_Core::images/language_list.png'],
		];
    }
}
