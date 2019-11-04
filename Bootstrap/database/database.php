<?php
class Database 
{
    private static $dbName = 'id11453176_fisheyes'; 
    private static $dbHost = 'localhost';
    private static $dbUsername = 'id11453176_daniel43886';
    private static $dbUserPassword = 'c=5CPBky';

    private static $cont = null;

    public function __construct() 
    {
        die('Fonction Init non autorisée');
    }

    public static function connect() 
    {
        // Autoriser une seule connexion pour toute la durée de l’accès
        if ( null == self::$cont )
        {
            try
            {
                self::$cont = new PDO( "mysql:host=".self::$dbHost.";"."dbname=".self::$dbName, self::$dbUsername, self::$dbUserPassword);
            }
            catch(PDOException $e)
            {
                die($e->getMessage());
            }
        } 
        return self::$cont;
    }

    public static function disconnect()
    {
        self::$cont = null;
    }
}
?>