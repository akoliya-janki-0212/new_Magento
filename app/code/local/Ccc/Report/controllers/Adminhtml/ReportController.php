<?php
class Ccc_Report_Adminhtml_ReportController extends Mage_Adminhtml_Controller_Action
{

    /**
     * Init actions
     *
     * @return Ccc_Banner_Adminhtml_BannerController
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        $this->loadLayout()
            ->_setActiveMenu('ccc_report/report');
        return $this;
    }

    /**
     * Index action
     */
    public function indexAction()
    {

        // var_dump($this->getLayout());die;
        $this->_title($this->__('Manage_Report'));
        $this->_initAction();
        $this->renderLayout();

        // $block = $this->getLayout()->createBlock('ccc_banner/banner');
        // echo '<pre>';
    }


    // Call the function to set default=true for specified columns

    public function updateAction()
    {
        $checkedColumns = $this->getRequest()->getPost('checkedData');
        $reportHelper = Mage::helper('report/report');
        $XMlReadedData = $reportHelper->getFieldsetData('ccc_report_columns');
        $reportModel = Mage::getModel('ccc_report/report');
        $reportModel->setTempColumns( json_decode($checkedColumns));
        // print_R($reportModel->getTempColumns());
        $responseData = $reportHelper->getJsonData(
            $reportModel->getConnection(
                $reportModel->prepareQuery($XMlReadedData)
            )
        );
        // Return response as JSON
        $this->getResponse()->setHeader('Content-Type', 'application/json');
        $this->getResponse()->setBody($responseData);
    }
    public function urlAction()
    {
        $url = $this->getRequest()->getPost('url');
        $ch = curl_init();

        // Set cURL options
        curl_setopt($ch, CURLOPT_URL, $url); // Specify the URL
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10); // Set connection timeout in seconds

        // Execute the request and fetch the response
        $response = curl_exec($ch);
        // Check for errors
        if (curl_errno($ch)) {
            echo 'Error: ' . curl_error($ch);
        }
        // Close cURL resource
        curl_close($ch);
        // Return response as JSON
        $this->getResponse()->setHeader('Content-Type', 'application/json');
        $this->getResponse()->setBody($response);
    }
}