<?php
include("config.php");
class DB {
    private $dbprefix="h459723";

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
        $q="SELECT * FROM ".$this->dbprefix.".termekek INNER JOIN ".$this->dbprefix.".".$type." ON ".$this->dbprefix.".termekek.termek_id=".$this->dbprefix.".".$type.".termek_id ORDER BY ".$this->dbprefix.".termekek.termek_id ASC";
        return $this->runQuery($q);
    }
    
    function getTermekekRandom() {
        $q="SELECT * FROM ".$this->dbprefix.".termekek";
        $termekek=$this->runQuery($q);
        shuffle($termekek);
        return array_slice($termekek,0,9);
    }

    function getAllSzerzo() {
        $q="SELECT * FROM ".$this->dbprefix.".szerzo ORDER BY szerzo_neve ASC";
        return $this->runQuery($q);
    }

    function getTermekekBySzerzo($id) {
        if (!is_numeric($id)) { return NULL; }
        $q="SELECT * FROM ".$this->dbprefix.".termekek WHERE szerzo_id=".$id." ORDER BY cim ASC";
        return $this->runQuery($q);
    }

    function getAllKiado() {
        $q="SELECT * FROM ".$this->dbprefix.".kiado ORDER BY kiado_neve ASC";
        return $this->runQuery($q);
    }

    function getTermekekByKiado($id) {
        if (!is_numeric($id)) { return NULL; }
        $q="SELECT * FROM ".$this->dbprefix.".termekek WHERE kiado_id=".$id." ORDER BY cim ASC";
        return $this->runQuery($q);
    }

    function getAllMufaj() {
        $q="SELECT * FROM ".$this->dbprefix.".mufajok ORDER BY mufaj_nev ASC";
        return $this->runQuery($q);
    }

    function getTermekekByMufaj($id) {
        if (!is_numeric($id)) { return NULL; }
        $q="SELECT * FROM ".$this->dbprefix.".termekek INNER JOIN ".$this->dbprefix.".termekmufaj ON ".$this->dbprefix.".termekek.termek_id=".$this->dbprefix.".termekmufaj.termek_id WHERE mufaj_id=".$id." ORDER BY cim ASC";
        return $this->runQuery($q);
    }

    function checkUser($email, $pass) {
        $hash=hash(sha256,$pass);
        $q="SELECT COUNT(*) AS C FROM ".$this->dbprefix.".felhasznalok WHERE email='".$email."' AND jelszo='".$hash."'";
        $r=$this->runQuery($q);
        if ($r[0]["C"]>0) {
            return true;
        } else {
            return false;
        }
    }

    function getUser($email) {
        $q="SELECT * FROM ".$this->dbprefix.".felhasznalok WHERE email='".$email."'";
        return $this->runQuery($q)[0];
    }

    function register($email,$pass,$nev,$cim,$telszam) {
        if (count($this->getUser($email))) {
            return false;
        }
        $hash=hash(sha256,$pass);
        $q="INSERT INTO ".$this->dbprefix.".felhasznalok (email,jelszo,teljes_nev,lakcim,telszam,jogosultsag) VALUES ('".$email."','".$hash."','".$nev."','".$cim."','".$telszam."',1)";
        $this->runQuery($q);
        return true;
    }
    
}
?>