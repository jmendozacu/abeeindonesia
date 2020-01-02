<?php
namespace Meigee\ThemeActivator\Model\Generate;

use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Module\Dir\Reader;
use Magento\Setup\Exception;
use Magento\Store\Model\ScopeInterface;
use Magento\Framework\Module\Dir;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Framework\App\Config\ReinitableConfigInterface;
use Magento\TestFramework\App\ReinitableConfig;
use Magento\Framework\Serialize\SerializerInterface;
use \Meigee\ThemeActivator\Model\Config\ConfigPhp;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class StaticContent
 * @package Meigee\ThemeActivator\Model\Generate
 */
class StaticContent
{
    const XML_PATH_MEIGEE_ACTIVATION_PAGES = 'meigee_activation/sirena/default_skin/pages';
    const XML_PATH_MEIGEE_ACTIVATION_BLOCKS = 'meigee_activation/sirena/default_skin/blocks';
    const XML_PATH_MEIGEE_ACTIVATION_CONFIG = 'meigee_activation/sirena/default_skin/config';
    const CONTENT_TYPE_PAGE = 'pages';
    const CONTENT_TYPE_BLOCK = 'blocks';
    const ACTIVATION_DATA_DIR = 'ActivationData';

    /**
     * @var \Magento\Framework\Xml\Parser
     */
    private $xmlparser;

    /**
     * @var Dir
     */
    private $moduleDirs;

    /**
     * @var \Magento\Framework\Simplexml\Config
     */
    private $simpleXml;

    /**
     * @var \Magento\Framework\Stdlib\DateTime\DateTime
     */
    private $date;

    /**
     * @var ManagerInterface
     */
    private $messageManager;

    /**
     * @var Reader
     */
    private $dirReader;

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * @var \Magento\Cms\Model\ResourceModel\Page\CollectionFactory
     */
    private $pageCollectionFactory;

    /**
     * @var \Magento\Cms\Api\PageRepositoryInterface
     */
    private $pageRepository;

    /**
     * @var \Magento\Cms\Api\Data\PageInterfaceFactory
     */
    private $pageDataFactory;

    /**
     * @var \Magento\Cms\Model\ResourceModel\Block\CollectionFactory
     */
    private $blockCollectionFactory;

    /**
     * @var \Magento\Cms\Api\BlockRepositoryInterface
     */
    private $blockRepository;

    /**
     * @var \Magento\Cms\Api\Data\BlockInterfaceFactory
     */
    private $blockDataFactory;

    /**
     * @var \Magento\Framework\App\Config\Storage\WriterInterface
     */
    private $storageWriter;

    /**
     * @var \Magento\Widget\Model\ResourceModel\Widget\Instance\CollectionFactory
     */
    private $widgetCollectionFactory;

    /**
     * @var \Magento\Widget\Model\Widget\InstanceFactory
     */
    private $widgetFactory;

    /**
     * @var \Magento\Widget\Model\ResourceModel\Widget\InstanceFactory
     */
    private $widgetResourceFactory;

    /**
     * @var \Magento\Theme\Model\Theme\ThemeProvider
     */
    private $themeProvider;

    /**
     * @var \Magento\Theme\Model\ResourceModel\Theme\CollectionFactory
     */
    private $themeCollectionFactory;

    /**
     * @var ModuleDataSetupInterface
     */
    private $setup;

    /**
     * @var \Magento\Theme\Model\Config
     */
    private $themeConfig;

    /**
     * @var ReinitableConfigInterface
     */
    private $reinitableConfig;

    /**
     * @var \Meigee\ThemeActivator\Model\ResourceModel\RemoveWidgetInstances
     */
    private $widgetInstances;

    /**
     * @var SerializerInterface
     */
    private $serializer;

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    public function __construct (
        Dir $moduleDirs,
        \Magento\Framework\Xml\Parser $xmlparser,
        \Magento\Framework\Simplexml\Config $simpleXml,
        \Magento\Framework\Stdlib\DateTime\DateTime $date,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\Module\Dir\Reader $dirReader,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Magento\Cms\Model\ResourceModel\Page\CollectionFactory $pageCollectionFactory,
        \Magento\Cms\Api\PageRepositoryInterface $pageRepository,
        \Magento\Cms\Api\Data\PageInterfaceFactory $pageDataFactory,
        \Magento\Cms\Model\ResourceModel\Block\CollectionFactory $blockCollectionFactory,
        \Magento\Cms\Api\BlockRepositoryInterface $blockRepository,
        \Magento\Cms\Api\Data\BlockInterfaceFactory $blockDataFactory,
        \Magento\Framework\App\Config\Storage\WriterInterface $storageWriter,
        \Magento\Widget\Model\Widget\InstanceFactory $widgetFactory,
        \Magento\Widget\Model\ResourceModel\Widget\Instance\CollectionFactory $widgetCollectionFactory,
        \Magento\Widget\Model\ResourceModel\Widget\InstanceFactory $widgetResourceFactory,
        \Magento\Theme\Model\Theme\ThemeProvider $themeProvider,
        \Magento\Theme\Model\ResourceModel\Theme\CollectionFactory $themeCollectionFactory,
        ModuleDataSetupInterface $setup,
        \Magento\Theme\Model\Config $themeConfig,
        ReinitableConfigInterface $reinitableConfig,
        \Meigee\ThemeActivator\Model\ResourceModel\RemoveWidgetInstances $widgetInstances,
        SerializerInterface $serializer,
        StoreManagerInterface $storeManager
    ) {
        $this->xmlparser = $xmlparser;
        $this->moduleDirs = $moduleDirs;
        $this->simpleXml = $simpleXml;
        $this->date = $date;
        $this->messageManager = $messageManager;
        $this->dirReader = $dirReader;
        $this->scopeConfig = $scopeConfig;
        $this->pageCollectionFactory = $pageCollectionFactory;
        $this->pageRepository = $pageRepository;
        $this->pageDataFactory = $pageDataFactory;
        $this->blockCollectionFactory = $blockCollectionFactory;
        $this->blockRepository = $blockRepository;
        $this->blockDataFactory = $blockDataFactory;
        $this->storageWriter = $storageWriter;
        $this->widgetCollectionFactory = $widgetCollectionFactory;
        $this->widgetFactory = $widgetFactory;
        $this->widgetResourceFactory = $widgetResourceFactory;
        $this->themeProvider = $themeProvider;
        $this->themeCollectionFactory = $themeCollectionFactory;
        $this->setup = $setup;
        $this->themeConfig = $themeConfig;
        $this->reinitableConfig = $reinitableConfig;
        $this->widgetInstances = $widgetInstances;
        $this->serializer = $serializer;
        $this->storeManager = $storeManager;
    }

    /**
     * @param $themeName
     * @param $scopeId
     */
//    TODO: activating theme only for required store. Now is activated for all.
    private function assignTheme($themeName, $scopeId)
    {
        $themes = $this->themeCollectionFactory->create()->loadRegisteredThemes();

        foreach ($themes as $theme) {
            if ($theme->getCode() === $themeName) {
                $this->themeConfig->assignToStore(
                    $theme,
                    [$scopeId],
                    \Magento\Store\Model\ScopeInterface::SCOPE_STORES
                );
            }
        }
        $this->reinitableConfig->reinit();
    }

    /**
     * @param $themeName
     * @param $scopeId
     */
    public function themeInstall($themeName, $scopeId)
    {
        $this->setup->startSetup();
        $this->assignTheme($themeName, $scopeId);
        $this->setup->endSetup();
    }

    /**
     * @param        $pagesOverrideFlag
     * @param        $themeId
     * @param        $scopeId
     * @param string $skin
     *
     * @return bool
     */
    public function setPages ($pagesOverrideFlag, $themeId, $scopeId, $skin = 'default')
    {
        $isHome = false;
        $pages = $this->xmlConfigLoader($themeId, 'pages', $skin);

        if (!is_null($pages) & !is_null($pages['page'])) {
            if (key_exists('title', $pages['page'])) {
                $pages['page'][] = $pages['page'];
                $pages['page'] = array_slice($pages['page'], -1, 1);
            }

            $status = [];
            foreach ($pages['page'] as $page) {
                try {
                    if (array_key_exists('is_home', $page)) {
                        $isHome = true;
                        unset($page['is_home']);
                    }
                    $pageFlag = $this->setPage($page, $pagesOverrideFlag, $themeId, $scopeId);
                    if ($pageFlag) {
                        $status['success'][] = $page['identifier'];
                    } else {
                        $status['error'][] = $page['identifier'];
                    }

                    if ($isHome) {
                        $this->storageWriter->save('web/default/cms_home_page', $page['identifier'],ScopeInterface::SCOPE_STORES, $scopeId);
                        $isHome = false;
                    }
                } catch (\Exception $e) {
                    $status['error'][] = $page['identifier'];
                }

            }

            if (isset($status['success'])) {
                $successfulPages = implode(', ', $status['success']);
                $this->messageManager->addSuccessMessage(__("Following static pages were created: %1", $successfulPages));
            }

            if (isset($status['error'])) {
                $failedPages = implode(', ', $status['error']);
                $this->messageManager->addErrorMessage(__("Following static pages already exist so weren't created: %1", $failedPages));
            }

        }

        return true;
    }

    /**
     * @param        $blocksOverrideFlag
     * @param        $themeId
     * @param        $scopeId
     * @param string $skin
     *
     * @return bool
     */
    public function setBlocks ($blocksOverrideFlag, $themeId, $scopeId, $skin = 'default')
    {
        $blocks = $this->xmlConfigLoader($themeId, 'blocks', $skin);

        if (!is_null($blocks) & !is_null($blocks['block'])) {
            if (key_exists('title', $blocks['block'])) {
                $blocks['block'][] = $blocks['block'];
                $blocks['block'] = array_slice($blocks['block'], -1, 1);
            }

            $status = [];
            foreach ($blocks['block'] as $block) {
                $blockFlag = $this->setBlock($block, $blocksOverrideFlag, $themeId, $scopeId);

                if ($blockFlag) {
                    $status['success'][] = $block['identifier'];
                } else {
                    $status['error'][] = $block['identifier'];
                }
            }

            if (isset($status['success'])) {
                $successfulBlocks = implode(', ', $status['success']);
                $this->messageManager->addSuccessMessage(__("Following static blocks were created: %1", $successfulBlocks));
            }

            if (isset($status['error'])) {
                $failedBlocks = implode(', ', $status['error']);
                $this->messageManager->addErrorMessage(__("Following static blocks already exist so weren't created: %1", $failedBlocks));
            }
        }
        return true;
    }

    /**
     * @param        $widgetInstancesOverrideFlag
     * @param        $themeId
     * @param        $scopeId
     * @param string $skin
     *
     * @return bool
     */
    public function addWidgets($widgetInstancesOverrideFlag, $themeId, $scopeId, $skin = 'default')
    {
        $config = $this->xmlConfigLoader($themeId, 'widgets', $skin);

        if (!is_null($config) & !is_null($config['widget'])) {
            if (key_exists('title', $config['widget'])) {
                $config['widget'][] = $config['widget'];
                $config['widget'] = array_slice($config['widget'], -1, 1);
            }

            $status = [];
            foreach ($config['widget'] as $widgetConfig) {
                if (!array_key_exists(0, $widgetConfig['page_groups'])) {
                    $pageGroups = $widgetConfig['page_groups'];
                    unset($widgetConfig['page_groups']);
                    $widgetConfig['page_groups'][] = $pageGroups;
                }
                $widgetFlag = $this->addWidget($widgetConfig, $themeId, $scopeId, $skin);
                if ($widgetFlag) {
                    $status['success'][] = $widgetConfig['title'];
                } else {
                    $status['error'][] = $widgetConfig['title'];
                }
            }

            if (isset($status['success'])) {
                $successWidgetInstances = implode(', ', $status['success']);
                $this->messageManager->addSuccessMessage(__("Following widget instances were added: %1", $successWidgetInstances));
            }

            if (isset($status['error'])) {
                $failedWidgetInstances = implode(', ', $status['error']);
                $this->messageManager->addErrorMessage(__("Following widget instances already exist so weren't added: %1", $failedWidgetInstances));
            }
        }
        return true;
    }

    /**
     * @param        $themeId
     * @param        $scopeId
     * @param string $skin
     *
     * @return bool
     */
    public function setConfig ($themeId, $scopeId, $skin = 'default')
    {
        $configs = $this->xmlConfigLoader($themeId, 'configs', $skin);

        if (!is_null($configs) & !is_null($configs['config'])) {
            if (key_exists('path', $configs['config'])) {
                $configs['config'][] = $configs['config'];
                $configs['config'] = array_slice($configs['config'], -1, 1);
            }

            foreach ($configs['config'] as $config) {
                $this->storageWriter->save($config['path'], $config['value'], ScopeInterface::SCOPE_STORES, $scopeId);
            }
        }
        $this->setDemoImportedConfig($skin, $scopeId);
        return true;
    }

    /**
     * @param $theme
     * @param $skin
     * @param $locale
     */
    public function setSkinLocaleSet($theme, $skin, $locale)
    {
        $currentConfig = $this->scopeConfig->getValue(ConfigPhp::XML_PATH_SKIN_LOCALE_SET);
        $configToMerge[$theme . '___' . $skin] = $locale;
        if ($currentConfig) {
            $currentConfigArray = $this->serializer->unserialize($currentConfig);
            if (key_exists($theme . '___' . $skin, $currentConfigArray) && $locale == $configToMerge[$theme . '___' . $skin]) {
                unset($currentConfigArray[$theme . '___' . $skin]);
            }
            $config = array_merge($currentConfigArray, $configToMerge);
        } else {
            $config[$theme . '___' . $skin] = $locale;
        }
        $this->storageWriter->save(ConfigPhp::XML_PATH_SKIN_LOCALE_SET, $this->serializer->serialize($config));
    }

    /**
     * @param        $widgetConfig
     * @param        $themeId
     * @param        $scopeId
     * @param string $skin
     *
     * @return bool
     */
    private function addWidget($widgetConfig, $themeId, $scopeId, $skin = 'default')
    {
        $widgetCollection = $this->widgetCollectionFactory->create();
        $widgetCollection->addFieldToFilter('title', ['eq' => $widgetConfig['title']]);
        $widgetCollection->addFieldToFilter('store_ids', ['eq' => [$scopeId]]);

        $pageGroupsBoilerplate = [
            'pages'                 => [
                'block'         => '',
                'for'           => 'all',
                'layout_handle' => '',
                'template'      => 'widget/static_block/default.phtml',
                'page_id'       => '',
            ],
            'all_pages'             => [
                'block'         => '',
                'for'           => 'all',
                'layout_handle' => '',
                'template'      => 'widget/static_block/default.phtml',
                'page_id'       => '',
            ],
            'all_products'          => [
                'block'         => '',
                'for'           => 'all',
                'layout_handle' => 'catalog_product_view',
                'template'      => 'widget/static_block/default.phtml',
                'page_id'       => '',
            ],
            'configurable_products' => [
                'block'         => '',
                'for'           => 'all',
                'layout_handle' => 'catalog_product_view',
                'template'      => 'widget/static_block/default.phtml',
                'page_id'       => '',
            ],
            'anchor_categories'     => [
                'entities'       => '',
                'for'            => 'all',
                'is_anchor_only' => 0,
                'layout_handle'  => 'catalog_category_view_type_layered',
                'template'       => 'widget/static_block/default.phtml',
                'page_id'        => '',
            ],
            'notanchor_categories'  => [
                'entities'       => '',
                'for'            => 'all',
                'is_anchor_only' => 0,
                'layout_handle'  => 'catalog_category_view_type_default',
                'template'       => 'widget/static_block/default.phtml',
                'page_id'        => '',
            ],
            ];

    //        A boilerplate for a widget config
            $widgetBoilerplate = [
                'instance_type'     => 'Magento\Cms\Block\Widget\Block',
                'theme_id'          => $themeId,
                'title'             => '',
                'store_ids'         => $scopeId,
                'widget_parameters' => [],
                'sort_order'        => 1,
                'page_groups'       => [
                    [
                        'page_group' => 'all_pages',
                        'all_pages'  => [
                            'page_id'       => null,
                            'layout_handle' => 'default',
                            'block'         => 'top.container',
                            'for'           => 'all',
                            'template'      => 'widget/static_block/default.phtml',
                        ],
                    ],
                ],
            ];


    //        Merging the page groups data coming from xml with page groups boilerplate for not passing all possible options through xml config
            $i = 0;
            foreach ($widgetConfig['page_groups'] as $group) {
                foreach ($group as $field => $value) {
                    if ($field === 'page_group'){
                        $widgetConfig['page_groups'][$i][$value] = array_replace_recursive($pageGroupsBoilerplate[$value], $widgetConfig['page_groups'][$i][$value]);
                    }
                }
                $i++;
            }
    //        Merging the data coming from xml with the widget boilerplate
            $resultWidgetConfig = array_replace_recursive($widgetBoilerplate, $widgetConfig);

        try {
            $widgetCollectionData = $widgetCollection->getData();

            if(!empty($widgetCollectionData)) {
                $existingWidgetInstances = $widgetCollection->getItems();
                unset($resultWidgetConfig['instance_type']);
                foreach ($existingWidgetInstances as $existingWidgetInstance) {
                    $existingWidgetInstance->setThemeId($resultWidgetConfig['theme_id']);
                    $existingWidgetInstance->setStoreIds($resultWidgetConfig["store_ids"]);
                    $existingWidgetInstance->setWidgetParameters($this->serializer->serialize($resultWidgetConfig["widget_parameters"]));
                    $existingWidgetInstance->setPageGroups($resultWidgetConfig["page_groups"]);
                    $existingWidgetInstance->setSortOrder(1);
                    $existingWidgetInstance->save();
                }
            } else {

                //        Creation widget instance.
                $widgetInstance = $this->widgetFactory->create();

                //        Configuring widget instance type
                $widgetType = $widgetInstance->getWidgetReference('code', $resultWidgetConfig['type'], 'type' );
                $resultWidgetConfig['instance_type'] = $widgetType;
                $widgetInstance->setData($resultWidgetConfig)->save();
            }

        } catch (\Exception $e) {
            $e->getMessage();
        }
        return true;
    }

    /**
     * @param array $pageData
     * @param       $pagesOverrideFlag
     * @param       $themeId
     * @param       $scopeId
     *
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function setPage (array $pageData, $pagesOverrideFlag, $themeId, $scopeId)
    {
        $staticContent = $this->getStaticContent($themeId, $pageData['identifier'], self::CONTENT_TYPE_PAGE);
        $pageCollection = $this->pageCollectionFactory->create();
        $pageCollection->addFieldToFilter('identifier', ['eq' => $pageData['identifier']]);
        $pageCollection->addFieldToFilter('store_id', ['eq' => $scopeId]);
        $existingPage = $pageCollection->getData();

        if (empty($existingPage)) {
            $nePage = $this->pageDataFactory->create();
            $nePage->setData($pageData);
            $nePage->setStoreId([$scopeId]);
            $nePage->setStores([$scopeId]);
            $nePage->setIsActive(true);
            $nePage->setContent($staticContent);
            $this->pageRepository->save($nePage);
        } else {
            $existingPage = $this->pageRepository->getById($pageData['identifier']);
            $existingPage->setTitle($pageData['title']);
            $existingPage->setContent($staticContent);
            $existingPage->save();
        }
        return true;
    }

    /**
     * @param array $blockData
     * @param       $blocksOverrideFlag
     * @param       $themeId
     * @param       $scopeId
     *
     * @return bool
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    private function setBlock (array $blockData, $blocksOverrideFlag, $themeId, $scopeId)
    {
        $staticContent = $this->getStaticContent($themeId, $blockData['identifier'], self::CONTENT_TYPE_BLOCK);
        $blockCollection = $this->blockCollectionFactory->create();
        $blockCollection->addFieldToFilter('identifier', ['eq' => $blockData['identifier']]);
        $blockCollection->addFieldToFilter('store_id', ['eq' => $scopeId]);
        $existingBlock = $blockCollection->getData();

        if (empty($existingBlock)) {
            $newBlock = $this->blockDataFactory->create();
            $newBlock->setData($blockData);
            $newBlock->setStoreId([$scopeId]);
            $newBlock->setStores([$scopeId]);
            $newBlock->setIsActive(true);
            $newBlock->setContent($staticContent);
            $this->blockRepository->save($newBlock);
        } else {
            $existingBlock = $this->blockRepository->getById($blockData['identifier']);
            $existingBlock->setTitle($blockData['title']);
            $existingBlock->setContent($staticContent);
            $existingBlock->save();
        }
        return true;
    }

    /**
     * @param $themeId
     * @param $fileName
     * @param $type
     *
     * @return false|string
     */
    private function getStaticContent ($themeId, $fileName, $type)
    {
        try {
            $themeName = 'Meigee_Sirena';
//            $themeName = $this->getThemePath($themeId);
            $file = $this->dirReader->getModuleDir(\Magento\Framework\Module\Dir::MODULE_VIEW_DIR,$themeName) . DIRECTORY_SEPARATOR . 'ActivationData' . DIRECTORY_SEPARATOR . $type . DIRECTORY_SEPARATOR . $fileName . '.txt';
            if (file_exists($file)){
                $content = file_get_contents($file);
                return $content;
            } else {
                throw new \Exception(__('File %1 wasn\'t found', $file));
            }
        } catch(\Exception $e) {
//            TODO: Finish error messages
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        return true;
    }

    /**
     * @param $themeId
     * @param $node
     * @param $skin
     *
     * @return mixed
     */
    private function xmlConfigLoader($themeId, $node, $skin)
    {
        $moduleName = 'Meigee_Sirena';
        $xmlFile = $this->dirReader->getModuleDir(Dir::MODULE_VIEW_DIR, $moduleName) . DIRECTORY_SEPARATOR . self::ACTIVATION_DATA_DIR  . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . $skin . '.xml';

        try {
            $config = $this->xmlparser->load($xmlFile)->xmlToArray();
            $requiredConfig = $config['default'][$node];
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        return $requiredConfig;
    }

    /**
     * @param $themeId
     *
     * @return bool|mixed|string
     */
    private function getThemePath($themeId) {
        $theme = $this->themeProvider->getThemeById($themeId);
        $themeName = $theme->getData();
        if(isset($themeName['theme_path'])) {
            $themeName = $themeName['theme_path'];
            $themeName = ucwords(str_replace('/', ' ', $themeName));
            $themeName = str_replace(' ', '_', $themeName);

            return $themeName;
        }
        return false;
    }

    /**
     * @param $skin
     * @param $scopeId
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    private function setDemoImportedConfig($skin, $scopeId)
    {
        $currentConfig = $this->scopeConfig->getValue(ConfigPhp::XML_PATH_DEMO_IMPORTED);
        $scopeCode = $this->storeManager->getStore($scopeId)->getCode();
        $skinScope = $skin . '_' . $scopeCode;
        if (!empty($currentConfig)) {
            $currentConfigArray = $this->serializer->unserialize($currentConfig);
            if (!array_search($skinScope, $currentConfigArray)) {
                $currentConfigArray[] = $skinScope;
                $this->storageWriter->save(ConfigPhp::XML_PATH_DEMO_IMPORTED, $this->serializer->serialize($currentConfigArray));
            }
        } else {
            $this->storageWriter->save(ConfigPhp::XML_PATH_DEMO_IMPORTED, $this->serializer->serialize([$skinScope]));
        }
    }
}
