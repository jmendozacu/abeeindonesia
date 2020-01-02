<?php
namespace Meigee\ThemeActivator\Setup;

use Magento\Config\Model\ResourceModel\Config;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Serialize\SerializerInterface;
use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

class InstallData implements \Magento\Framework\Setup\InstallDataInterface
{
    /**
     * Xpath to dynamic field value
     */
    const XPATH_DYNAMIC_FIELD = 'theme_customizer/general/skin_locale_set';
    /**
     * Resource Config
     *
     * @var Config
     */
    protected $resourceConfig;
    /**
     * Json Serializer
     *
     * @var SerializerInterface
     */
    protected $serializer;
    /**
     * InstallData constructor
     *
     * @param SerializerInterface $serializer
     * @param Config $resourceConfig
     */
    public function __construct(SerializerInterface $serializer, Config $resourceConfig)
    {
        $this->resourceConfig = $resourceConfig;
        $this->serializer = $serializer;
    }
    /**
     * @inheritdoc
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();
        $defaultValues = [
            ['mega_options' => 'value', 'available_locales' => 'value', 'email', 'value'],
        ];
        $serializedValue = $this->serializer->serialize($defaultValues);
        $this->resourceConfig->saveConfig(
            self::XPATH_DYNAMIC_FIELD,
            $serializedValue,
            ScopeConfigInterface::SCOPE_TYPE_DEFAULT,
            0
        );
        $installer->endSetup();
    }
}
