<?php
class Exam_Reportmanager_Adminhtml_ReportmanagerController extends Mage_Adminhtml_Controller_Action
{
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('system');
        return $this;
    }
    public function indexAction()
    {
        $this->_title($this->__('Manager Report'));
        $this->_initAction();
        $this->renderLayout();
    }
    public function saveReportAction()
    {
        $filters = $this->getRequest()->getParam('filters');
        $reportType = $this->getRequest()->getParam('reportType');
        $userId = Mage::getSingleton('admin/session')->getUser()->getId();
        try {
            $report = Mage::getModel('exam_reportmanager/report');
            $existingReport = $report->getCollection()
                ->addFieldToFilter('user_id', $userId)
                ->addFieldToFilter('report_type', $reportType)
                ->getFirstItem();
            if ($existingReport && $existingReport->getId()) {
                $report->load($existingReport->getId());
                $report->setFilterData(json_encode($filters))
                    ->save();
                if ($report->getId()) {
                    $this->getResponse()->setBody(Mage::helper('core')->jsonEncode(array('success' => true, 'message' => 'Report updated successfully.')));
                } else {
                    $this->getResponse()->setBody(Mage::helper('core')->jsonEncode(array('success' => false, 'message' => 'Error saving report.')));
                }
            } else {
                $report->setUserId($userId)
                    ->setFilterData(json_encode($filters))
                    ->setReportType($reportType)
                    ->setIsActive(1)
                    ->save();
                if ($report->getId()) {
                    $this->getResponse()->setBody(Mage::helper('core')->jsonEncode(array('success' => true, 'message' => 'Report saved successfully.')));
                } else {
                    $this->getResponse()->setBody(Mage::helper('core')->jsonEncode(array('success' => false, 'message' => 'Error saving report.')));
                }
            }
        } catch (Exception $e) {
            Mage::logException($e);
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode(array('success' => false, 'message' => $e->getMessage())));
        }
    }
    public function loadReportAction()
    {
        $reportType = $this->getRequest()->getParam('reportType');
        $userId = Mage::getSingleton('admin/session')->getUser()->getId();
        try {
            $report = Mage::getModel('exam_reportmanager/report')->getCollection()
                ->addFieldToFilter('user_id', $userId)
                ->addFieldToFilter('report_type', $reportType)
                ->getFirstItem();
            if ($report->getIsActive() == 1) {
                $this->getResponse()->setBody(Mage::helper('core')
                    ->jsonEncode(array('success' => true, 'message' => 'filters loaded', 'filters' => $report->getFilterData())));
            }
        } catch (Exception $e) {
            Mage::logException($e);
            $this->getResponse()->setBody(Mage::helper('core')->jsonEncode(array('success' => false, 'message' => $e->getMessage())));
        }
    }
    public function loadAction()
    {
        $this->_initAction();
        $this->renderLayout();
    }
}