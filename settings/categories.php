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


$_settings = new Settings($db);
$categories=$_settings->getCategoryList();







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

    <h3 class="headline"  style="width:1010px;">Categories List</h3>

    <div style="clear:both"></div>
      <div class="tableHolder"  style="width:1010px;">
        <form id="forma">
            <h4>Add categories to list</h4>
            <div style="float:left;width:50%;margin-top:15px;">
                <table>
                    <tbody>
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
                        </td>
                        <td>
                            <button type="button" id="addUser" class="bigOrder" style="width:260px;font-size: 20px;" onclick="addCategory();">Add New Category</button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div style="float:left;width:50%;margin-top:15px;">
               
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
                    <td></td>
                </tr>
                </thead>
                <tbody id="tabela">
                <?php
                
                $counter = 0;
				
			     //print_r($users->getUserList());
				 //$users=mysqli_fetch_assoc($red);
				
                foreach ($categories as $category){
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
                            
                            <td '.$tabOdd.' onclick="tdOption(this);">
                                <span class="fSpan">'.$category["title"].'</span>
                                <input type="text" class="fSel" data-field="title" data-id="'.$category["id"].'" style="width:150px;display:none">
                            </td>
                            
                            
                            <td '.$tabOdd.'><button type="button" data-id="'.$category['id'].'" class="delButton" style="width:100px;font-size: 12px;" onclick="deleteRow(\'categoriestbl\',this,\'r'.$counter.'\');">Delete</button></td>';
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

    function addCategory(){
        var podaciForme ={};
        podaciForme['action'] = 'addCategory';

        $("form [name]").each(function (){
            var kljuc = $(this).attr("name");
            var vrijednost = $(this).val();
            podaciForme[kljuc] = vrijednost;
        });

        var incrementedLastRowInTable = parseInt($('#tabela tr:last td:first').html()) + 1;

        if (podaciForme["title"] == "" ){
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
                        '<td >'+ podaciForme["title"] +'</td>'+
                        '<td ><button type="button" data-id="'+data+'" class="delButton" style="width:100px;font-size: 12px;" onclick="deleteRow(\'categoriestbl\',this,\'r'+ incrementedLastRowInTable +'\');";">Delete</button></td>'+
                        '</tr>');

                    showSuccess("User added to Database!");
                }
            }
        });
        return false;
    }
//**********Selekcija polja tabele - GENERALIZOVANO *******************
//*********************************************************************
    var table = "categoriestbl"; // OBAVEZNO PRILAGODJAVANJE TABELI

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
        var podaci = {action:"deleteCategory",id:idNum,table:table};
        var x = obj.rowIndex;

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