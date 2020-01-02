<?php
/**
 * Copyright 2016 Amazon.com, Inc. or its affiliates. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 *  http://aws.amazon.com/apache2.0
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */
namespace Meigee\ThemeActivator\Block\Adminhtml\System\Config;

use Magento\Backend\Block\Template\Context;
use\Magento\Framework\App\RequestInterface;
use Magento\Store\Model\StoreManagerInterface;

class DynamicFields extends \Magento\Config\Block\System\Config\Form\Field
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    public function __construct(
        Context $context,
        RequestInterface $request,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        $this->request = $request;
        $this->storeManager = $storeManager;
        parent::__construct($context, $data);
    }

    /**
     * Render element value
     *
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function render(\Magento\Framework\Data\Form\Element\AbstractElement $element)
    {
        $stores = $this->storeManager->getStores();
        $storesList = '';
        $i = 0;
        foreach ($stores as $store) {
            if ($i > 0) {
                $storesList .= ', ';
            }
            $storesList .= $store['name'];
            $i++;
        }
        $output = '<div style="background-color:#eee;padding:1em;border:1px solid #ddd;">';
        $output .= __('The theme can be activated for stores only. Please choose a desired store view (%1) from the store switcher to be able to activate the theme', $storesList);
        $output .= "</div>";
        return $output;
    }
}
