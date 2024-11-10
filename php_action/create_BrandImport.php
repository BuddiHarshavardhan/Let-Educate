<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// Include PHPExcel
require_once __DIR__ . '/../libraries/PHPExcel/Classes/PHPExcel.php';

$valid = array('success' => false, 'messages' => array());

if ($_FILES && isset($_FILES['brandfile'])) {
    // Allowed file types and mime types
    $allowedTypes = array('csv', 'xls', 'xlsx');
    $allowedMimeTypes = array(
        'text/csv',
        'application/vnd.ms-excel',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
    );

    // Get file information
    $filename = $_FILES['brandfile']['name'];
    $type = pathinfo($filename, PATHINFO_EXTENSION);
    $mimeType = mime_content_type($_FILES['brandfile']['tmp_name']);

    // Check if file type and mime type are allowed
    if (in_array($type, $allowedTypes) && in_array($mimeType, $allowedMimeTypes)) {
        // Generate unique file URL
        $url = __DIR__ . '/../assets/myimages/' . uniqid(rand(), true) . '.' . $type;

        // Move uploaded file to destination
        if (move_uploaded_file($_FILES['brandfile']['tmp_name'], $url)) {
            try {
                // Load the spreadsheet
                if ($type === 'csv') {
                    $objReader = PHPExcel_IOFactory::createReader('CSV');
                } elseif ($type === 'xls') {
                    $objReader = PHPExcel_IOFactory::createReader('Excel5');
                } else {
                    $objReader = PHPExcel_IOFactory::createReader('Excel2007');
                }
                $spreadsheet = $objReader->load($url);
            } catch (Exception $e) {
                $valid['messages'][] = "Error loading file: " . $e->getMessage();
                echo json_encode($valid);
                exit;
            }

            // Get the active sheet
            $sheet = $spreadsheet->getActiveSheet();
            $highestRow = $sheet->getHighestRow();
            $no_error_data = array();

            // Iterate through rows and validate data
            for ($row = 2; $row <= $highestRow; $row++) {
                $rowData = $sheet->rangeToArray('A' . $row . ':B' . $row, NULL, TRUE, FALSE);
                if (!empty($rowData[0][0]) && !empty($rowData[0][1])) {
                    $no_error_data[] = $rowData[0];
                } else {
                    $valid['messages'][] = "Row $row has missing data.";
                }
            }

            // Process validated data
            if (!empty($no_error_data)) {
                require_once __DIR__ . '/core.php'; // Ensure the correct path to core.php for the database connection

                foreach ($no_error_data as $value) {
                    $brand_name = $value[0];
                    $brand_active = $value[1]; // Properly assign brand_active

                    // Check if brand already exists
                    $stmt = $connect->prepare("SELECT * FROM brands WHERE brand_name = ?");
                    $stmt->bind_param("s", $brand_name);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows == 0) {
                        // Insert new brand if it doesn't exist
                        $insert_stmt = $connect->prepare("INSERT INTO brands (brand_name, brand_active) VALUES (?, ?)");
                        $insert_stmt->bind_param("ss", $brand_name, $brand_active);

                        if ($insert_stmt->execute()) {
                            $valid['success'] = true;
                            $valid['messages'][] = "Brand '$brand_name' successfully added.";
                        } else {
                            $valid['messages'][] = "Error while adding the brand '$brand_name': " . $connect->error;
                        }

                        $insert_stmt->close();
                    } else {
                        $valid['messages'][] = "Brand '$brand_name' already exists.";
                    }

                    $stmt->close();
                }

                // Redirect after processing
                header('Location: ../call.php');
                exit;
            }
        } else {
            $valid['messages'][] = "Error moving uploaded file.";
        }
    } else {
        $valid['messages'][] = "Invalid file type. Only CSV, XLS, and XLSX files are allowed.";
    }
} else {
    $valid['messages'][] = "No file uploaded.";
}

// Output JSON response
echo json_encode($valid);
?>
