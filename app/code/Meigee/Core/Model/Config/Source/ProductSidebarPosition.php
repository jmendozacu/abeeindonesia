<?php
namespace Meigee\Core\Model\Config\Source;

class ProductSidebarPosition implements \Magento\Framework\Data\OptionSourceInterface
{
    public function toOptionArray()
    {
		return [
			  ['value' => 'product-sidebar-bottom', 'label' => __('Bottom content area')],
			  ['value' => '', 'label' => __('Top content area')]
		];
    }
}
