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

$suppliers = new Settings($db);
$_settings = new Settings($db);
$_states = $_settings->getStates();



$_supplier = $suppliers->getSupplierList();


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
<body>


<div class="main">

    <h3 class="headline"  style="width:1010px;">Supplier List</h3>

    <div style="clear:both"></div>
      <div class="tableHolder"  style="width:1010px;">
        <form id="forma">
            <h4>Add supplier to list</h4>
            <div style="float:left;width:50%;margin-top:15px;">
                <table>
                    <tbody>
                    <!--<tr>
                        <td>
                            {{countries.title}}:
                        </td>
                        <td>
                            <select id="country" name="country" ng-model="selected" ng-options="obj.name for obj in countries.values track by obj.vrijednost"></select>
                        </td>
                    </tr>-->
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
                            Adress:
                        </td>
                        <td>
                            <input type="text" name="adress" placeholder="Adress">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            City:
                        </td>
                        <td>
                            <input type="text" name="city" placeholder="City">
                        </td>
                    </tr>
                        <td>
                        </td>
                        <td>
                            <button type="button" id="addUser" class="bigOrder" style="width:260px;font-size: 20px;" onclick="addNewSupplier();">Add New Supplier</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div style="float:left;width:50%;margin-top:15px;">
                <table>
                    <tbody>
                        <td>
                            Postal:
                        </td>
                        <td>
                            <input type="text" name="postal" placeholder="Postal">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            State:
                        </td>
                        <td>
                        <!-- <input type="text" name="state" placeholder="State">-->
                        <select id="states" name="state">
                                <option value="">Choose state</option>
                                <?php
                                foreach ($_states as $_state) {
                                    
                                    echo '<option value="'.$_state["id"].'"> '.$_state["title"].' </option>';
                                    
                                }
                                ?>
                        </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Phone:
                        </td>
                        <td>
                             <input type="text" name="phone" placeholder="Phone">
                        </td>
                    </tr>
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
                    <td>Title</td>
                    <td>Adress</td>
                    <td>City</td>
                    <td>Postal</td>
                    <td>State</td>
                    <td>Phone</td>
                    <!--<td>Role</td>
                    <td>Status</td>-->
                    <td></td>
                </tr>
                </thead>
                <tbody id="tabela">
                <?php
                
                $counter = 0;
				
			    
				
                foreach ($_supplier as $supp){
                    $tabOdd = "";
                    $statusInd = "";
                    $counter++;
                    
                    $aStatus = "Active";
                    
                    echo '<tr id="r'.$counter.'">';
                    echo '<td '.$tabOdd.'>'.$counter.'</td>
                            <td '.$tabOdd.'>'.$supp["name"].'</td>
                            <td '.$tabOdd.' onclick="tdOption(this);">
                                <span class="fSpan">'.$supp["adress"].'</span>
                                <input type="text" class="fSel" data-field="adress" data-id="'.$supp["id"].'" style="width:150px;display:none">
                            </td>
                            <td '.$tabOdd.' onclick="tdOption(this);">
                                <span class="fSpan">'.$supp["city"].'</span>
                                <input type="text" class="fSel" data-field="city" data-id="'.$supp["id"].'" style="width:150px;display:none">
                            </td>
                            <td '.$tabOdd.' onclick="tdOption(this);"> 
                                <span class="fSpan">'.$supp["postal"].'</span>
                                <input type="text" class="fSel" data-field="postal" data-id="'.$supp["id"].'" style="width:150px;display:none">
                            </td>
                            <td '.$tabOdd.' onclick="tdOption(this);">
                                <span class="fSpan">'.$supp["title"].'</span>
                                <input type="text" class="fSel" data-field="title" data-id="'.$supp["id"].'" style="width:100px;display:none">
                            </td>
                            <td '.$tabOdd.' onclick="tdOption(this);">
                                <span class="fSpan">'.$supp["phone"].'</span>
                                <input type="text" class="fSel" data-field="phone" data-id="'.$supp["id"].'" style="width:200px;display:none">
                            </td>
                           
                            <!--<td onclick="tdOption(this);"><span class="fSpan">'.$aStatus.'</span>
                                        <select class="fSel" data-field="status" data-id="'.$supp["id"].'" style="width:70px;display:none">
                                            <option value=""></option>
                                            <option value="0">Inactive</option>
                                            <option value="1">Active</option>
                                        </select>
                            </td>-->
                            <td '.$tabOdd.'><button type="button" data-id="'.$supp['id'].'" class="delButton" style="width:100px;font-size: 12px;" onclick="deleteRow(\'supplierstbl\',this,\'r'.$counter.'\');">Delete</button></td>';
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

    function addNewSupplier(){
        var podaciForme ={};
        podaciForme['action'] = 'addNewSupplier';

        $("form [name]").each(function (){
            var kljuc = $(this).attr("name");
            var vrijednost = $(this).val();
            podaciForme[kljuc] = vrijednost;
        });

        var incrementedLastRowInTable = parseInt($('#tabela tr:last td:first').html()) + 1;
        var stateID = podaciForme["state"];
        var stateName = $('#states > option[value=' + stateID + ']').html();

        if (podaciForme["name"] == "" || podaciForme["adress"] == "" || podaciForme["city"] == "" || podaciForme["postal"] == "" || podaciForme["state"] == "" || podaciForme["phone"] == ""){
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
                if(data)
                {
                    $('#tabela').append('<tr id="r'+incrementedLastRowInTable+'">' +
                        '<td >'+incrementedLastRowInTable+'</td>'+
                        '<td >'+ podaciForme["name"] +'</td>'+
                        '<td >'+ podaciForme["adress"] +'</td>'+
                        '<td >'+ podaciForme["city"] +'</td>'+
                        '<td >'+ podaciForme["postal"] +'</td>'+
                        '<td >'+ stateName +'</td>'+
                        '<td >'+ podaciForme["phone"] +'</td>'+
                        '<td ><button type="button" data-id="'+data+'" class="delButton" style="width:100px;font-size: 12px;" onclick="deleteRow(\'supplierstbl\',this,\'r'+ incrementedLastRowInTable +'\');";">Delete</button></td>'+
                        '</tr>');

                    showSuccess("Supplier added to Database!");
                }
            }
        });
        return false;
    }
//**********Selekcija polja tabele - GENERALIZOVANO *******************
//*********************************************************************
    var table = "supplierstbl"; // OBAVEZNO PRILAGODJAVANJE TABELI

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
        var podaci = {action:"deleteSuppliers",id:idNum,table:table};
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