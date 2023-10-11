<?php
namespace App\Controllers;

use CodeIgniter\Controller;
use PhpOffice\PhpSpreadsheet\IOFactory;
error_reporting(E_ALL);
ini_set('display_errors', 1);
class ExcelController extends Controller {

    protected $db; // Database connection is managed by CodeIgniter services

    public function __construct() {
        $this->db = \Config\Database::connect();
    }

  public function index() {
    return view('upload_excel_view');
  }

  public function upload()
{
    $excelFile = $this->request->getFile('excel_file');

    // Validate the uploaded file
    if ($excelFile->isValid() && $excelFile->getExtension() === 'xlsx') {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($excelFile->getTempName());
        $sheet = $spreadsheet->getActiveSheet();
        $excelData = $sheet->toArray();

        // Assuming you have already loaded the VoterModel in your controller
        $voterModel = new \App\Models\VoterModel();

        // Now you can work with $excelData
        foreach ($excelData as $row) {
            // Assuming the first row contains column headers,
            // skip the first row and process the rest
            if ($row === $excelData[0]) {
                continue;
            }
        
            // Access individual columns of each row
            $votersName = $row[0];
            $address = $row[1];
            $precinctNo = $row[2];
            $clusteredPrecinct = $row[3];
    
            // Load the Query Builder
            $builder = $this->db->table('gulod'); // Replace with your actual table name
        
            // Prepare the data to be inserted into the database
            $data = [
                'voters_name' => $votersName,
                'address' => $address,
                'precinct_no' => $precinctNo,
                'clustered_precinct' => $clusteredPrecinct,
            ];
        
            // Insert the data into the database
            $builder->insert($data);
        
            // Now you can perform any other processing with this data if needed
        } 
    } else {
        echo 'Invalid file format. Only .xlsx files are allowed.';
    }
}

}
