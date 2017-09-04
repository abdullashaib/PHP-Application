<?php

class DbOperation
{
    private $con;

    function __construct()
    {
        require_once dirname(__FILE__) . '/DbConnect.php';
        $db = new DbConnect();
        $this->con = $db->connect();
    }

    //Method to register a new user
    public function createUser($firstname,$lastname,$phone,$email,$pass,$const_id,$role_id){
        if (!$this->isStudentExists($username)) {
            $password = md5($pass);
            $apikey = $this->generateApiKey();
            $stmt = $this->con->prepare("INSERT INTO users (firstname, lastname, phone_number, email, password, constituent_id, role_id) values(?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("ssdssii", $firstname, $lastname, $phone, $email, $pass, $const_id, $role_id);
            $result = $stmt->execute();
            $stmt->close();
            if ($result) {
                return 0;
            } else {
                return 1;
            }
        } else {
            return 2;
        }
    }

    //Method to let a user log in
    public function userLogin($email,$pass){
        $password = md5($pass);
        $stmt = $this->con->prepare("SELECT * FROM users WHERE email=? and password=?");
        $stmt->bind_param("ss",$email,$password);
        $stmt->execute();
        $users = $stmt->get_result();
        $stmt->close();
        return $users;
    }


    //Method to fetch all constituents from database
    public function getAllConstituents(){
        $stmt = $this->con->prepare("SELECT * FROM constituency ORDER BY constituency ASC");
        $stmt->execute();
        $constituents = $stmt->get_result();
        $stmt->close();
        return $constituents;
    }
    
    //Method to fetch single constituents from database
    public function getConstituent($id){
        $stmt = $this->con->prepare("SELECT constituency FROM constituency WHERE id = ?");
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $constituent = $stmt->get_result()->fetch_assoc();
        $stmt->close();    
        return $constituent['constituency'];
    }
    
    //Method to fetch single word from the database
    public function getWord($id){
        $stmt = $this->con->prepare("SELECT name FROM words WHERE id = ?");
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $word = $stmt->get_result()->fetch_assoc();
        $stmt->close();    
        return $word['name'];
    }
    
    
    //Method to fetch single shehia from the database
    public function getShehia($id){
        $stmt = $this->con->prepare("SELECT name FROM shehia WHERE id = ?");
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $shehia = $stmt->get_result()->fetch_assoc();
        $stmt->close();    
        return $shehia['name'];
    }
    
    //Method to fetch all words in the constituents from database
    public function getWordsConstituents($id){
        $stmt = $this->con->prepare("SELECT * FROM words WHERE constituency_id = ? ORDER BY constituency_id ASC");
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $words = $stmt->get_result();
        $stmt->close();
        return $words;
    }
    
    
    //Method to fetch all shehia in the constituent from database
    public function getShehiaConstituents($id){
        $stmt = $this->con->prepare("SELECT * FROM shehia WHERE constituency_id = ? ORDER BY constituency_id ASC");
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $shehia = $stmt->get_result();
        $stmt->close();
        return $shehia;
    }
    
    
    //Method to fetch all polling station in the constituent from database
    public function getPollingConstituents($id){
        $stmt = $this->con->prepare("SELECT * FROM pollingstations WHERE constituency_id = ? ORDER BY constituency_id ASC");
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $pollings = $stmt->get_result();
        $stmt->close();                                 
        return $pollings;
    }

    //Method to check the constituent if already exist or not
    private function isConstituentExists($name) {
        $stmt = $this->con->prepare("SELECT id from constituency WHERE constituency = ?");
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
    
    //Method to check the user if already exist or not
    private function isUserExists($email) {
        $stmt = $this->con->prepare("SELECT id from users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }

    //Method to check the voter already exist or not
    private function isVoterExists($fname,$mname,$lname,$datebirth,$constituent) {
        $stmt = $this->con->prepare("SELECT * from voters2015 WHERE firstname = ? AND middlename = ? AND lastname = ? AND datebirth = ? AND votingconstituent_id = ?");
        $stmt->bind_param("ssssi", $fname,$mname,$lname,$datebirth,$constituent);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
    
    //Method to fetch all voters in word for Councilors election
    public function getVotersWord($id){
        $Query = "SELECT    v.id, v.firstname, v.middlename, v.lastname, v.datebirth, v.gender, v.residentialaddress, 
                            v.voterIDnumber, v.lifestatus, p.name
                  FROM      voters2015 v
                  JOIN      pollingstations p  ON v.pollingstation_id = p.id
                  JOIN      pollingstation_shehia ps ON v.pollingstation_id = ps.pollingstation_id
                  WHERE     ps.word_id = $id
                  ORDER BY  p.name, v.gender, v.firstname, v.middlename, v.lastname ASC";
        $stmt = $this->con->prepare($Query);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $wordVoters = $stmt->get_result();
        $stmt->close();
        return $wordVoters;
    }
    
    //Method to fetch all voters in shehia
    public function getVotersShehia($id){
        $Query = "SELECT    v.id, v.firstname, v.middlename, v.lastname, v.datebirth, v.gender, v.residentialaddress, 
                            v.voterIDnumber, v.lifestatus, p.name
                  FROM      voters2015 v
                  JOIN      pollingstations p  ON v.pollingstation_id = p.id
                  JOIN      pollingstation_shehia ps ON v.pollingstation_id = ps.pollingstation_id
                  WHERE     ps.pollingstation_id = $id
                  ORDER BY  p.name, v.gender, v.firstname, v.middlename, v.lastname ASC";
        $stmt = $this->con->prepare($Query);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $shehiaVoters = $stmt->get_result();
        $stmt->close();
        return $shehiaVoters;
    }
    
    //Method to fetch all voters in polling station
    public function getVotersPolling($id){
        $Query = "SELECT    v.id, v.firstname, v.middlename, v.lastname, v.datebirth, v.gender, v.residentialaddress, 
                            v.voterIDnumber, v.lifestatus, p.name
                  FROM      voters2015 v
                  JOIN      pollingstations p  ON v.pollingstation_id = p.id
                  JOIN      pollingstation_shehia ps ON v.pollingstation_id = ps.pollingstation_id
                  WHERE     ps.shehia_id = $id
                  ORDER BY  p.name, v.gender, v.firstname, v.middlename, v.lastname ASC";
        $stmt = $this->con->prepare($Query);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $pollVoters = $stmt->get_result();
        $stmt->close();
        return $pollVoters;
    }
    
    public function returnError() {
      return mysqli_error();
    }
}