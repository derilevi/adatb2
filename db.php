<?php
include("config.php");
class DB {
    function runQuery($statement) {
        global $ocidsn;
        global $dbuser;
        global $dbpass;

        $result = null;
        
        try
        {
            $conn = new PDO($ocidsn, $dbuser, $dbpass);
            $qry = $conn->query($statement);
            if($qry != false)
            {
                $result = $qry->fetchAll();
            }
            else
            {
                echo print_r($conn->errorInfo());
            }
        }
        catch(PDOException $e)
        {
            echo ("Exception: " . $e->getMessage());
        }

        return $result;
    }
    
    function getTermekek($type) {
        $q="SELECT * FROM h459723.termekek INNER JOIN h459723.".$type." ON h459723.termekek.termek_id=h459723.".$type.".termek_id ORDER BY h459723.termekek.termek_id ASC";
        return $this->runQuery($q);
    }
    
    function getTermekekRandom() {
        $q="SELECT * FROM h459723.termekek ORDER BY termek_id ASC";
        $termekek=$this->runQuery($q);
        shuffle($termekek);
        return array_slice($termekek,0,9);
    }
}
?>