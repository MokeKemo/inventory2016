<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Boris
 * Date: 29.09.2015.
 * Time: 8:42 AM
 */

session_start();


include '../includes/config.php';
include CLASS_PATH.'class.Settings.php';

$_settings = new Settings($db);



if (isset($_POST['action'])) {

    switch($_POST['action']){
        case "addUser":
            $state = $_POST['state'];
            $name = $_POST['name'];
            $surname = $_POST['surname'];
            $username = $_POST['username'];
            
            $password = $_POST['password'];
            $role = $_POST['role'];
            $status = $_POST['active'];
            $writeUser = $_settings->writeUser($state,$name,$surname,$username,$password,$role,$status);
			if($writeUser)
                {$lastInsertedID = $_settings->lastInsertID();
                    //var_dump($lastInsertedID);exit;
                    echo $lastInsertedID;}
            else echo "0";

            //return $writeUser;
		break;
		case "addState":
		    $title=$_POST['title'];
			$code=$_POST['code'];
			$currency=$_POST['currency'];

			$aS= $_settings->addNewState($code, $title, $currency);
			if($aS){$lastInsertedID = $_settings->lastInsertID();
                //var_dump($lastInsertedID);exit;
                echo $lastInsertedID;}
			else echo "0";
			//return $aS;

        break;
		case "deleteRow":
		     $id=$_POST['id'];
			 $table=$_POST['table'];
			 
			 $del= $_settings->delState($id, $table);
			 if($del){echo "1";}
			 else echo "0";
			 //return $del;
		break;

        case "deleteSuppliers":
            $id1=$_POST['id'];
            $table1=$_POST['table'];

            $del1= $_settings->delSuppliers($id1, $table1);

            if($del1){
                echo "1";
            }else echo "0";
			//return $del1;
        break;

        case "addNewSupplier":

        $name = $_POST['name'];
        $adress = $_POST['adress'];
        $city = $_POST['city'];
        $postal = $_POST['postal'];
        $state = $_POST['state'];
        $phone = $_POST['phone'];


        $dodaj = $_settings ->writeSupplier($name,$adress,$city,$state,$postal,$phone); 
        if($dodaj){$lastInsertedID = $_settings->lastInsertID();
            //var_dump($lastInsertedID);exit;
            echo $lastInsertedID;}else echo "0";
        //return $dodaj;
		break;

    

    case "deleteUsers":
            $id=$_POST['id'];
            $table=$_POST['table'];

            $del1= $_settings->delUsers($id, $table);

            if($del1){
                echo "1";
            }else echo "0";
            //return $del1;
        break;

    case "changeFieldValue":
    $table=$_POST['table'];
	//var_dump($table);
    $id=$_POST['id'];
	$field=$_POST['field'];
	$value=$_POST['value'];
	
	$update= $_settings->updateField($table, $id, $field, $value);
	
	if($update){echo "1";}
	else echo "0";
    	
			
	break; 

    case "addCategory":
    
    $title=$_POST['title'];
    $add=$_settings->addCategory($title);

    if($add){$lastInsertedID = $_settings->lastInsertID();
        //var_dump($lastInsertedID);exit;
        echo $lastInsertedID;}else echo "2";


    break;

    case "deleteCategory":

    $id=$_POST['id'];
    $table=$_POST['table'];

    $del=$_settings->deleteCategory($id,$table);

    if($del){
        echo "1";
    }else echo "0";

    break;
    case "deleteInv":
	$id=$_POST['id'];
	$table=$_POST['table'];
	
	//var_dump($_POST); exit;
	
	$delete= $_settings->delInv($id, $table);
	
	if($delete) {echo "1";}
	else echo "0";
	
	break;

    case "addInv":
	
	$title=$_POST['title'];
	$description=$_POST['description'];
	$quantity=$_POST['quantity'];
	$category=$_POST['category'];
	$serial=$_POST['serialNumber'];
	$inv_number=$_POST['invoicelNumber'];
	$price=$_POST['price'];
	$supplier=$_POST['supps'];
	$date=$_POST['date'];
	$user=$_POST['user'];
	$status=$_POST['status'];


	if(!empty($title) && !empty($description) && !empty($quantity) && is_numeric($quantity)  && !empty($category) && !empty($serial) && is_numeric($serial) &&  !empty($inv_number) && is_numeric($inv_number)  && !empty($price) && is_numeric($price)  && !empty($supplier) && !empty($date) && !empty($user) && !empty($status) ) {

        $dodaj = $_settings->addToIn($title, $description, $quantity, $category, $serial, $inv_number, $price, $supplier, $date, $user, $status);

        if ($dodaj) {
            $lastInsertedID = $_settings->lastInsertID();
            //var_dump($lastInsertedID);exit;
            echo $lastInsertedID;
        } else echo "0";
    }
	break;
	
	case "showProfile":
    //var_dump($_POST);
	$id=$_POST['id'];
	$prikazi=$_settings->showPopup($id);
	//var_dump($prikazi);
	if($prikazi) {echo json_encode($prikazi);}
	else echo "0";
	break;
	
	case 'editProfile':
	var_dump($_POST);
	$id=$_POST['id'];

	$title=$_POST['title1'];
	$price=$_POST['cost'];
	$description=$_POST['descr'];

	//$supplier=$_POST['name1'];
	$quantity=$_POST['quant'];
	$date=$_POST['datum'];

	//$category=$_POST['title2'];
	//$user=$_POST['name2'];
	$serial=$_POST['serialnumber'];
	$inv_number=$_POST['invoice_number'];
	//$status=$_POST['title3'];
	
	$update=$_settings->updatePopup($id, $title, $description, $quantity, $date, $serial,$inv_number, $price);
	//var_dump($update);
	if($update) {echo "1";}
	else echo "0";
	
	break;
	
	case 'searchInv':
	$term=$_POST['value'];
	//var_dump($term);
	$rez=$_settings->search_inv($term);
	
	if($rez) {echo json_encode($rez);}
	else echo "0";
	
	break;
	
	case 'changeLanguage':

            $language = $_POST['lang'];

            $_SESSION['lang'] = $language;

            if( $_SESSION['lang'] )
            {
                echo '1';
            } else
            {
                echo '0';
            }

            break;

        case 'buyCard':
            $order              = array();
            $id                 = $_POST['id'];
            $quantity           = $_POST['quantity'];
            $price              = $_POST['price'];
            $order['id']        = $id;
            $order['quantity']  = $quantity;
            $order['price']     = $price;

            $index              = ++$_SESSION['orders_count'];

            array_push($_SESSION['orders'], $order);
            //var_dump($_SESSION['orders']);
            break;

        case 'finalBuy':
            $id             = $_settings->getUserID();
            $_settings->putInOrdersTable($id);
            $order_id       = $_settings->lastInsertID(); //var_dump($order_id);

            foreach ($_SESSION['orders'] as $one_order) {
                if ($one_order['quantity']  ==  "") $one_order['quantity']   =  1 ;
                $table_two_fill = $_settings->OrderItemsFill($order_id, $one_order['id'], $one_order['quantity']);
            }

            unset($_SESSION['orders']);

            break;

        case 'Login':

        	$user = $_POST['user'];
        	$pass = $_POST['pass'];
        	

        	
        	$result = $_settings->log_in($user,$pass);
        	

        	echo json_encode($result);

        	// if($result){ 
			//$user_row = mysqli_fetch_assoc($result);
			
  			 $_SESSION['user'] = $user;
  			//$_SESSION['user_id'] = $user_row['id'];

    		//header('Location: http://www.devinfopoint.com/inventory/index.php');

  			// }
        break;
        case 'editProfileFromSearch':
        //var_dump($_POST);
        $id=$_POST['id'];

        $title=$_POST['title1'];
        $price=$_POST['cost'];
        $description=$_POST['descr'];

        //$supplier=$_POST['name1'];
        $quantity=$_POST['quant'];
        $date=$_POST['datum'];

        //$category=$_POST['title2'];
        //$user=$_POST['name2'];
        $serial=$_POST['serialnumber'];
        $inv_number=$_POST['invoice_number'];
        //$status=$_POST['title3'];
    
    $update=$_settings->updatePopupFromSearch($id, $title, $description, $quantity, $date, $serial,$inv_number, $price);
    //var_dump($update);
    if($update) {echo "1";}
    else echo "0";
    
    break;

        case 'GetSession':
            $username=$_POST['name'];
            $_SESSION['username']=$username;
            $_SESSION['logged']=true;
            //var_dump($_SESSION['username']);
            break;

	}

}
