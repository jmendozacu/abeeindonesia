<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

namespace Meigee\ThemeActivator\Css\PreProcessor\Instruction;

use Magento\Framework\View\Asset\LocalInterface;
use Magento\Framework\View\Asset\NotationResolver;
use Magento\Framework\View\Asset\PreProcessorInterface;
use Magento\Framework\Css\PreProcessor\FileGenerator\RelatedGenerator;
use Magento\Framework\View\Asset\PreProcessor\Chain;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Module\Dir\Reader;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Module\Dir;
use Magento\Framework\Filesystem\Directory\ReadFactory;
use Magento\Framework\View\Asset\File\FallbackContextFactory;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Theme\Model\Config\Customization;
use Meigee\ThemeActivator\Model\Config\ConfigPhp;

/**
 * 'import' instruction preprocessor
 */
class Import extends \Magento\Framework\Css\PreProcessor\Instruction\Import implements PreProcessorInterface
{
    /**
     * Pattern of 'import' instruction
     */
    const REPLACE_PATTERN =
        '#@import[\s]*'
        .'(?P<start>[\(\),\w\s]*?[\'\"][\s]*)'
        .'(?P<path>[^\)\'\"]*?)'
        .'(?P<end>[\s]*[\'\"][\s\w]*[\)]?)[\s]*;#';

    /**
     * @var \Magento\Framework\View\Asset\NotationResolver\Module
     */
    private $notationResolver;

    /**
     * @var array
     */
    protected $relatedFiles = [];

    /**
     * @var RelatedGenerator
     */
    private $relatedFileGenerator;

    private $scopeConfig;
    private $dirReader;
    private $rootDir;
    private $directoryList;
    private $fallbackContext;
    private $storeManager;
    private $storeManager2;
    private $localeREsolver;
    private $customization;
    private $themeDesign;
    private $xmlparser;
    private $themeProvider;

    /**
     * Constructor
     *
     * @param NotationResolver\Module $notationResolver
     * @param RelatedGenerator $relatedFileGenerator
     */
    public function __construct(
        NotationResolver\Module $notationResolver,
        RelatedGenerator $relatedFileGenerator,
        ScopeConfigInterface $scopeConfig,
        Reader $dirReader,
        ReadFactory $rootDir,
        DirectoryList $directoryList,
        FallbackContextFactory $fallbackContext,
        \Magento\Store\Api\Data\StoreInterface $storeManager,
        \Magento\Framework\Locale\Resolver $localeREsolver,
        \Magento\Store\Model\StoreManagerInterface $storeManager2,
        Customization $customization,
        \Magento\Framework\View\Design\ThemeInterface $themeDesign,
        \Magento\Framework\Xml\Parser $xmlparser,
        \Magento\Theme\Model\Theme\ThemeProvider $themeProvider
    ) {
        $this->notationResolver = $notationResolver;
        $this->relatedFileGenerator = $relatedFileGenerator;
        $this->scopeConfig = $scopeConfig;
        $this->dirReader = $dirReader;
        $this->rootDir = $rootDir;
        $this->directoryList = $directoryList;
        $this->fallbackContext = $fallbackContext;
        $this->storeManager = $storeManager;
        $this->storeManager2 = $storeManager2;
        $this->localeREsolver = $localeREsolver;
        $this->customization = $customization;
        $this->themeDesign = $themeDesign;
        $this->xmlparser = $xmlparser;
        $this->themeProvider = $themeProvider;
    }

    /**
     * {@inheritdoc}
     */
    public function process(Chain $chain)
    {
        $asset = $chain->getAsset();
        $contentType = $chain->getContentType();
        $replaceCallback = function ($matchContent) use ($asset, $contentType) {
            return $this->replace($matchContent, $asset, $contentType);
        };

        $file = $asset->getFilePath();

        $configTheme = $this->scopeConfig->getValue(ConfigPhp::XML_PATH_SKIN_LOCALE_SET);
        if (!empty($configTheme)) {

            $configTheme = json_decode($configTheme, true);
            $configTheme2 = [];
            foreach ($configTheme as $config => $value) {
                $configArray = explode('___', $config);
                $configTheme2 [$configArray[0]][$value] = $configArray[1];
            }

            $currLocale = $chain->getAsset()->getContext()->getLocale();
            $currThemeName = str_replace('/', '_', $chain->getAsset()->getContext()->getThemePath());

            if (array_key_exists($currThemeName, $configTheme2) && array_key_exists($currLocale, $configTheme2[$currThemeName])) {

/**
 *
 * TODO: move rtl option here to get loaded rtl.less only if needed
 * NOTE: may be used for loading less files dynamically based on xml config ( app/code/Meigee/XXX/view/ActivationData/config/default.xml )
 *<files>
 *  <colors>_skin_colors.less</colors>
 *  <custom>_skin_custom.less</custom>
 *  <rtl>_theme_rtl.less</rtl>
 *</files>
 */
//                $files = $this->xmlConfigLoader($currThemeName, 'files',$configArray[1]);
                $files = [
                    'colors' => '_skin_colors.less',
                    'custom' => '_skin_custom.less',
                ];
                foreach ($files as $id => $value) {
                    if (strpos($file, $value)) {
                        $newFile =str_replace('_skin_' . $id, '_' . $configTheme2[$currThemeName][$currLocale]  . '_' . $id, $chain->getOrigAssetPath()) ;

                        if (file_exists($newFile)){
                            $chain->setContent(file_get_contents($newFile));
                            break;
                        }
                    }
                }

            }

        }

        $content = $this->removeComments($chain->getContent());

        $processedContent = preg_replace_callback(self::REPLACE_PATTERN, $replaceCallback, $content);
        $this->relatedFileGenerator->generate($this);
        if ($processedContent !== $content) {
            $chain->setContent($processedContent);
        }
    }

    private function xmlConfigLoader($themeId, $node, $skin)
    {
        $moduleName = $this->getThemePath($themeId);
        $xmlFile = $this->dirReader->getModuleDir(Dir::MODULE_VIEW_DIR, $moduleName) . DIRECTORY_SEPARATOR . 'ActivationData' . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . $skin . '.xml';

        try {
            $config = $this->xmlparser->load($xmlFile)->xmlToArray();
            $requiredConfig = $config['default'][$node];
        } catch (\Exception $e) {
            echo $e->getMessage();
        }
        return $requiredConfig;
    }

    private function getThemePath($themeId) {
        $theme = $this->themeProvider->getThemeByFullPath('frontend/' . $themeId);
        $themeName = $theme->getData();
        if(isset($themeName['theme_path'])) {
            $themeName = $themeName['theme_path'];
            $themeName = ucwords(str_replace('/', ' ', $themeName));
            $themeName = str_replace(' ', '_', $themeName);

            return $themeName;
        }
        return false;
    }

    private function getThemeConfig()
    {
        $stores = $this->storeManager2->getStores();
        $themePairs = [];
        foreach ($stores as $store) {
            $theme = $this->scopeConfig->getValue(ConfigPhp::XML_PATH_SKIN_LOCALE_SET,\Magento\Store\Model\ScopeInterface::SCOPE_STORE, $store->getData('store_id'));
            $locale = $this->scopeConfig->getValue('general/locale/code', \Magento\Store\Model\ScopeInterface::SCOPE_STORE, $store->getData('store_id'));
            if (!empty($theme)) {
                $themePairs[$theme] = $locale;
            }
        }
        return $themePairs;
    }

    /**
     * Returns the content without commented lines
     *
     * @param string $content
     * @return string
     */
    private function removeComments($content)
    {
        return preg_replace("#(^\s*//.*$)|((^\s*/\*(?s).*?(\*/)(?!\*/))$)#m", '', $content);
    }

    /**
     * Retrieve information on all related files, processed so far
     *
     * BUG: this information about related files is not supposed to be in the state of this object.
     * This class is meant to be a service (shareable instance) without such a transient state.
     * The list of related files needs to be accumulated for the preprocessor,
     * because it uses a 3rd-party library, which requires the files to physically reside in the base same directory.
     *
     * @return array
     */
    public function getRelatedFiles()
    {
        return $this->relatedFiles;
    }

    /**
     * Clear the record of related files, processed so far
     *
     * @return void
     */
    public function resetRelatedFiles()
    {
        $this->relatedFiles = [];
    }

    /**
     * Add related file to the record of processed files
     *
     * @param string $matchedFileId
     * @param LocalInterface $asset
     * @return void
     */
    protected function recordRelatedFile($matchedFileId, LocalInterface $asset)
    {
        $this->relatedFiles[] = [$matchedFileId, $asset];
    }

    /**
     * Return replacement of an original @import directive
     *
     * @param array $matchedContent
     * @param LocalInterface $asset
     * @param string $contentType
     * @return string
     */
    protected function replace(array $matchedContent, LocalInterface $asset, $contentType)
    {
        $matchedFileId = $this->fixFileExtension($matchedContent['path'], $contentType);

        $start = $matchedContent['start'];
        $end = $matchedContent['end'];
        if (strpos(trim($start), 'url') !== 0) {
            $this->recordRelatedFile($matchedFileId, $asset);
        }

        $resolvedPath = $this->notationResolver->convertModuleNotationToPath($asset, $matchedFileId);

        return "@import {$start}{$resolvedPath}{$end};";
    }

    /**
     * Resolve extension of imported asset according to exact format
     *
     * @param string $fileId
     * @param string $contentType
     * @return string
     * @link http://lesscss.org/features/#import-directives-feature-file-extensions
     */
    protected function fixFileExtension($fileId, $contentType)
    {
        if (!pathinfo($fileId, PATHINFO_EXTENSION)) {
            $fileId .= '.' . $contentType;
        }
        return $fileId;
    }
}
