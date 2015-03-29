<?php

class Connection
{

    private static $instance = null;
    private $db = null;

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new Connection();
        }

        return self::$instance;
    }

    private function __construct()
    {
        try {
            $this->db = new PDO('mysql:host='.Credentials::$dbUrl.';dbname='.Credentials::$dbName, Credentials::$user, Credentials::$pass);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo "Connection Error: ".$e->getMessage();
        }
    }

    public function executeQuery($query, $wantResult = false, array $parameters = [])
    {
        $stmt = $this->db->prepare($query);

        foreach ($parameters as $name => $value) {
            $stmt->bindValue(':'.$name, $value);
        }

        $result = $stmt->execute();
        if ($stmt->rowCount() > 0) {
            if ($wantResult) {
                $result = $stmt;
            }
        } else {
            $result = false;
        }

        return $result;
    }

    public function lastInsertId()
    {
        return $this->db->lastInsertId();
    }
}
