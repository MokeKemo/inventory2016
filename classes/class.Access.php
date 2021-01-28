<?php



class Access

{

    public static function checkSession()

    {

        if (!Access::isLoggedIn()) {

            header('Location: ' . BASE_URL . 'drugi.login.php');

            exit;

        }

    }



    public static function isLoggedIn()

    {

        if (isset($_SESSION['logged']) && $_SESSION['logged'] == true) {

            return true;

        } else {

            return false;

        }

    }




    /**
     * @param $username

     * @param $password

     * @param $db Database object

     * @return bool true if username/password combo OK

     */

    public static function checkLogin($username, $password, $db)

    {

        $sql = "SELECT username FROM userstbl WHERE username='$username' AND password='$password'";

        //var_dump($sql);

        $db->query($sql, 2);

        if ($db->affectedRows() == 1) {

            return true;

        } else {

            return false;

        }

    }


}