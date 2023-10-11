<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="https://unligames.com/newbuswang/assets/mystyle.css">
    <style>
        /* Override Bootstrap's bg-primary for column */
        .bg-primary {
            background-color: initial !important;
        }
    </style>
    <title>Print Layout</title>
</head>
<body>

    <div class="container">
    <?php
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
        use App\Models\VoterModel; // Load the VoterModel class
        // Assuming $voterModel is your instance of VoterMode
        $voterModel = new VoterModel();
        if (isset($_GET['voterRange'])) {
            $address = $_GET['address'];
            $voterRange = $_GET['voterRange'];
            $voterIds = range(1, 8);
            if($address && $address !== null){
                $voterInfoAddress = $voterModel->getVotersByAddress($address);
            }
            $rangeParts = explode('-', $voterRange);
            
            if (count($rangeParts) === 2 && is_numeric($rangeParts[0]) && is_numeric($rangeParts[1])) {
                $startId = intval($rangeParts[0]);
                $endId = intval($rangeParts[1]);
                
                if ($startId >= $rangeParts[0] && $endId <= $rangeParts[1] && $startId <= $endId) {
                    for ($voterId = $startId; $voterId <= $endId; $voterId++) {
                        if($address && $address !== null){
                            if ($voterId >= 0 && $voterId < count($voterInfoAddress)) {
                                $voterInfo = $voterInfoAddress[$voterId];
                            } else {
                                $voterInfo = null; // Handle an invalid index
                            }
                        } else {
                            $voterInfo = $voterModel->getVoterById($voterId);
                        }
                        echo '<div class="row">';
                        echo '<div class="column bg-primary px-4">';
                        if ($voterInfo !== null) {
                            echo '<div class="row mt-4 mb-1">';
                            echo '<div class="col-2 custom-col"><p></p></div>';
                            echo '<div class="col-2 custom-col px-1"><p>Name:</p></div>';
                            echo '<div class="col-7 custom-col"><span class="py-0" style="font-weight: bold">' . $voterInfo['voters_name'] . '</span></div>';
                            echo '</div>';
                            echo '<div class="row mb-1">';
                            echo '<div class="col-2 custom-col"><p></p></div>';
                            echo '<div class="col-2 custom-col px-1"><p>Address:</p></div>';
                            echo '<div class="col-7 custom-col"><span class="py-0" style="font-weight: bold">' . $voterInfo['address'] . '</span></div>';
                            echo '</div>';
                            echo '<div class="row mb-1">';
                            echo '<div class="col-2 custom-col"><p></p></div>';
                            echo '<div class="col-2 custom-col px-1"><p>Precinct:</p></div>';
                            echo '<div class="col-7 custom-col"><span class="py-0" style="font-weight: bold">' . $voterInfo['precinct_no'] . '</span></div>';
                            echo '</div>';
                            echo '<div class="row mb-1">';
                            echo '<div class="col-2 custom-col"><p></p></div>';
                            echo '<div class="col-2 custom-col px-1"><p>Cluster:</p></div>';
                            echo '<div class="col-7 custom-col"><span class="py-0" style="font-weight: bold">' . $voterInfo['clustered_precinct'] . '</span></div>';
                            echo '</div>';
                            // ... Display other voter information ...
                        } else {
                            echo '<p>Voter not found.</p>';
                            break;
                        }
                        echo '</div>';

                        // Your table and data rendering code here for the second column
                       
                        echo '</div>'; // Close row
                    }
                } else {
                    echo '<p>Invalid voter range. Please enter a range between 1 and 8.</p>';
                }
            } else {
                echo '<p>Invalid voter range format.</p>';
            }
        }
        ?>
    </div>
    <div class="container">
        <div>
            <button id="printButton">Print</button>
        </div>
    </div>
    
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/js/all.min.js"></script>
    <script>
        const printButton = document.getElementById('printButton');
        printButton.addEventListener('click', () => {
            window.print();
        });
    </script>
</body>
</html>



