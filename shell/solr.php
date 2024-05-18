<?php

require_once 'abstract.php';

class Shell_Solr extends Mage_Shell_Abstract
{
  /**
   * Run script
   *
   * @return void
   */
  public function run()
  {
    //deleting doc
    // $curlCommand = 'curl "http://localhost:8983/solr/jsonreport/update?commit=true" -H "Content-Type: text/xml" --data-binary "<delete><query>*:*</query></delete>"';
    // exec($curlCommand, $output, $returnCode);
    $curl = curl_init();

    curl_setopt_array(
      $curl,
      array(
        CURLOPT_URL => 'http://localhost:8983/solr/jsonreport/update?commitWithin=1000&overwrite=true&wt=json',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $this->prepareData(),
        CURLOPT_HTTPHEADER => array(
          'Content-Type: application/json'
        ),
      )
    );

    $response = curl_exec($curl);

    curl_close($curl);
    echo $response;
  }
  public function prepareData()
  {
    $reportHelper = Mage::helper('report/report');
    $XMlReadedData = $reportHelper->getFieldsetData('ccc_report_columns');
    $reportModel = Mage::getSingleton('ccc_report/report');
    return $this->prepareDataForSolr(
      $reportHelper->getJsonData(
        $reportModel->getConnection(
          $reportModel->prepareQuery($XMlReadedData)
        )
      )
    );
  }
  public function prepareDataForSolr($jsonData)
  {
    $jsonArray = json_decode($jsonData, true);
    $prepareRow = function ($row) {
      $prepareValue = function ($value, $key) {
        // if (strpos($key, '_id') !== false)
        //   return $key;
        $prefix = $this->preparePrefix($value);
        return $key . $prefix;

      };
      return array_combine(
        array_map($prepareValue, $row, array_keys($row)),
        $row
      );
    };
    $preparedData = array_map($prepareRow, $jsonArray);
    return json_encode($preparedData);
  }
  public function preparePrefix($value)
  {
    if (is_numeric($value) && is_string($value)) {
      if (preg_match('/^-?[0-9]+(\.[0-9]+)?$/', $value)) {
        if (strpos($value, '.') !== false || strpos($value, 'E') !== false) {
          return '_f';
        } else {
          return '_i';
        }
      }
    } elseif (is_bool($value)) {
      return '_b';
    } elseif (is_string($value)) {
      return '_s';
    } else {
      return ' ';
    }

  }
}

$shell = new Shell_Solr();
$shell->run();
