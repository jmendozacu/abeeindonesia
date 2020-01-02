<?php
namespace Meigee\ThemeActivator\Observer;

use Magento\Framework\Event\Observer;

class ThemeActivation implements \Magento\Framework\Event\ObserverInterface
{
    const XML_PATH_OVERRIDE_PAGES = 'theme_activation/general/pages_override';
    const XML_PATH_OVERRIDE_BLOCKS = 'theme_activation/general/blocks_override';

    private $request;
    private $scopeConfig;
    private $staticContent;
    private $themeProvider;
    private $themeCollectionFactory;
    private $reinitableConfig;
    private $indexerRegistry;
    private $typeList;
    private $storeRepository;

    public function __construct (
        \Magento\Framework\App\RequestInterface $request,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfig,
        \Meigee\ThemeActivator\Model\Generate\StaticContent $staticContent,
        \Magento\Theme\Model\Theme\ThemeProvider $themeProvider,
        \Magento\Theme\Model\ResourceModel\Theme\CollectionFactory $themeCollectionFactory,
        \Magento\Framework\App\Config\ReinitableConfigInterface $reinitableConfig,
        \Magento\Framework\Indexer\IndexerRegistry $indexerRegistry,
        \Magento\Framework\App\Cache\TypeListInterface $typeList,
        \Magento\Store\Api\StoreRepositoryInterface $storeRepository
    ) {
        $this->request = $request;
        $this->scopeConfig = $scopeConfig;
        $this->staticContent = $staticContent;
        $this->themeProvider = $themeProvider;
        $this->themeCollectionFactory = $themeCollectionFactory;
        $this->reinitableConfig = $reinitableConfig;
        $this->indexerRegistry = $indexerRegistry;
        $this->typeList = $typeList;
        $this->storeRepository = $storeRepository;
    }

    /**
     * @param Observer $observer
     *
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Store\Model\StoreIsInactiveException
     */
    public function execute (Observer $observer)
    {
        $params = $this->request->getParams();

            if (isset($params["activate_row"])) {
                $themeLocalSkinParam = $params['groups'][$params["activate_row"]];
                $storeId = $this->storeRepository->getActiveStoreByCode($themeLocalSkinParam['storeCode'])->getId();
                $themeId = $this->themeCollectionFactory->create()->getThemeByFullPath('frontend/' . $themeLocalSkinParam['theme'])->getData('theme_id');

                $this->staticContent->setSkinLocaleSet(str_replace('/', '_', $themeLocalSkinParam['theme']), $themeLocalSkinParam['skin'], $themeLocalSkinParam['locale']);

                $this->reinitableConfig->reinit();
                $this->indexerRegistry->get(\Magento\Theme\Model\Data\Design\Config::DESIGN_CONFIG_GRID_INDEXER_ID)->reindexAll();
                $this->cleanCache();
            }

            if (isset($params["import_static_content"])) {
                $themeLocalSkinParam = $params['groups'][$params["import_static_content"]];
                $themeId = $this->themeCollectionFactory->create()->getThemeByFullPath('frontend/' . $themeLocalSkinParam['theme'])->getData('theme_id');
                $storeId = $this->storeRepository->getActiveStoreByCode($themeLocalSkinParam['storeCode'])->getId();

                $this->staticContent->setConfig($themeId, $storeId, $themeLocalSkinParam['skin']);
                $this->staticContent->setPages(1, $themeId, $storeId, $themeLocalSkinParam['skin']);
                $this->staticContent->setBlocks(1, $themeId, $storeId, $themeLocalSkinParam['skin']);
                $this->staticContent->addWidgets(1, $themeId, $storeId, $themeLocalSkinParam['skin']);

                $this->reinitableConfig->reinit();
                $this->indexerRegistry->get(\Magento\Theme\Model\Data\Design\Config::DESIGN_CONFIG_GRID_INDEXER_ID)->reindexAll();
                $this->cleanCache();
            }
    }

    /**
     *
     */
    public function cleanCache()
    {
        $types = ['config', 'layout', 'block_html', 'full_page'];
        foreach ($types as $type)
        {
            $this->typeList->cleanType($type);
        }
    }
}
