<?php
namespace Meigee\ThemeActivator\Config\Backend;

use Magento\Framework\App\Cache\TypeListInterface;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\Config\Value as ConfigValue;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\Math\Random;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;
use Magento\Framework\Serialize\Serializer\Json;

class SkinLocaleSet extends ConfigValue
{
    /**
     * @var Random
     */
    protected $mathRandom;

    /**
     * @var mixed
     */
    protected $serializer;

    /**
     * SkinLocaleSet constructor.
     *
     * @param Context               $context
     * @param Registry              $registry
     * @param ScopeConfigInterface  $config
     * @param TypeListInterface     $cacheTypeList
     * @param Random                $mathRandom
     * @param AbstractResource|null $resource
     * @param AbstractDb|null       $resourceCollection
     * @param array                 $data
     * @param Json|null             $serializer
     */
    public function __construct(
        Context $context,
        Registry $registry,
        ScopeConfigInterface $config,
        TypeListInterface $cacheTypeList,
        Random $mathRandom,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = [],
        Json $serializer = null
    ) {
        $this->mathRandom = $mathRandom;
        $this->serializer = $serializer ?: \Magento\Framework\App\ObjectManager::getInstance()
            ->get(Json::class);
        parent::__construct($context, $registry, $config, $cacheTypeList, $resource, $resourceCollection, $data);
    }

    /**
     * @return $this|ConfigValue
     */
    public function beforeSave()
    {
        $value = $this->getValue();
        if (!is_array($value)) {
            try {
                $value = $this->serializer->unserialize($value);
            } catch (\InvalidArgumentException $e) {
                $value = [];
            }
        }
        $result = [];
        foreach ($value as $data) {
            if (empty($data['mega_options']) || empty($data['available_locales'])) {
                continue;
            }
            $megaOptions = $data['mega_options'];
            if (array_key_exists($megaOptions, $result)) {
                $result[$megaOptions] = $this->appendUniqueOptions($result[$megaOptions], $data['available_locales']);
            } else {
                $result[$megaOptions] = $data['available_locales'];
            }
            $result['is_activated'] = $data['is_activated'];
        }
        $this->setValue($this->serializer->serialize($result));

//      A trick to be able to save global values on the store view scope only.
//      This needed because activation works only for store views, however configuring "Theme and Skin" and	"Store and Locale" options is available on the global level.
//      Anyway those options must be available on the same scope (Store view)

        $this->setScopeId(0);
        $this->setScope('default');
        return $this;
    }

    /**
     * @return $this|ConfigValue
     */
    public function afterLoad()
    {
        if ($this->getValue()) {
            $value = $this->serializer->unserialize($this->getValue());
            if (is_array($value)) {
                $this->setValue($this->encodeArrayFieldValue($value));
            }
        }
        return $this;
    }

    /**
     * @param array $value
     *
     * @return array
     */
    protected function encodeArrayFieldValue(array $value)
    {
        $result = [];
        foreach ($value as $megaOptions => $locales) {
            $id = $this->mathRandom->getUniqueHash('_');
            $result[$id] = ['mega_options' => $megaOptions, 'available_locales' => $locales];
        }
        return $result;
    }

    /**
     * @param array $megaOptionsList
     * @param array $locales
     *
     * @return array
     */
    private function appendUniqueOptions(array $megaOptionsList, array $locales)
    {
        $result = array_merge($megaOptionsList, $locales);
        return array_values(array_unique($result));
    }
}
