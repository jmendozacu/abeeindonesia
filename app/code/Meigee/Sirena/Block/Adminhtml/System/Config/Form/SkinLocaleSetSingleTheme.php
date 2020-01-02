<?php
namespace Meigee\Sirena\Block\Adminhtml\System\Config\Form;

use Magento\Backend\Block\Template\Context;
use Magento\Config\Block\System\Config\Form\Field;
use Magento\Framework\Data\Form\Element\AbstractElement;
use Meigee\ThemeActivator\Model\Config\ConfigPhp;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Theme\Model\ResourceModel\Theme\CollectionFactory as ThemeCollectionFactory;
use Magento\Store\Model\ScopeInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Serialize\SerializerInterface;

class SkinLocaleSetSingleTheme extends \Meigee\ThemeActivator\Block\Adminhtml\System\Config\Form\SkinLocaleSetSingleTheme
{
    /**
     * @var string
     */
    protected $_template = 'Meigee_Sirena::system/config/form/field/skin_locale_set_single.phtml';

}