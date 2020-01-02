<?php
namespace Meigee\ThemeActivator\Model\Config;

/**
 * Class ConfigPhp
 * @package Meigee\ThemeActivator\Model\Config
 */
class ConfigPhp {

    const XML_PATH_ACTIVATOR_THEME = 'meigee_activator/theme';
    const XML_PATH_DEMO_IMPORTED = 'meigee_activator/demo_content';
    const XML_PATH_SKIN_LOCALE_SET = 'theme_activator/configuration/skin_locale_set';
    const XML_PATH_CONFIG_THEME = 'theme_activator/activation/theme';
    const XML_PATH_THEME_ID = 'design/theme/theme_id';
    const XML_PATH_LOCALE = 'general/locale/code';

    /**
     * @param $name
     *
     * @return mixed
     */
    public static function getConstantName($name)
    {
        return self::getName($name);
    }

    /**
     * @param $name
     *
     * @return mixed
     */
    private static function getName($name)
    {
        return constant('self::' . $name);
    }
}
