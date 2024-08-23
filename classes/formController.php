<?php

class FormController
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
     * Process form data and insert into the database
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
            'bool' => 'Please select a valid boolean value, check checkbox',
            'array' => 'Please provide a valid array'
        ];

        // Process each field based on its type
        foreach ($objnameType as $objname => $objtype) {
            // Check if the key exists in the $_POST array
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
                        $response['message'] = $errors['string'];
                        return $response;
                    }
                    $response[$objname] = $value;
                    break;

                case 'integer':
                    if ($value === '' || !is_numeric($value)) {
                        $response['success'] = false;
                        $response['message'] = $errors['integer'];
                        return $response;
                    }
                    $response[$objname] = (int) $value;
                    break;

                case 'bool':
                    if ($value == 'false' || $value == '0') {
                        $response['success'] = false;
                        $response['message'] = $errors['bool'];
                        return $response;
                    }
                    $response[$objname] = ($value === 'true' || $value === '1') ? 1 : 0;
                    break;

                case 'array':
                    if (!is_array($value)) {
                        $response['success'] = false;
                        $response['message'] = $errors['array'];
                        return $response;
                    }
                    $response[$objname] = $value;
                    break;

                default:
                    $response[$objname] = $value;
                    break;
            }
        }

        // If no errors, insert data into the database
        if (empty($response['message'])) {
            // Build the query for insertion
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

                // Execute the query
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
     * Delete data from the database table
     * @param string $table Name of the database table
     * @param int $data ID of the data to be deleted
     */
    public function deleteData($tableName, $dataID) {
        $query = "DELETE FROM $tableName WHERE id = $dataID";
        if ($this->db->query($query)) {
            return true;
        } else {
            return false;
        }
    }
}

