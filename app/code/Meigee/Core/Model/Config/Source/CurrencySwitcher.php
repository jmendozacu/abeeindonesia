<?php
namespace Meigee\Core\Model\Config\Source;

class CurrencySwitcher implements \Magento\Framework\Data\OptionSourceInterface
{
    public function toOptionArray()
    {
		return [
			  ['value' => 'currency_select', 'label' => __('Select Box'), 'img' => 'Meigee_Core::images/currency_select.png'],
			  ['value' => 'currency_images', 'label' => __('List'), 'img' => 'Meigee_Core::images/currency_images.png']
		];
    }
}