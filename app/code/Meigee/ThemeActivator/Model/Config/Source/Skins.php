<?php
namespace Meigee\ThemeActivator\Model\Config\Source;

class Skins implements \Magento\Framework\Option\ArrayInterface
{
    /**
     * @return array
     */
    public function toOptionArray () {
        return [
            ['value' => 'default_skin', 'label' => 'Default'],
            ['value' => 'orion_skin', 'label' => 'Orion Skin']
        ];
    }
}
