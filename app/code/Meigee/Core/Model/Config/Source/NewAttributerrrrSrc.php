<?php


namespace Meigee\Core\Model\Config\Source;

class NewAttributerrrrSrc implements \Magento\Framework\Data\OptionSourceInterface
{
    public function toOptionArray()
    {

        return [
                      ['value' => 1, 'title' => __('title 1'), 'img' => 'Meigee_Core::images/default-store.jpeg']
                    , ['value' => 2, 'title' => __('title 2'), 'img' => 'Meigee_Core::images/default-store.jpeg']
                    , ['value' => 3, 'title' => __('title 3'), 'img' => 'Meigee_Core::images/default-store.jpeg']
                    , ['value' => 4, 'title' => __('title 4'), 'img' => 'Meigee_Core::images/default-store.jpeg']
                ];




    }

}
