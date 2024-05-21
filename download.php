<?php
// Include the PhpSpreadsheet library
require 'vendor/autoload.php';

// Add your new 'use' statements here
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

// Check if the form is submitted
if (isset($_POST['downloadAttendance'])) {
    // Fetch the Subject_ID from the form
    $Subject_ID = $_POST['Subject_ID'];

    // Fetch details from the database
    $servername = "localhost";
    $username_db = "zaid";
    $password_db = "1234";
    $dbname = "attendance";

    // Create connection
    $conn = new mysqli($servername, $username_db, $password_db, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Fetch data from the MySQL table
    $sqlData = "SELECT * FROM $Subject_ID";
    $resultData = $conn->query($sqlData);

    // Create a new PhpSpreadsheet instance
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Fetch the subject name from the database
    $sqlSubject = "SELECT Subject_Name, Course_ID,Teacher_ID FROM subjects WHERE Subject_ID = '$Subject_ID'";
    $resultSubject = $conn->query($sqlSubject);
    $subjectRow = $resultSubject->fetch_assoc();
    $subjectName = $subjectRow['Subject_Name'];
    $Course_ID = $subjectRow['Course_ID'];
    $Teacher_ID = $subjectRow['Teacher_ID'];

    // Fetch additional details from other tables as needed...

    // Rest of your code...


$sqlTeacher="SELECT Full_Name from teachers where Teacher_ID = '$Teacher_ID'";
$resultTeacher = $conn->query($sqlTeacher);
$teacherRow = $resultTeacher->fetch_assoc();
$teacherName = $teacherRow["Full_Name"];

$sqlCourse="SELECT Name, Department_ID from Courses where Course_ID='$Course_ID'";
$resultCourse = $conn->query($sqlCourse);
$courseRow = $resultCourse->fetch_assoc();
$courseName= $courseRow["Name"];
$Department_ID=$courseRow["Department_ID"];

$sqlDepartment="SELECT Department_Name from department where Department_ID ='$Department_ID'";
$resultDepartment = $conn->query($sqlDepartment);
$departmentRow = $resultDepartment->fetch_assoc();
$DepartmentName= $departmentRow["Department_Name"];

// Create a new row above the table for the subject name
$sheet->insertNewRowBefore(1, 1);
$sheet->mergeCells('A1:K1');
$sheet->setCellValue('A1', "Department: ");
$sheet->getStyle('A1')->getFont()->setBold(true)->setSize(15);
$sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

$sheet->mergeCells('L1:V1');
$sheet->setCellValue('L1', $DepartmentName);
$sheet->getStyle('L1')->getFont()->setBold(true)->setSize(15);
$sheet->getStyle('L1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

$sheet->mergeCells('A2:K2');
$sheet->setCellValue('A2', "Course: ");
$sheet->getStyle('A2')->getFont()->setBold(true)->setSize(15);
$sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);

$sheet->mergeCells('L2:V2');
$sheet->setCellValue('L2', $courseName);
$sheet->getStyle('L2')->getFont()->setBold(true)->setSize(15);
$sheet->getStyle('L2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);


$sheet->mergeCells('A3:K3');
$sheet->setCellValue('A3', "Subject ID:");
$sheet->getStyle('A3')->getFont()->setBold(true)->setSize(15);
$sheet->getStyle('A3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);


$sheet->mergeCells('L3:V3');
$sheet->setCellValue('L3', $Subject_ID);
$sheet->getStyle('L3')->getFont()->setBold(true)->setSize(15);
$sheet->getStyle('L3')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

$sheet->mergeCells('A4:K4');
$sheet->setCellValue('A4', "Subject Name:");
$sheet->getStyle('A4')->getFont()->setBold(true)->setSize(15);
$sheet->getStyle('A4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);


$sheet->mergeCells('L4:V4');
$sheet->setCellValue('L4', $subjectName);
$sheet->getStyle('L4')->getFont()->setBold(true)->setSize(15);
$sheet->getStyle('L4')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);

$sheet->mergeCells('A5:K5');
$sheet->setCellValue('A5', "Teacher:");
$sheet->getStyle('A5')->getFont()->setBold(true)->setSize(15);
$sheet->getStyle('A5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT);


$sheet->mergeCells('L5:V5');
$sheet->setCellValue('L5', $teacherName);
$sheet->getStyle('L5')->getFont()->setBold(true)->setSize(15);
$sheet->getStyle('L5')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);


// Initialize the headers
$sheet->setCellValue('A6', 'Student_ID');
$sheet->setCellValue('B6', 'Full_Name');
$sheet->setCellValue('U6', 'Present Count');
$sheet->setCellValue('V6', 'Present Percentage');

// Loop through the data and organize it in a tabular form
$rowIndex = 7;
while ($row = $resultData->fetch_assoc()) {
    $sheet->setCellValue('A' . $rowIndex, $row['Student_ID']);
    $sheet->setCellValue('B' . $rowIndex, $row['Full_Name']);

    $colIndex = 3; // Start from column C
    $presentCount = 0;

    foreach ($row as $key => $value) {
        // Skip non-date columns
        if ($key != 'Student_ID' && $key != 'Full_Name') {
            $sheet->setCellValueByColumnAndRow($colIndex, 6, $key); // Set the date as the header
            $sheet->setCellValueByColumnAndRow($colIndex, $rowIndex, $value); // Set the attendance status

            // Count the number of "Present" days
            if ($value === 'Present') {
                $presentCount++;
            }

            // Apply background color based on the value
            $color = '';
            if ($value === 'Present') {
                $color = '90EE90';
            } elseif ($value === 'Absent') {
                $color = 'FF7F7F';
            } elseif ($value === 'Late') {
                $color = 'FBFF5B';
            }

            if ($color !== '') {
                $styleArray = [
                    'fill' => [
                        'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                        'startColor' => ['rgb' => $color],
                    ],
                ];

                $sheet->getStyleByColumnAndRow($colIndex, $rowIndex)->applyFromArray($styleArray);
            }

            $colIndex++; // Increment the column index
        }
    }

    // Calculate and set the Present Percentage
    $totalDays = count($row) - 2; // Subtract 2 for 'Student_ID' and 'Full_Name' columns
    $presentPercentage = ($presentCount / $totalDays) * 100;
    $sheet->setCellValue('U' . $rowIndex, $presentCount . '/' . $totalDays);
    $sheet->setCellValue('V' . $rowIndex, number_format($presentPercentage, 2) . '%');

    $rowIndex++;
}


   
    // Make the column name row bold
    $sheet->getStyle('A6:' . $sheet->getHighestColumn() . '6')->getFont()->setBold(true);

    // Make the column name row bold and set font size
$sheet->getStyle('A6:' . $sheet->getHighestColumn() . '6')->getFont()->setBold(true)->setSize(14);

// Wrap text in all cells
$sheet->getStyle('A6:' . $sheet->getHighestColumn() . $sheet->getHighestRow())->getAlignment()->setWrapText(true);

//add border to cells
$highestColumn = $sheet->getHighestColumn();
$highestRow = $sheet->getHighestRow();
$allCells = 'A6:' . $highestColumn . $highestRow;
$sheet->getStyle($allCells)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

// Set width of all columns to 114 pixels
foreach ($sheet->getColumnIterator() as $column) {
    $sheet->getColumnDimension($column->getColumnIndex())->setWidth(15);
}

// Create a writer and output the Excel file
$writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
$filename = 'attendance_data: '.$subjectName.'.xlsx';
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
$writer->save('php://output');
exit();
}

// Exit the script
$conn->close();
exit();



