<?php
include '../includes/config.php';
include CLASS_PATH.'classSettings.php';

session_start();
if (isset($_SESSION['phUser'])){
$logged =  "Logged: ".$_SESSION['phUser']['username'];
} else {
header('Location: ../admin/login.php?status=2');
}
if ($_SESSION['phUser']['role'] !== "A"){
      header('Location: ../admin/login.php?status=2');
}


$_settings = new Settings($db);

// var_dump("OK");exit;
$users = $_settings->getUserList();




include INC_PATH.'header.php';
?>
<link href="<?= CSS_PATH.'viewData.css' ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?= JS_PATH.'app.js' ?>"></script>
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
<?php include INC_PATH.'leftside.php'; ?>
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
                            <!--countries.title:-->
                        </td>
                        <td>
                            <!--<select id="country" name="country" ng-model="selected" ng-options="obj.name for obj in countries.values track by obj.vrijednost"></select>-->
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
                    <tr>
                        <td>
                            Email:
                        </td>
                        <td>
                            <input type="text" name="email" placeholder="Email">
                        </td>
                    </tr>
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
                            <input type="text" name="password" placeholder="password">
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
                            <select name="active">
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
                    <td>E-mail</td>
                    <td>Username</td>
                    <td>Password</td>
                    <td>Role</td>
                    <td>Status</td>
                    <td></td>
                </tr>
                </thead>
                <tbody id="tabela">
                <?php
                $counter = 0;
                foreach ($users as $user){
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
                            <td '.$tabOdd.'>'.$user["state"].'</td>
                            <td '.$tabOdd.' onclick="tdOption(this);">
                                <span class="fSpan">'.$user["name"].'</span>
                                <input type="text" class="fSel" data-field="name" data-id="'.$user["id"].'" style="width:150px;display:none">
                            </td>
                            <td '.$tabOdd.' onclick="tdOption(this);">
                                <span class="fSpan">'.$user["surname"].'</span>
                                <input type="text" class="fSel" data-field="surname" data-id="'.$user["id"].'" style="width:150px;display:none">
                            </td>
                            <td '.$tabOdd.' onclick="tdOption(this);">
                                <span class="fSpan">'.$user["email"].'</span>
                                <input type="text" class="fSel" data-field="email" data-id="'.$user["id"].'" style="width:150px;display:none">
                            </td>
                            <td '.$tabOdd.' onclick="tdOption(this);">
                                <span class="fSpan">'.$user["username"].'</span>
                                <input type="text" class="fSel" data-field="username" data-id="'.$user["id"].'" style="width:100px;display:none">
                            </td>
                            <td '.$tabOdd.' onclick="tdOption(this);">
                                <span class="fSpan">'.$user["password"].'</span>
                                <input type="text" class="fSel" data-field="password" data-id="'.$user["id"].'" style="width:200px;display:none">
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
                            <td '.$tabOdd.'><button type="button" data-id="'.$user['id'].'" class="delButton" style="width:100px;font-size: 12px;" onclick="deleteRow(\'phone_order_users\',this,\'r'.$counter.'\');">Delete</button></td>';
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
        infomedia © 2015 - <i>phoneorder</i>
    </div>
</div>

<script type="text/javascript" src="<?= JS_PATH.'controllers/campaignControler.js' ?>"></script>
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


        if (podaciForme["country"] == "" || podaciForme["name"] == "" || podaciForme["surname"] == "" || podaciForme["username"] == "" || podaciForme["password"] == "" || podaciForme["role"] == ""){
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
                    $('#tabela').append('<tr>' +
                        '<td >-</td>'+
                        '<td >'+ podaciForme["country"] +'</td>'+
                        '<td >'+ podaciForme["fullname"] +'</td>'+
                        '<td >'+ podaciForme["username"] +'</td>'+
                        '<td >'+ podaciForme["password"] +'</td>'+
                        '<td >'+ podaciForme["role"] +'</td>'+
                        '<td >-</td>'+
                        '</tr>');

                    showSuccess("User added to Database!");
                }
            }
        });
        return false;
    }
//**********Selekcija polja tabele - GENERALIZOVANO *******************
//*********************************************************************
    var table = "phone_order_users"; // OBAVEZNO PRILAGODJAVANJE TABELI

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
                null
            ],
            "oTableTools": {
                "sSwfPath": "http://www.instanio.com/dev/js/plugins/datatables/media/swf/copy_csv_xls_pdf.swf" ,
                "aButtons": [
                ]
            }


        });
    }
</script>

</html>