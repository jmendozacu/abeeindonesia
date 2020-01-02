<?php
namespace Meigee\ThemeActivator\Model\ResourceModel;

/**
 * Class RemoveWidgetInstances
 * @package Meigee\ThemeActivator\Model\ResourceModel
 */
class RemoveWidgetInstances extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    public function _construct()
    {
        $this->_init('widget_instance', 'instance_id');
    }

    /**
     * @param $title
     * @param $scopeId
     */
    public function deleteWidgetInstancePages($title, $scopeId)
    {
        $connection = $this->getConnection();
        $inCond = $connection->prepareSqlCondition('title', ['eq' => $title]);
        $inCond2 = $connection->prepareSqlCondition('store_ids', ['eq' => $scopeId]);
        $connection->delete($this->getTable('widget_instance'), $inCond . ' AND ' . $inCond2);
    }
}
