<?php

namespace App\Controllers;

use App\Models\Db;
use Exception;

class formController
{
    protected $db;
    protected $config;

    // Constructor to initialize configuration and database connection
    public function __construct($dbConfig)
    {
        $this->config = $dbConfig;
        $this->db = Db::getInstance()->getConnection($this->config);
    }

    /**
     * Process form data and insert it into the database
     *
     * @param array $objnameType Associative array with field names and their types
     * @param string $table Name of the database table
     * @param array $fieldMapping Associative array mapping form fields to database columns
     * @return array Result of the processing
     */
    public function insertData(array $objnameType, $table, array $fieldMapping)
    {
        $response = ['success' => false, 'message' => ''];
        $errors = [
            'string' => 'Please fill the text data',
            'integer' => 'Please enter a valid integer',
            'bool' => 'Please select a valid boolean value',
            'array' => 'Please provide a valid array'
        ];

        foreach ($objnameType as $objname => $objtype) {
            if (!isset($_POST[$objname])) {
                $response['success'] = false;
                $response['message'] = "Missing data for $objname.";
                return $response;
            }

            $value = $_POST[$objname];

            switch ($objtype) {
                case 'string':
                    if (!is_string($value) || $value === '') {
                        $response['success'] = false;
                        $response['message'] = $errors['string'] . ' for ' . $objname . '.';
                        return $response;
                    }
                    $response[$objname] = $value;
                    break;

                case 'integer':
                    if ($value === '' || !is_numeric($value)) {
                        $response['success'] = false;
                        $response['message'] = $errors['integer']. ' for '. $objname . '.' ;
                        return $response;
                    }
                    $response[$objname] = (int) $value;
                    break;

                case 'bool':
                    if ($value == 'false' || $value == '0') {
                        $response['success'] = false;
                        $response['message'] = $errors['bool'] . ' for ' . $objname . '.' ;
                        return $response;
                    }
                    $response[$objname] = ($value == 'true' || $value == '1') ? 1 : 0;
                    break;

                case 'array':
                    if (!is_array($value)) {
                        $response['success'] = false;
                        $response['message'] = $errors['array'] . ' for ' . $objname . '.' ;
                        return $response;
                    }
                    $response[$objname] = $value;
                    break;

                default:
                    $response[$objname] = $value;
                    break;
            }
        }

        if (empty($response['message'])) {
            $columns = [];
            $placeholders = [];
            $values = [];

            foreach ($fieldMapping as $formField => $dbColumn) {
                if (isset($response[$formField])) {
                    $columns[] = $dbColumn;
                    $placeholders[] = '?';
                    $values[] = $response[$formField];
                }
            }

            if (count($columns) > 0) {
                $query = "INSERT INTO $table (" . implode(", ", $columns) . ") VALUES (" . implode(", ", $placeholders) . ")";

                if ($this->db->query($query, $values)) {
                    $response['success'] = true;
                    $response['message'] = 'Data successfully saved.';
                } else {
                    $response['message'] = 'Failed to save data.';
                }
            } else {
                $response['message'] = 'No valid data to insert.';
            }
        }

        return $response;
    }

    /**
     * Delete data from the database
     * @param string $tableName Name of the database table
     * @param int $dataID ID of the data to be deleted
     * @return bool Success of the deletion
     */
    public function deleteData($tableName, $dataID)
    {
        $query = "DELETE FROM $tableName WHERE id = $dataID";
        return $this->db->query($query);
    }

    /**
    * Update the visibility of data in the table
    * @param string $tableName Name of the database table
    * @param string $flag Visibility status
    * @param int $dataID ID of the data to be updated
    * @return bool Success of the update
    */
    public function deleteDataView($tableName, $flag, $dataID)
    {
        $query = "UPDATE `$tableName` SET `$flag` = ? WHERE `id` = ?";
        $params = [0, $dataID];

        return $this->db->query($query, $params);
    }

    /**
    * Edit table data
    * @param string $tableName Name of the database table
    * @param array $data Array of data to be edited
    * @param int $id ID of the data to be edited
    * @return bool Success of the edit
    */
    public function editTable(string $tableName, array $data, int $id)
    {
        $set = [];
        $params = [];

        foreach ($data as $key => $value) {
            $set[] = " `$key` = ?";
            $params[] = $value;
        }

        $setString = implode(', ', $set);
        $query = "UPDATE `$tableName` SET $setString WHERE `id` = ?";
        $params[] = $id; 

        return $this->db->query($query, $params);
    }
}

