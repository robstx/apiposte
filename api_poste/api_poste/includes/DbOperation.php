<?php
    class DbOperation {
        private $con;

        function __construct() {
            require_once dirname(__FILE__) . '/DbConnect.php';

            $db = new DbConnect();
            $this->con = $db->connect();
        }

        // Method to create a new poste
        function createPoste($localizacao, $status, $ultima_manutencao, $distrito, $zona) {
            $stmt = $this->con->prepare("INSERT INTO Postes (localizacao, status, ultima_manutencao, distrito, zona) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sssss", $localizacao, $status, $ultima_manutencao, $distrito, $zona);
            if ($stmt->execute())
                return true; 
            return false; 
        }

        // Method to get all postes
        function getPostes() {
            $stmt = $this->con->prepare("SELECT id, localizacao, status, ultima_manutencao, distrito, zona FROM Postes");
            $stmt->execute();
            $stmt->bind_result($id, $localizacao, $status, $ultima_manutencao, $distrito, $zona);

            $postes = array(); 

            while($stmt->fetch()){
                $poste  = array();
                $poste['id'] = $id; 
                $poste['localizacao'] = $localizacao; 
                $poste['status'] = $status; 
                $poste['ultima_manutencao'] = $ultima_manutencao; 
                $poste['distrito'] = $distrito; 
                $poste['zona'] = $zona; 

                array_push($postes, $poste); 
            }

            return $postes; 
        }
    }
?>
