<?php

namespace Sams\Address\Model\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;

class AddHtmlToOrderShippingViewObserver implements ObserverInterface
{

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * @param \Magento\Framework\ObjectManagerInterface $objectmanager
     */
    public function __construct(\Magento\Framework\ObjectManagerInterface $objectmanager)
    {
        $this->_objectManager = $objectmanager;
    }

    public function execute(EventObserver $observer)
    {
//        $transport = $observer->getTransport();
//        $fieldset = $transport->getFieldset();

//        echo "<pre>";
//        print_r($transport);die;
//        echo "</pre>";
//        echo "<pre>";
//        print_r($fieldset->debug());
//        echo "</pre>";
//        echo __CLASS__ . "===================================" . "</br></br>";
//        die;

        if ($observer->getElementName() == 'order_shipping_view') {
            $orderShippingViewBlock = $observer->getLayout()->getBlock($observer->getElementName());
            $order = $orderShippingViewBlock->getOrder();

            $customField = $this->_objectManager->create('Magento\Framework\View\Element\Template');
            $customField->setSubdistrict($order->getSubdistrict());
            $customField->setTemplate('Sams_Address::order_info_shipping_info.phtml');
            $html = $observer->getTransport()->getOutput() . $customField->toHtml();
            $observer->getTransport()->setOutput($html);
        }
    }
}