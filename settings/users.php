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

$users = new Settings($db);
$_settings = new Settings($db);
$_states = $_settings->getStates();
$_users = $users->getUserList();
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


<div class="main" ng-controller="campaignController">

    <h3 class="headline"  style="width:1010px;">User List</h3>

    <div style="clear:both"></div>
      <div class="tableHolder"  style="width:1010px;">
        <form id="forma">
            <h4>Add user to list</h4>
            <div style="float:left;width:50%;margin-top:15px;">
                <table>
                    <tbody>
                    <tr>
                        <td>
                            State
                        </td>
                        <td>
                            <select id="states" name="state">
                                <option value="">Choose state</option>
                                <?php
                                foreach ($_states as $_state) {
                                    
                                    echo '<option value="'.$_state["id"].'"> '.$_state["title"].' </option>';
                                    
                                }
                                ?>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Name:
                        </td>
                        <td>
                            <input type="text" name="name" placeholder="Name">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Surname:
                        </td>
                        <td>
                            <input type="text" name="surname" placeholder="Surname">
                        </td>
                    </tr>
                    <!--<tr>
                        <td>
                            Email:
                        </td>
                        <td>
                            <input type="text" name="email" placeholder="Email">
                        </td>
                    </tr>-->
                    <tr>
                        <td>
                        </td>
                        <td>
                            <button type="button" id="addUser" class="bigOrder" style="width:260px;font-size: 20px;" onclick="addNewUser();">Add New User</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div style="float:left;width:50%;margin-top:15px;">
                <table>
                    <tbody>
                        <td>
                            Username:
                        </td>
                        <td>
                            <input type="text" name="username" placeholder="username">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Password:
                        </td>
                        <td>
                            <input type="password" name="password" placeholder="password">
                        </td>
                    </tr>
                    <tr>
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
                    </tr>
                    <tr>
                        <td>
                            Active:
                        </td>
                        <td>
                            <select id="status" name="active">

                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </td>
                    </tr>
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
                    <td>State</td>
                    <td>Name</td>
                    <td>Surname</td>

                    <td>Username</td>

                    <td>Role</td>
                    <td>Status</td>
                    <td></td>
                </tr>
                </thead>
                <tbody id="tabela">
                <?php
                
                $counter = 0;
				
			     //print_r($users->getUserList());
				 //$users=mysqli_fetch_assoc($red);
				
                foreach ($_users as $user){
                    $tabOdd = "";
                    $statusInd = "";
                    $counter++;
                    if ($counter % 2 != 0){
                        $tabOdd = "style='background-color:#eee'";
                    }

                    $aStatus = "Active";
                    if ($user["status"] == "0"){
                        $aStatus = "Inactive";
                    }

                    echo '<tr id="r'.$counter.'">';
                    echo '<td '.$tabOdd.'>'.$counter.'</td>
                            <td '.$tabOdd.'>'.$user["title"].'</td>
                            <td '.$tabOdd.' onclick="tdOption(this);">
                                <span class="fSpan">'.$user["name"].'</span>
                                <input type="text" class="fSel" data-field="name" data-id="'.$user["id"].'" style="width:150px;display:none">
                            </td>
                            <td '.$tabOdd.' onclick="tdOption(this);">
                                <span class="fSpan">'.$user["surname"].'</span>
                                <input type="text" class="fSel" data-field="surname" data-id="'.$user["id"].'" style="width:150px;display:none">
                            </td>

                            <td '.$tabOdd.' onclick="tdOption(this);">
                                <span class="fSpan">'.$user["username"].'</span>
                                <input type="text" class="fSel" data-field="username" data-id="'.$user["id"].'" style="width:100px;display:none">
                            </td>

                            <td '.$tabOdd.' onclick="tdOption(this);">
                                <span class="fSpan">'.$user["role"].'</span>
                                <input type="text" class="fSel" data-field="role" data-id="'.$user["id"].'" style="width:30px;display:none">
                            </td>
                            <td onclick="tdOption(this);"><span class="fSpan">'.$aStatus.'</span>
                                        <select class="fSel" data-field="status" data-id="'.$user["id"].'" style="width:70px;display:none">
                                            <option value=""></option>
                                            <option value="0">Inactive</option>
                                            <option value="1">Active</option>
                                        </select>
                            </td>
                            <td '.$tabOdd.'><button type="button" data-id="'.$user['id'].'" class="delButton" style="width:100px;font-size: 12px;" onclick="deleteRow(\'userstbl\',this,\'r'.$counter.'\');">Delete</button></td>';
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
        infomedia © 2016 - <i>inventory</i>
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

    function addNewUser(){
        var podaciForme ={};
        podaciForme['action'] = 'addUser';

        $("form [name]").each(function (){
            var kljuc = $(this).attr("name");
            var vrijednost = $(this).val();
            podaciForme[kljuc] = vrijednost;
        });
        console.log(podaciForme);
        var incrementedLastRowInTable = parseInt($('#tabela tr:last td:first').html()) + 1;
        var stateID = podaciForme["state"];
        var stateName = $('#states > option[value=' + stateID + ']').html();
        var active   ='';
        if(podaciForme['active']==1){
            active='Active';
        }else{
            active='Inactive';
        }
        if (podaciForme["state"] == "" || podaciForme["name"] == "" || podaciForme["surname"] == "" || podaciForme["username"] == "" || podaciForme["password"] == "" || podaciForme["role"] == ""){
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
                        '<td >'+ stateName +'</td>'+
                        '<td >'+ podaciForme["name"] +'</td>'+
                        '<td >'+ podaciForme["surname"] +'</td>'+
                        '<td >'+ podaciForme["username"] +'</td>'+

                        '<td >'+ podaciForme["role"] +'</td>'+
                        '<td >'+ active +'</td>'+
                        '<td ><button type="button" data-id="'+data+'" class="delButton" style="width:100px;font-size: 12px;" onclick="deleteRow(\'userstbl\',this,\'r'+ incrementedLastRowInTable +'\');";">Delete</button></td>'+
                        '</tr>');

                    showSuccess("User added to Database!");
                }
            }
        });
        return false;
    }
//**********Selekcija polja tabele - GENERALIZOVANO *******************
//*********************************************************************
    var table = "userstbl"; // OBAVEZNO PRILAGODJAVANJE TABELI

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
        var podaci = {action:"deleteUsers",id:idNum,table:table};
        var x = obj.rowIndex;
        console.log(podaci);
            $.ajax({
                url:"../settings/adapter.php",
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
            url:"adapter.php",
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
    $('.fSel').trigger('change'); $(document).ready(function(){
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
        }
    });

     $('#specialProd').change(function(){
            getOfferText();
    });
});

</script>

</html>