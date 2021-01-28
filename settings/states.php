<?php
include '../includes/config.php';

include CLASS_PATH.'class.Settings.php';

include_once INC_PATH.'header.php';
include_once INC_PATH.'leftside.php';

//session_start();
//if (isset($_SESSION['phUser'])){
//$logged =  "Logged: ".$_SESSION['phUser']['username'];
//} else {
//header('Location: ../admin/login.php?status=2');
//}
//if ($_SESSION['phUser']['role'] !== "A"){
     // header('Location: ../admin/login.php?status=2');
//}

$state= new Settings($db);

$_state = $state->getStateList();

// var_dump("OK");exit;/$users = $_settings->getUserList();

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
<?php //include INC_PATH.'leftside.php';
 ?>
<div class="main" ng-controller="campaignController">

    <h3 class="headline"  style="width:1010px;">State List</h3>

    <div style="clear:both"></div>
      <div class="tableHolder"  style="width:1010px;">
        <form id="forma">
            <h4>Add state to list</h4>
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
                            Code:
                        </td>
                        <td>
                            <input type="text" name="code" placeholder="Code">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Title:
                        </td>
                        <td>
                            <input type="text" name="title" placeholder="Title">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Currency:
                        </td>
                        <td>
                            <input type="text" name="currency" placeholder="Currency">
                        </td>
                    </tr>
                        <td>
                        </td>
                        <td>
                            <button type="button" id="addUser" class="bigOrder" style="width:260px;font-size: 20px;" onclick="addNewState();">Add New State</button>
                        </td>
                    </tr>
                    </tbody>
                </table> 
            </div>
            <div style="float:left;width:50%;margin-top:15px;">
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
            </div>
        </form>
    </div>
    <div style="clear:both"></div>
    <div class="tableHolder"  style="padding: 10px 10px 0 10px;width:1010px;">
        <div class="dayTable" style="width: 1000px;">
            <table class="dayView" id="example">
                <thead>
                <tr>
                    <td>#</td>
                    <td>Code</td>
                    <td>Title</td>
                    <td>Currency</td>
					<td></td>
                    <!--<td>E-mail</td>-->
                </tr>
                </thead>
                <tbody id="tabela">
                <?php
                $counter = 0;
				
			     //print_r($users->getUserList());
				 //$users=mysqli_fetch_assoc($red);
				
                foreach ($_state as $s){
                    $tabOdd = "";
                    $statusInd = "";
                    $counter++;
                    if ($counter % 2 != 0){
                        $tabOdd = "style='background-color:#eee'";
                    }
                    $aStatus = "Active";
                   
                    echo '<tr id="r'.$counter.'">';
                    echo '<td '.$tabOdd.'>'.$counter.'</td>
                            <td '.$tabOdd.'>'.$s["code"].'</td>
                            <td '.$tabOdd.' onclick="tdOption(this);">
                                <span class="fSpan">'.$s["title"].'</span>
                                <input type="text" class="fSel" data-field="title" data-id="'.$s["id"].'" style="width:150px;display:none">
                            </td>
                            <td '.$tabOdd.' onclick="tdOption(this);">
                                <span class="fSpan">'.$s["currency"].'</span>
                                <input type="text" class="fSel" data-field="currency" data-id="'.$s["id"].'" style="width:150px;display:none">
                            </td>
                            
                           <!-- <td onclick="tdOption(this);"><span class="fSpan">'.$aStatus.'</span>
                                        <select class="fSel" data-field="status" data-id="'.$s["id"].'" style="width:70px;display:none">
                                            <option value=""></option>
                                            <option value="0">Inactive</option>
                                            <option value="1">Active</option>
                                        </select> 
                            </td> -->
                            <td '.$tabOdd.'><button type="button" data-id="'.$s['id'].'" class="delButton" style="width:100px;font-size: 12px;" onclick="deleteRow(\'statetbl\',this,\'r'.$counter.'\');">Delete</button></td>';
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
        infomedia � 2016
    </div>
</div>
<?php include INC_PATH.'footer.php'; ?>
</body>
<script>
    
    $(document).ready(function(){
        initDataTable();
    });
    //*********************************************************************
    //**********SNIMANJE KORISNIKA ****************************************
    //*********************************************************************

    function addNewState(){
        var podaciForme ={};
        podaciForme['action'] = 'addState';

        $("form [name]").each(function (){
            var kljuc = $(this).attr("name");
            var vrijednost = $(this).val();
            podaciForme[kljuc] = vrijednost;
        });

        var incrementedLastRowInTable = parseInt($('#tabela tr:last td:first').html()) + 1;

        if (podaciForme["code"] == "" || podaciForme["title"] == "" || podaciForme["currency"] == ""){
            showWarning("You must fill out the form!");
            return false;
        }

        $.ajax({
            url:"adapter.php",
            type:"POST",
            dataType:"JSON",
            data:podaciForme,
            async: true,
            success:function(data){
                if(data > 0)
                {
                    $('#tabela').append('<tr id="r'+incrementedLastRowInTable+'">' +
                        '<td >'+incrementedLastRowInTable+'</td>'+
                        '<td >'+ podaciForme["code"] +'</td>'+
                        '<td >'+ podaciForme["title"] +'</td>'+
                        '<td >'+ podaciForme["currency"] +'</td>'+
                        '<td ><button type="button" data-id="'+data+'" class="delButton" style="width:100px;font-size: 12px;" onclick="deleteRow(\'statetbl\',this,\'r'+ incrementedLastRowInTable +'\');">Delete</button></td>'+
                        '</tr>');

                    showSuccess("User added to Database!");
                }
            }
        });
        return false;
    }
//**********Selekcija polja tabele - GENERALIZOVANO *******************
//*********************************************************************
    var table = "statetbl"; // OBAVEZNO PRILAGODJAVANJE TABELI

    /***** inicializovanja data table *******/
    function initDataTable(){
        $('#example').dataTable({
            sDom: "",
            /*"sDom": 'T<"clear">lfrtip',*/
            /*"bProcessing": true,*/
            "bDestroy": true,
            "bPaginate": false,
            "bFilter": false,
            "bSortCellsTop": true,
            "aaSorting": [[ 0, "asc" ]],
            "aoColumns": [
                null,
                null,
                null,
                null,
                null
            ],
            "oTableTools": {
                "sSwfPath": "http://www.instanio.com/dev/js/plugins/datatables/media/swf/copy_csv_xls_pdf.swf" ,
                "aButtons": [
                ]
            }


        });
    }
	
  function deleteRow(table,obj,rowNum) {
    var r = confirm("Are you shure you want to delete the record?");
    if (r == true) {

        var idNum = $(obj).data('id');
        var podaci = {action:"deleteRow",id:idNum,table:table};
        var x = obj.rowIndex;
        console.log(podaci);
            $.ajax({
                url:"adapter.php",
                type:"POST",
                dataType:"JSON",
                data:podaci,
                async: true,
                success:function(data){
                    if(data == 1)
                    {
                        deleteTableRow(rowNum);
                        showSuccess("Record removed from database!");
                    } else {
                        showError("Error occured!");
                    }
                }
            });

    } else {}

}	
	
function deleteTableRow(rowid)
{
    var row = document.getElementById(rowid);
    row.parentNode.removeChild(row);
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
            url:"../settings/adapter.php",
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

</html>
























