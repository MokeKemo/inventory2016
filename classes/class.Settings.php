<?php
/**********************************************************************
 *																	  *
 * --------- Settings klasa -----------------------------------       *
 * 																	  *
 * 	@Author Boris  													  *
 *  10/2015															  *
 **********************************************************************/
session_start();
class Settings {
/**********************************************************************
 * ------------------------  --------------------       *
 **********************************************************************/

	public function __construct($db) {
        if ($db) {
            $this->db = $db;
        }
    }

/**********************************************************************
 * --------- Funkcija za listanje Korisnika -------------------       *
 **********************************************************************/

	public function getUserList() {
		$sql = "SELECT userstbl.id,title, name, surname, username, password, role,status FROM userstbl inner join statetbl on stateid=statetbl.id
				WHERE 1";
		$results=$this->db->query($sql,2);
        return $results;
	}

/**********************************************************************
 * -------------- Upis novog korisnika -------------------------       *
 **********************************************************************/
    public function writeUser($state,$name,$surname,$username,$password,$role,$status){
        $encrypt = md5($password);

        $writekveri = "INSERT INTO userstbl (`stateid`, `name`, `surname`, `username`, `password`, `role`,`status`)
                                              VALUES ('$state', '$name', '$surname', '$username','$encrypt','$role','$status')";
        $result=$this->db->query($writekveri,1);
        return $result;
    }
/**********************************************************************
 * -------------- Provjeri ulogovanog korisnika ---------------       *
 **********************************************************************/
    public function checkUser($username,$pass){

        $enc_pass = md5($pass);
        $kveri = "SELECT * FROM phone_order_users WHERE username='$username' and password='$enc_pass' LIMIT 1";
        return $this->db->query($kveri,3);
    }
	
	public function getStateList(){
		$q="SELECT * FROM statetbl";
		$result=$this->db->query($q, 2);
		return $result;
	}
	
	public function addNewState($code, $title, $currency){
		$q="INSERT INTO statetbl(`code`,`title`,`currency`) VALUES('$code','$title','$currency')";
		$result = $this->db->query($q);
		return $result;
	}


	public function delState($id, $table){
		$q="DELETE FROM `inventory_db`.`$table` WHERE `statetbl`.`id`='$id'";
		//var_dump($q); exit;
		$result=$this->db->query($q);
		return $result;
	}
	
	
	
	public function getSupplierList() {
		$k = "SELECT supplierstbl.id, name, adress, city, postal, title, phone FROM supplierstbl inner join statetbl on stateid=statetbl.id
				";
		$resultat=$this->db->query($k,2);
        return $resultat;
	}
	
	//za listanje drzava u supplierima
	public function getStates(){

		$r = "SELECT title, id FROM statetbl";   
		$rez=$this->db->query($r,2);
		return $rez;
	}
	//unos nabavljaca
	public function writeSupplier($name,$adress,$city,$state,$postal,$phone){
        

        $writek = "INSERT INTO supplierstbl (`name`, `adress`, `city`,`stateid`,`postal`, `phone`)
          	                                    VALUES ('$name', '$adress', '$city','$state','$postal','$phone')";

        $rey=$this->db->query($writek,1);
        return $rey;
        }

	//brisanje nabavljaca
        public function delSuppliers($id1, $table1){
		$q="DELETE FROM `inventory_db`.`$table1` WHERE `supplierstbl`.`id`='$id1'";

		$rezultat=$this->db->query($q);

		return $rezultat;
	}

	//brisanje korisnika

        public function delUsers($id, $table){
		$q="DELETE FROM `inventory_db`.`$table` WHERE `userstbl`.`id`='$id'";
		
		$rezultat=$this->db->query($q);
		return $rezultat;
	}
       
    
	
	public function updateField($table, $id, $field, $value){
		$q="UPDATE `$table` SET `$field`='$value' WHERE id='$id'";
		//var_dump($q);
		$rez=$this->db->query($q);
		return $rez;
	}
	
	public function getSupps(){

		$r = "SELECT name, id FROM supplierstbl";   
		//var_dump($r);
		$rez=$this->db->query($r,2);
		return $rez;
	}
	
	public function getUsr(){

		$r = "SELECT name, id FROM userstbl";   
		//var_dump($r);
		$rez=$this->db->query($r,2);
		return $rez;
	}
	
	public function getCategoryList(){

		$t="SELECT id, title from categoriestbl";
		$rez=$this->db->query($t,2);

		return $rez;

	}
	
	public function addCategory($title){

		$q="INSERT INTO `categoriestbl` (title) values ('$title')";
		
		$rey=$this->db->query($q);
		return $rey;

	}

	public function getInventoryList(){
		$q="SELECT inventorytbl.id, inventorytbl.title AS title1, inventorytbl.description, quantity, categoriestbl.title AS title2, serialnumber,invoice_number, price, supplierstbl.name AS name1, date, userstbl.name AS name2, statustbl.title AS title3 FROM inventorytbl INNER JOIN categoriestbl ON categoryid=categoriestbl.id INNER JOIN supplierstbl ON supplierid=supplierstbl.id INNER JOIN userstbl ON usersid=userstbl.id INNER JOIN statustbl ON statusid=statustbl.id";
	    //var_dump($q);
		$result=$this->db->query($q, 2);
		return $result;
	}   
	
    
public function deleteCategory($id,$table){

		$q="DELETE FROM `inventory_db`.`$table` WHERE `categoriestbl`.`id`='$id'";
		//var_dump($q);
		$rezultat=$this->db->query($q);
		return $rezultat;

	}
	
	public function delInv($id, $table){
		$q="DELETE FROM `$table` WHERE id='$id'";
		$rez=$this->db->query($q);
		return $rez;
	}
	
	public function addToIn($title, $description, $quantity, $category, $serial,$inv_number, $price, $supplier, $date, $user, $status){
		$q="INSERT INTO `inventorytbl`(title, description, quantity, categoryid, serialnumber,invoice_number, price, supplierid, date, usersid, statusid) VALUES('$title', '$description', '$quantity', '$category', '$serial','$inv_number', '$price', '$supplier', '$date', '$user', '$status')";
		//var_dump($q);
		$result=$this->db->query($q);
		return $result;
	}
	
	public function showPopup($id){
		$q="SELECT inventorytbl.id, inventorytbl.title AS title1, inventorytbl.description, quantity, categoriestbl.title AS title2, serialnumber,invoice_number, price, supplierstbl.name AS name1, date, userstbl.name AS name2, statustbl.title AS title3 FROM inventorytbl INNER JOIN categoriestbl ON categoryid=categoriestbl.id INNER JOIN supplierstbl ON supplierid=supplierstbl.id INNER JOIN userstbl ON usersid=userstbl.id INNER JOIN statustbl ON statusid=statustbl.id WHERE inventorytbl.id='$id' LIMIT 1";
		
		$rezultat=$this->db->query($q,2);
		//var_dump($rezultat);
		return $rezultat;
	}

	
	public function updatePopup($id, $title, $description, $quantity, $date, $serial,$inv_number, $price){
		$q="UPDATE inventorytbl SET inventorytbl.title='$title', description='$description', quantity='$quantity', serialnumber='$serial',invoice_number='$inv_number', price='$price', date='$date' WHERE inventorytbl.id='$id'";
		//var_dump($q);
		$rez=$this->db->query($q);
		return $rez;
	}
	public function updatePopupFromSearch($id, $title, $description, $quantity, $date, $serial,$inv_number, $price){
		$q="UPDATE inventorytbl SET inventorytbl.title='$title', description='$description', quantity='$quantity', serialnumber='$serial',invoice_number='$inv_number', price='$price', date='$date' WHERE inventorytbl.id='$id'";
		//var_dump($q);
		$rez=$this->db->query($q);
		return $rez;
	}
	
	public function search_inv($term){
		$q="SELECT  inventorytbl.id, inventorytbl.title AS title1, inventorytbl.description, quantity, categoriestbl.title AS title2, serialnumber, invoice_number, price, supplierstbl.name AS name1, date, userstbl.name AS name2, statustbl.title AS title3 FROM inventorytbl INNER JOIN categoriestbl ON categoryid=categoriestbl.id INNER JOIN supplierstbl ON supplierid=supplierstbl.id INNER JOIN userstbl ON usersid=userstbl.id INNER JOIN statustbl ON statusid=statustbl.id WHERE inventorytbl.title LIKE '%$term%'";
	    //var_dump($q);
		$rezultat=$this->db->query($q, 2);
		return $rezultat;
	}
	
	public function getCardList(){

		$q="SELECT id, title, description, price FROM inventorytbl";
		$result=$this->db->query($q,2);
		//var_dump($result);
		return $result;
		

	}

	public function getUserID(){
		$user=$_SESSION['username'];
		$q="SELECT `id` FROM userstbl WHERE `username`='$user' LIMIT 1";
		$rez=$this->db->query($q, 3);
		return $rez;
	}

	public function getOrderID($userid){
		$ajdi=$userid['id'];
		$q="SELECT id FROM orderstbl WHERE userid='$ajdi' LIMIT 1";
		$rez=$this->db->query($q, 3);
		return $rez;
	}

	public function putInOrdersTable($id){
		$date=date("Y-m-d");
		$time=date("h:i:sa");
		$ajdi=$id['id'];
	  	$q="INSERT INTO orderstbl(userid, date, time) values('$ajdi','$date', '$time')";
		$result=$this->db->query($q);
		return $result;
	}

	public function OrderItemsFill($orderid, $productid, $quantity){
          $q="INSERT INTO orderitemstbl(orderid, productid, quantity) values('$orderid','$productid','$quantity')";
		  $rez=$this->db->query($q);
		return $rez;
	}

	public function log_in($user,$password){
		$pass = md5($password);
		$q="SELECT * FROM userstbl WHERE username='$user' AND password='$pass' LIMIT 1";
		//print $q;
		//var_dump($q);
		$result=$this->db->query($q,3);
		//var_dump($result);

		return $result;
		
	}

	public function getStatus(){

		$q="SELECT id, title FROM statustbl";
		$result=$this->db->query($q,2);
		return $result;
	}

	public function lastInsertID()
	{
		return $this->db->lastInsertID();

	}










}


?>










