<?php

//session_start(); ima u headeru




 include 'includes/config.php';
 
include 'includes/header.php';

include 'includes/leftside.php';

include  'includes/footer.php';

include 'classes/class.Settings.php';

include 'includes/translations.php';

$chosenLanguage = $_SESSION['lang'];


$_settings = new Settings($db);

$_supps=$_settings->getSupps();

$_users=$_settings->getUsr();

$_cats=$_settings->getCategoryList();

$_inventory=$_settings->getInventoryList();

$_status=$_settings->getStatus();

$nesto=$_settings->getUserID();
$id=$nesto['id'];

if ( empty($chosenLanguage) ) {
    $chosenLanguage = 'eng';
}

$language=$lang[$chosenLanguage];// ovo vraca $lang niz sa asocijativnim kljucem eng ili srp izabranim iz dropdowna

?>



<style>

    .titleBox {

        width:100px;

        height:30px;

        line-height:30px;

        font-size:14px;

    }

    .listBox {

        width:100px;

        height:29px;

        line-height:30px;

        font-size:14px;

    }

    .sirokiBox {

        width:233px;

    }

    .tableLine {

        height: 30px;

    }

</style>

<body ng-app="myApp">

<div id="dialog-form" title="Show inventory item">
    
   

    <form id="showUserForm">
        <fieldset>
            <table class="popup-form">
            <tr>
                <td><label for="name"><?= $language=$lang[$chosenLanguage]['title']?></label></td>
                <td><input type="text" name="title1" id="name" value="" class="text ui-widget-content ui-corner-all"></td>
                <td><label for="surname"><?= $language=$lang[$chosenLanguage]['price']?></label></td>
                <td><input type="text" name="cost" id="price" value="" class="text ui-widget-content ui-corner-all"></td>
				
            </tr>

            <tr>
                <td><label for="birth"><?= $language=$lang[$chosenLanguage]['description']?></label></td>
                <td><input type="" name="descr" id="description" value="" class="text ui-widget-content ui-corner-all"></td>
                <td><label for="gender"><?= $language=$lang[$chosenLanguage]['supplier']?></label></td>
                <td><input type="text" name="name1" id="name1" value="" class="text ui-widget-content ui-corner-all"></td>
            </tr>

            <tr>
                <td><label for="state"><?= $language=$lang[$chosenLanguage]['quantity']?></label></td>
                <td><input type="text" name="quant" id="quantity" value="" class="text ui-widget-content ui-corner-all"></td>
                <td><label for="address"><?= $language=$lang[$chosenLanguage]['date']?></label></td>
                <td><input type="" name="datum" id="date" value="" class="text ui-widget-content ui-corner-all datepicker"></td>
            </tr>

            <tr>
                <td><label for="city"><?= $language=$lang[$chosenLanguage]['category']?></label></td>
                <td><input type="text" name="title2" id="title2" value="" class="text ui-widget-content ui-corner-all"></td>
                <td><label for="postal"><?= $language=$lang[$chosenLanguage]['user']?></label></td>
                <td><input type="text" name="name2" id="name2" value=""  class="text ui-widget-content ui-corner-all" disabled></td>
            </tr>

            <tr>
                <td><label for="hPhone"><?= $language=$lang[$chosenLanguage]['serial_number']?></label></td>
                <td><input type="text" name="serialnumber" id="serialnumber" value="" class="text ui-widget-content ui-corner-all"></td>
                <td><label for="mPhone"><?= $language=$lang[$chosenLanguage]['status']?></label></td>
                <td><input type="text" name="title3" id="title3" value="" class="text ui-widget-content ui-corner-all"></td>
            </tr>
            <tr>
               <td><label for="mPhone"><?= $language=$lang[$chosenLanguage]['inv_number']?></label></td>
                <td><input type="text" name="invoice_number" id="invoice_number" value="" class="text ui-widget-content ui-corner-all">
                    <input type="hidden" id="editID" value="">
                </td> 
            </tr>
            </table>


            <!-- Allow form submission with keyboard without duplicating the dialog button -->
            <input type="submit" tabindex="-1" style="position:absolute; top:-1000px">
        </fieldset>
    </form>
</div>

<?php //include INC_PATH.'leftside.php';

 ?>

<div class="main" ng-controller="campaignController">

    
    
    <h3 class="headline"  style="width:1010px;"><?= $language=$lang[$chosenLanguage]['main_title']?></h3>
    
    <select id="selectLanguage" onchange="changeLanguage(this.value)" "select"style="float:right; margin-right:14%;">
	 <option value=""><?= $language=$lang[$chosenLanguage]['change_language']?></option>
            <option value="eng">English</option>
            <option value="srp">Srpski</option>
	</select>

    <div style="clear:both"></div>

      <div class="tableHolder"  style="width:1010px;">

        <form id="forma">

            <h4><?= $language=$lang[$chosenLanguage]['subtitle']?></h4>

            <div style="float:left;width:50%;margin-top:15px;">

           <table>

                    <tbody>

                   <!-- <tr>

                        <td>

                            {{countries.title}}:

                        </td>

                        <td>

                            <select id="country" name="country" ng-model="selected" ng-options="obj.name for obj in countries.values track by obj.vrijednost"></select>

                        </td>

                    </tr>-->	

                    <tr>

                        <td>

                    <tr>

                        <td>

                            <?= $language=$lang[$chosenLanguage]['title']?>

                        </td>

                        <td>

                            <input type="text" name="title" placeholder="<?= $language=$lang[$chosenLanguage]['title_place']?>" required>

                        </td>

                    </tr>

                    <tr>

                        <td>

                            <?= $language=$lang[$chosenLanguage]['description']?>

                        </td>

                        <td>

                            <input type="text" name="description" placeholder="<?= $language=$lang[$chosenLanguage]['description_place']?>" required>

                        </td>

                    </tr>

					 <tr>

                        <td>

                            <?= $language=$lang[$chosenLanguage]['quantity']?>

                        </td>

                        <td>

                            <input type="text" name="quantity" placeholder="<?= $language=$lang[$chosenLanguage]['quantity_place']?>" data-parsley-type="number"  equired>

                        </td>

                    </tr>

					 <tr>

                        <td>

                            <?= $language=$lang[$chosenLanguage]['category']?>
                        </td>

						<td>

                        <select id="category" name="category" required>

                                <option value=""><?= $language=$lang[$chosenLanguage]['category_place']?></option>

                                <?php

                                foreach ($_cats as $_cat) {

                                    

                                    echo '<option value="'.$_cat["id"].'"> '.$_cat["title"].' </option>';

                                    

                                }

                                ?>

								</td>

                    </tr>

					 <tr>

                        <td>

                            <?= $language=$lang[$chosenLanguage]['serial_number']?>

                        </td>

                        <td>

                            <input type="text" name="serialNumber" placeholder="<?= $language=$lang[$chosenLanguage]['serial_place']?>" data-parsley-type="number" required>

                        </td>

                    </tr>
                    <tr>

                        <td>

                            <?= $language=$lang[$chosenLanguage]['inv_number']?>

                        </td>

                        <td>

                            <input type="text" name="invoicelNumber" placeholder="<?= $language=$lang[$chosenLanguage]['inv_place']?>" data-parsley-type="number" required >

                        </td>

                    </tr>


					 </tr>

					 </tbody>

					  </table>

                 <div style="margin-left:20%"><td>				

				 <button type="button" id="addToInv" class="bigOrder" style="width:260px;font-size: 20px;" onclick="addToInventory();"><?= $language=$lang[$chosenLanguage]['add_button']?></button>

				 </td></div>    

            </div>

			 <div style="float:left;width:50%;margin-top:15px;">

           <table>

                    <tbody>

					<tr>

                        <td>

                            <?= $language=$lang[$chosenLanguage]['price']?>

                        </td>

                        <td>

                            <input type="text" name="price" placeholder="<?= $language=$lang[$chosenLanguage]['price_place']?>">

                        </td>

                    </tr>

					<tr>

                        <td>

                            <?= $language=$lang[$chosenLanguage]['supplier']?>

                        </td>

                        <td>

                            <select id="suppliers" name="supps" required>

                                <option value=""><?= $language=$lang[$chosenLanguage]['supplier_place']?></option>

                                <?php

                                foreach ($_supps as $_supp) {

                                    

                                    echo '<option value="'.$_supp["id"].'"> '.$_supp["name"].' </option>';

                                    

                                }

                                ?>

                        </td>

                    </tr>

					<tr>

                        <td>

                            <?= $language=$lang[$chosenLanguage]['date']?>

                        </td>

                        <td>

                            <input type="text" name="date" placeholder="<?= $language=$lang[$chosenLanguage]['date_place']?>" class="datepicker" required>
							

                        </td>

                    </tr>

					<tr>

                        <td>

                           <?= $language=$lang[$chosenLanguage]['user']?>

                        </td>

                         <td>
                            <!--uklonjen name tag-->
                            <input type="text" id="user" data-id="<?=$id;?>" placeholder="<?= $language=$lang[$chosenLanguage]['user_place']?>" value="<?= $_SESSION['username']; ?>"   disabled><!--ovdje treba vidjeti kad se bude pravila login forma kako ce se uzer ispisivati-->

                        </td>

                    </tr>

					<tr>

                        <td>

                            <?= $language=$lang[$chosenLanguage]['status']?>

                        </td>

                        <td>

                            <select id="status" name="status" required>

                                <option value=""><?= $language=$lang[$chosenLanguage]['status_place']?></option>

                                <?php

                                foreach ($_status as $_stat) {

                                    

                                    echo '<option value="'.$_stat["id"].'"> '.$_stat["title"].' </option>';

                                    

                                }

                                ?>

                        </td>

                    </tr>

                        <td>

                        </td>

                        <td>                     

                        </td>

                    </tr>

                    </tbody>

                </table> 

            </div>

            

                <table>

                    <tbody>

                       <!-- <td>

                            Username:

                        </td>

                        <td>

                            <input type="text" name="username" placeholder="username">

                        </td>

                    </tr>-->

                    <!--<tr>

                        <td>

                            Password:

                        </td>

                        <td>

                            <input type="text" name="password" placeholder="password">

                        </td>

                    </tr>-->

                    <!--<tr>

                        <td>

                            Role:

                        </td>

                        <td>

                            <select name="role">

                                <option value="U">User</option>

                                <option value="M">Manager</option>

                                <option value="A">Administrator</option>

                            </select>

                        </td>

                    </tr>-->

                    <!--<tr>

                        <td>

                            Active:

                        </td>

                        <td>

                            <select name="active">

                                <option value="1">Yes</option>

                                <option value="0">No</option>

                            </select>

                        </td>

                    </tr>-->

                    </tbody>

                </table>

        </form>

    </div>

	<div style="width:86%; height:0%; margin:0.5%; background-color:lightgray; padding:0%; border-radius:3px">
        <input  id="searchterm" style="margin-bottom:1%; margin-left:10%" type="text" placeholder="<?= $language=$lang[$chosenLanguage]['search_place']?>" onkeyup="searchInventory()">
    </div>
 

  <div style="clear:both"></div>

    <div class="tableHolder"  style="padding: 10px 10px 0 10px;width:1010px;">

        <div class="dayTable" style="width: 1000px;">

            <table class="dayView" id="example">

                <thead>

                <tr>

                    <td>#</td>

                    <td><?= $language=$lang[$chosenLanguage]['title_place']?></td>

                    <td><?= $language=$lang[$chosenLanguage]['description_place']?></td>

                    <td><?= $language=$lang[$chosenLanguage]['quantity_place']?></td>

					<td><?= $language=$lang[$chosenLanguage]['category_plc']?></td>

					<td><?= $language=$lang[$chosenLanguage]['serial_place']?></td>

                    <td><?= $language=$lang[$chosenLanguage]['inv_place']?></td>

					<td><?= $language=$lang[$chosenLanguage]['price_place']?></td>

					<td><?= $language=$lang[$chosenLanguage]['supplier_plc']?></td>

					<td><?= $language=$lang[$chosenLanguage]['date_place']?></td>

					<td><?= $language=$lang[$chosenLanguage]['user_plc']?></td>

					<td><?= $language=$lang[$chosenLanguage]['status_tbl']?></td>

					<td></td>

					<td></td>

                    <!--<td>E-mail</td>-->

                </tr>

                </thead>

                <tbody id="tabela">

				
				
                <?php

                $counter = 0;

				

			     //print_r($users->getUserList());

				 //$users=mysqli_fetch_assoc($red);

				

                foreach ($_inventory as $_inv){

                    $tabOdd = "";

                    $statusInd = "";

                    $counter++;

                    if ($counter % 2 != 0){

                        $tabOdd = "style='background-color:#eee'";

                    }

                    $aStatus = "Active";

                   //print_r($_inventory);

                    echo '<tr  id="r'.$counter.'">';

                    echo '<td class="counter" code="" value="'.$counter.'" '.$tabOdd.'>'.$counter.'</td>

                            <td '.$tabOdd.' onclick="tdOption(this);">
							    <span class="fSpan">'.$_inv["title1"].'</span>
								<input type="text" class="fSel" data-field="title" data-id="'.$_inv["id"].'" style="width:150px;display:none">
								</td>

                            <td '.$tabOdd.' onclick="tdOption(this);">

                                <span class="fSpan">'.$_inv["description"].'</span>

                                <input type="text" class="fSel" data-field="description" data-id="'.$_inv["id"].'" style="width:150px;display:none">

                            </td>

                            <td '.$tabOdd.' onclick="tdOption(this);">

                                <span class="fSpan">'.$_inv["quantity"].'</span>

                                <input type="text" class="fSel" data-field="quantity" data-id="'.$_inv["id"].'" style="width:150px;display:none">

                            </td>

							 <td '.$tabOdd.' onclick="tdOption(this);">

                                <span class="fSpan">'.$_inv["title2"].'</span>

				            <input type="text" class="fSel" data-field="title" data-id="'.$_inv["id"].'" style="width:150px;display:none">

                            </td>

							<td '.$tabOdd.' onclick="tdOption(this);">

                                <span class="fSpan">'.$_inv["serialnumber"].'</span>

                                <input type="text" class="fSel" data-field="serialnumber" data-id="'.$_inv["id"].'" style="width:150px;display:none">

                            </td>
                            <td '.$tabOdd.' onclick="tdOption(this);">

                                <span class="fSpan">'.$_inv["invoice_number"].'</span>

                                <input type="text" class="fSel" data-field="invoice_number" data-id="'.$_inv["id"].'" style="width:150px;display:none">

                            </td>

							<td '.$tabOdd.' onclick="tdOption(this);">

                                <span class="fSpan">'.$_inv["price"].'</span>

                                <input type="text" class="fSel" data-field="price" data-id="'.$_inv["id"].'" style="width:150px;display:none">

                            </td>

                            <td '.$tabOdd.' onclick="tdOption(this);">

                                <span class="fSpan">'.$_inv["name1"].'</span>

                                <input type="text" class="fSel" data-field="name" data-id="'.$_inv["id"].'" style="width:150px;display:none">

                            </td>

							<td '.$tabOdd.' onclick="tdOption(this);">

                                <span class="fSpan">'.$_inv["date"].'</span>

                                <input type="text" class="fSel" data-field="date" data-id="'.$_inv["id"].'" style="width:150px;display:none">

                            </td>

							<td '.$tabOdd.' onclick="tdOption(this);">

                                <span class="fSpan">'.$_inv["name2"].'</span>

                                <input type="text" class="fSel" data-field="name" data-id="'.$_inv["id"].'" style="width:150px;display:none">

                            </td>

							<td '.$tabOdd.' onclick="tdOption(this);">

                                <span class="fSpan">'.$_inv["title3"].'</span>

                                <input type="text" class="fSel" data-field="title" data-id="'.$_inv["id"].'" style="width:150px;display:none">

                            </td>

							

                           <!-- <td onclick="tdOption(this);"><span class="fSpan">'.$aStatus.'</span>

                                        <select class="fSel" data-field="status" data-id="'.$_inv["id"].'" style="width:70px;display:none">

                                            <option value=""></option>

                                            <option value="0">Inactive</option>

                                            <option value="1">Active</option>

                                        </select> 

                            </td> -->

                            <td '.$tabOdd.'><button type="button" data-id="'.$_inv['id'].'" class="delButton" style="width:100px;font-size: 12px;" onclick="deleteRow(\'inventorytbl\',this,\'r'.$counter.'\');">'.$language=$lang[$chosenLanguage]['del_button'].'</button></td>

							<td '.$tabOdd.'><button type="button" value="'.$_inv['id'].'" class="openPopup" data-id="'.$_inv['id'].'" style="width:100px;height:30px;font-size: 12px;" onclick=""><strong>'.$language=$lang[$chosenLanguage]['prev_button'].'</strong></button></td>';

							
                    echo '</tr>';

                }

                ?>

                </tbody>

            </table>

        </div>

    </div>

    <div class="legendHolder" style="width:1010px;">

    </div>

    <div style="clear:both"></div>

    <div class="tableHolder" style="background-color:#fbfbfb;font-size:14px;width:1010px;">

        infomedia © 2016

    </div>

</div>

	

	

	<?php include 'includes/footer.php'; ?>       


    
<script>
function searchInventory(){

    var search={};
    search['action']="searchInv";


    search['value']=$('#searchterm').val();
    $('#tabela').empty();



    $.ajax({

        url:"settings/adapter.php",

        type:"POST",

        dataType:"JSON",

        data:search,

        async: true,

        success:function(data){

            //console.debug(data);

            if(data)

            {
                for(var i =0; i<data.length; i++){
                    var counter = i+1;
                    //console.log(ajdi);
                    $('#tabela').append('<tr id="r'+ counter +'">' +

                        '<td >'+counter+"."+'</td>'+
                        '<input type="hidden"  value="'+data[i]['id']+'"'+'</input>'+
                        '<td >'+ data[i]["title1"] +'</td>'+
                        '<input type="hidden" name="title1" value="'+ data[i]["title1"] +'">'+'</input>'+

                        '<td >'+ data[i]["description"] +'</td>'+
                        '<input type="hidden" name="description" value="'+ data[i]["description"] +'">'+'</input>'+
                        '<td >'+ data[i]["quantity"] +'</td>'+
                        '<input type="hidden" name="quantity" value="'+ data[i]["quantity"] +'">'+'</input>'+
                        '<td >'+ data[i]["title2"] +'</td>'+
                        '<input type="hidden" name="title2" value="'+ data[i]["title2"] +'">'+'</input>'+
                        '<td >'+ data[i]["serialnumber"] +'</td>'+
                        '<input type="hidden" name="serialnumber" value="'+ data[i]["serialnumber"] +'">'+'</input>'+
                        '<td >'+ data[i]["invoice_number"] +'</td>'+
                        '<input type="hidden" name="invoice_number" value="'+ data[i]["invoice_number"] +'">'+'</input>'+
                        '<td >'+ data[i]["price"] +'</td>'+
                        '<input type="hidden" name="cost" value="'+ data[i]["price"] +'">'+'</input>'+
                        '<td >'+ data[i]["name1"] +'</td>'+
                        '<input type="hidden" name="name1" value="'+ data[i]["name1"] +'">'+'</input>'+
                        '<td >'+ data[i]["date"] +'</td>'+
                        '<input type="hidden" name="date" value="'+ data[i]["date"] +'">'+'</input>'+
                        '<td >'+ data[i]["name2"] +'</td>'+
                        '<input type="hidden" name="name2" value="'+ data[i]["name2"] +'">'+'</input>'+
                        '<td >'+ data[i]["title3"] +'</td>'+
                        '<input type="hidden" name="title3" value="'+ data[i]["title3"] +'">'+'</input>'+
                        '<td ><button type="button" data-id="'+data[i]['id']+'" class="delButton" style="width:100px;font-size: 12px;" onclick="deleteFromSearch('+data[i]["id"]+', '+counter+');">Delete</button></td>'+

                        '<td ><button type="button"  class="openPopup" data-id="'+data[i]['id']+'" style="width:100px;height:30px;font-size: 12px;" onclick="showPopupFunction('+data[i]['id']+')"><strong>Preview</strong></button></td>'+

                        '</tr>');

                
                }
            }

        }
});
}
function changeLanguage(lang)

{

    var podaTci = {action: "changeLanguage", lang: lang};

    $.ajax({
        url:"settings/adapter.php",
        type:"POST",
        dataType:"JSON",
        data:podaTci,
        async: true,
        success:function(data){
            console.log(data);
            if(data == 1)
            {
                location.reload();
            } else {
                showError("Error occured!" + data);
            }
        }
    });

}
function tdOption(obj){

    var typeObj = $(obj).find(".fSel").attr('type');

    var obValue = $(obj).find(".fSpan").text();

    if (typeObj == "text"){

        $(obj).find(".fSel").val(obValue);

    }

    $(obj).find(".fSpan").hide();

    $(obj).find(".fSpan").addClass('fHidden');

    $(obj).find(".fSel").show();

    $(obj).find(".fSel").focus();

}

function changeFieldValue(id,field,value){

    var podaci = {};

    podaci["action"] = "changeFieldValue";

    podaci["table"] = table;

    podaci["id"] = id;

    podaci["field"] = field;

    podaci["value"] = value;



    $.ajax({

        url:"settings/adapter.php",

        type:"POST",

        dataType:"JSON",

        data:podaci,

        async: true,

        success:function(data){

            if(data > 0)

            {

                location.reload();

            }

        }

    });

    return false;

}



$(document).ready(function(){

    $(".fSel").blur(function(){

        $(this).hide();

        $('.fHidden').show();

        $('.fHidden').removeClass('fHidden');

    });

    $(".fSel").change(function(){

        var vrijednost = $(this).val();

        var id = $(this).data('id');

        var field = $(this).data('field');

        if (vrijednost !== "") {

            showSuccess("Value changed!");

            changeFieldValue(id,field,vrijednost);

//                $(this).hide();

//                $('.fHidden').empty();

//                $('.fHidden').append(vrijednost);

//                $('.fHidden').show();

//                $('.fHidden').removeClass('stHidden');

        } else {

//                $(this).hide();

//                $('.fHidden').show();

//                $('.fHidden').removeClass('fHidden');

        }



    });

    $('.fSel').keyup(function(event){

        if(event.keyCode == 13){

            $('.fSel').trigger('change');

        }

    });



    $('#specialProd').change(function(){

        getOfferText();

    });

});

</script>









	

	

	

	

	

	

	

	

	

	

	

	

	

	

	

	

	

	

	

	

	

	

	

	

	

	

















