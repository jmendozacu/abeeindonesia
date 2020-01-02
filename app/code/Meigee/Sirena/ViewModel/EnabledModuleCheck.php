<?php
namespace Meigee\Sirena\ViewModel;

use Magento\Framework\View\Element\Block\ArgumentInterface;
use Magento\Framework\Module\Manager;

/**
 * Class EnabledModuleCheck
 * @package Meigee\Sirena\ViewModel
 */
class EnabledModuleCheck implements ArgumentInterface
{
    /**
     * @var Manager
     */
    private $moduleManager;

    /**
     * EnabledModuleCheck constructor.
     * @param Manager $moduleManager
     */
    public function __construct(
        Manager $moduleManager
    ) {
        $this->moduleManager = $moduleManager;
    }

    /**
     * @param $moduleName
     * @return bool
     */
    public function isModuleEnabled( $moduleName)
    {
        return $this->moduleManager->isEnabled($moduleName);
    }
}
