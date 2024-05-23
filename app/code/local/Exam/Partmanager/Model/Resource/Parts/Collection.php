<?php
class Exam_Partmanager_Model_Resource_Parts_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    protected function _construct()
    {
        $this->_init('exam_partmanager/parts');
    }
}
