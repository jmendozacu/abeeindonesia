<?php
namespace Meigee\ThemeActivator\Model\Config\Source;

class StaticContentOptions implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray () {
        return [
            ['value' => 0, 'label' => __('No')],
            ['value' => 1, 'label' => __('Import and override if exist')],
            ['value' => 2, 'label' => __('Import and do not override if exist')]
        ];
    }
}
