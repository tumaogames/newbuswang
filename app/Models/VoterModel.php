<?php

namespace App\Models;
use CodeIgniter\Model;
use CodeIgniter\Controller;
error_reporting(E_ALL);
ini_set('display_errors', 1);

class VoterModel extends Model
{
    protected $table = 'newbuswang'; // Replace 'gulod_table' with your actual table name
    protected $primaryKey = 'id'; // Replace 'id' with the primary key column of your table
    protected $allowedFields = ['voters_name', 'address', 'precinct_no', 'clustered_precinct'];
    protected $useTimestamps = true; // Enable automatic timestamps

    // Define the format of the timestamps (optional)
    protected $dateFormat = 'datetime';

    // If you want to use a different format for the timestamps, set it accordingly.
    // For example, if you want to use UNIX timestamps, you can set:
    // protected $dateFormat = 'int';

    // You can also set the timezone for the timestamps (optional)
    protected $timezone = 'UTC';

    // ...

    public function getVotersByVotersName($votersName)
    {
        // Check if $votersName is a valid string before proceeding
        if ($votersName !== null && is_string($votersName)) {
            // Trim leading and trailing spaces
            $votersName = trim($votersName);

            // Check if the input is not excessively long
            if (strlen($votersName) > 255) {
                return [];
            } 
            // Convert the search term to lowercase
            $votersName = strtolower($votersName);
            // Remove any commas from the search term
            $votersName = str_replace(',', '', $votersName);
            // Explode the search term into an array of words
            $nameParts = explode(' ', $votersName);
            // Use the Query Builder to perform an exact match search
            $query = $this->db->table('newbuswang'); // Replace 'gulod' with your actual table name
    
            // Create a variable to store the results
            $results = [];
    
            // Iterate through each row in the table
            foreach ($query->get()->getResult() as $row) {
                // Count the number of matching words in the full name
                $matchingWords = 0;
                foreach ($nameParts as $part) {
                    if (strlen($part) < 3) {
                        // Skip empty or short words
                        continue;
                    }
                    // Check if the part exists in the full name (case-insensitive)
                    if (stripos($row->voters_name, $part) !== false) {
                        $matchingWords++;
                    }
                }
    
                // Check if the exact full name is an exact match
                $exactMatch = (stripos($row->voters_name, $votersName) !== false);
    
                // Add the row to the results if it is an exact match or has at least two matching words
                if ($exactMatch || $matchingWords >= 2) {
                    $results[] = $row;
                }
            }
    
            // Return the results as an array of objects
            return $results;
        } else {
            // If $votersName is not a valid string, set it to an empty string to avoid null
            return [];
        }
    }
    
    public function getVotersByAddress($address)
    {
        return $this->like('address', $address)->orderBy('address', 'asc')->findAll();
    }

    public function getVotersByPrecinct($precinctNo)
    {
        return $this->where('precinct_no', $precinctNo)->findAll();
    }

    public function getVotersByClusteredPrecinct($clusteredPrecinct)
    {
        return $this->where('clustered_precinct', $clusteredPrecinct)->findAll();
    }

    public function updateVoter($voterId, $data)
    {
        return $this->update($voterId, $data);
    }

    public function countAllVoters()
    {
        return $this->countAll();
    }

    public function countVotersByPrecinct($precinctNo)
    {
        return $this->where('precinct_no', $precinctNo)->countAllResults();
    }

    public function countVotersByClusteredPrecinct($clusteredPrecinct)
    {
        return $this->where('clustered_precinct', $clusteredPrecinct)->countAllResults();
    }

    public function getVoterById($voterId)
    {
        return $this->find($voterId);
    }
}