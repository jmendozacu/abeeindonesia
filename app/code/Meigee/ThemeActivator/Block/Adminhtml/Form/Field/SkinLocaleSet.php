<?php
namespace Meigee\ThemeActivator\Block\Adminhtml\Form\Field;

use Magento\Config\Block\System\Config\Form\Field\FieldArray\AbstractFieldArray;
use Magento\Framework\DataObject;

class SkinLocaleSet extends AbstractFieldArray
{
    /**
     * @var null
     */
    private $megaOptionsRenderer = null;

    /**
     * @var null
     */
    private $localesRenderer = null;

    /**
     * @var null
     */
    private $activateButtonRenderer = null;

    /**
     * @return \Magento\Framework\View\Element\BlockInterface|null
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function getLocalesRenderer()
    {
        if(!$this->localesRenderer) {
            $this->localesRenderer = $this->getLayout()->createBlock(
                \Meigee\ThemeActivator\Block\Adminhtml\Form\Field\Locales::class,
                '',
                [
                    'data' => ['is_render_to_js_template' => true]
                ]
            );
        }
        return $this->localesRenderer;
    }

    /**
     * @return \Magento\Framework\View\Element\BlockInterface|null
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function getMegaOptionsRenderer()
    {
        if (!$this->megaOptionsRenderer) {
            $this->megaOptionsRenderer = $this->getLayout()->createBlock(
                \Meigee\ThemeActivator\Block\Adminhtml\Form\Field\Skins::class,
                '',
                [
                    'data' => ['is_render_to_js_template' => true]
                ]
            );
        }
        return $this->megaOptionsRenderer;
    }

    /**
     * @return mixed
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function getActivateButtonRenderer()
    {
        if(!$this->activateButtonRenderer) {
            $this->activateButtonRenderer = $this->getLayout()->createBlock(
                \Meigee\ThemeActivator\Block\Adminhtml\Form\Field\ActivateButton::class,
                '',
                [
                    'data' => ['is_render_to_js_template' => true]
                ]
            );
        }
        return $this->activateButtonRenderer->setTemplate('Magento_Catalog::product/list/addto/compare.phtml');
    }

    /**
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareToRender()
    {
        $this->addChild(
            'confirm_deletion_button',
            \Magento\Backend\Block\Widget\Button::class,
            ['label' => __('Delete Store'), 'onclick' => "deleteForm.submit()", 'class' => 'cancel']
        );
        $this->addColumn(
            'mega_options', [
                'label' => __('Theme and Skin'),
                'renderer' => $this->getMegaOptionsRenderer()
            ]
        );
        $this->addColumn(
            'available_locales', [
                'label' => __('Store and Locale'),
                'renderer' => $this->getLocalesRenderer()
            ]
        );
        $this->_addAfter = false;
        $this->_addButtonLabel = __('Add Another Pair');
    }

    /**
     * @param DataObject $row
     *
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareArrayRow(DataObject $row)
    {

        $megaOptions = $row->getData('mega_options');
        $options = [];

        if ($megaOptions) {

            $options['option_' . $this->getMegaOptionsRenderer()->calcOptionHash($megaOptions)]
                = 'selected="selected"';
            $availableLocales = $row->getData('available_locales');
            $options['option_' . $this->getLocalesRenderer()->calcOptionHash($availableLocales)]
                = 'selected="selected"';
        }
        $row->setData('option_extra_attrs', $options);
    }
}
