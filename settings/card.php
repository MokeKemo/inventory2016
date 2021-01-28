<?php

include '../includes/config.php';



include CLASS_PATH.'class.Settings.php';



include_once INC_PATH.'header.php';



include_once INC_PATH.'leftside.php';


$_SESSION['orders']= [];
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

$_cards = $_settings->getCardList();

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



    <h3 class="headline"  style="width:1010px;">Shop</h3>



    <div style="clear:both"></div>

    <div class="tableHolder"  style="width:1010px;">

        <!-- <form id="forma">

           <!--  <h4>Add user to list</h4>

              <div style="float:left;width:50%;margin-top:15px;">

                 <table>

                     <tbody>

                     <tr>

                         <td>

                             State

                         </td>

                         <td>

                             <select id="country" name="state">

                                 <option value="">Choose state</option>-->

        <?php

        // foreach ($_states as $_state) {



        // echo '<option value="'.$_state["id"].'"> '.$_state["title"].' </option>';



        // }

        ?>

        <!--   </td>

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

               <select name="active">

                   <option value="1">Yes</option>

                   <option value="0">No</option>

               </select>

           </td>

       </tr>

       </tbody>

   </table>

</div>

</form>-->

    </div>

    <div style="clear:both"></div>

    <div class="tableHolder"  style="padding: 10px 10px 0 10px;width:1010px;">

        <div class="dayTable" style="width: 1000px;">

            <table class="dayView" id="example">

                <thead>

                <tr>

                    <td>#</td>

                    <td>Title</td>

                    <td>Description</td>

                    <td>Quantity</td>
                    <td>Price</td>
                    <td></td>

                </tr>

                </thead>

                <tbody id="tabela">
                <form>
                    <?php



                    $counter = 0;



                    //print_r($users->getUserList());

                    //$users=mysqli_fetch_assoc($red);



                    foreach ($_cards as $_card){

                        $tabOdd = "";

                        $statusInd = "";

                        $counter++;

                        if ($counter % 2 != 0){

                            $tabOdd = "style='background-color:#eee'";

                        }


                        echo '<tr id="r'.$counter.'">';

                        echo '<td '.$tabOdd.'>'.$counter.'</td>
                            <input type="hidden" class="ajdi" name="id" value="'.$_card["id"].'">
                            <td '.$tabOdd.'>'.$_card["title"].'</td>
                            <input type="hidden" class="title" name="title" data-id="'.$_card["id"].'" value="'.$_card["title"].'">
                            <td '.$tabOdd.' onclick="tdOption(this);">

                                <span class="fSpan">'.$_card["description"].'</span>

                                <input type="text" class="fSel" data-field="description" data-id="'.$_card["id"].'" style="width:150px;display:none">
                                 <input type="hidden"  class="description" name="title" data-id="'.$_card["id"].'" value="'.$_card["description"].'">
                            </td>

                            <td '.$tabOdd.' onclick="tdOption(this);">

                                <!--<span class="fSpan">'.$_card["quantity"].'</span>-->
                                <input type="text" class="quantity" name="quantity" placeholder="1">

                                <input type="text"  data-field="quantity" data-id="'.$_card["id"].'" style="width:150px;display:none">

                            </td>

                            <td '.$tabOdd.' onclick="tdOption(this);">

                                <span class="fSpan">'.$_card["price"].'</span>
                                 <input type="hidden" class="price" name="title" data-id="'.$_card["id"].'" value="'.$_card["price"].'">
                                <input type="text" class="fSel" data-field="price" data-id="'.$_card["id"].'" style="width:150px;display:none">

                            </td>



                            <td '.$tabOdd.'><button type="button" data-id="'.$_card['id'].'" class="buyButton" style="width:100px;font-size: 12px;" ">Buy Product</button></td>';

                        echo '</tr>';

                    }
                    ?>
                </form>
                </tbody>

            </table>
        </div>

    </div>

    <form><button style="width:86%; margin-bottom: 0.5%;" type="button" onclick="submitAll();">Submit All</button></form>

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

               

            ],

            "oTableTools": {

                "sSwfPath": "http://www.instanio.com/dev/js/plugins/datatables/media/swf/copy_csv_xls_pdf.swf" ,

                "aButtons": [

                ]

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
/*
    function buyProduct(){
        var c= confirm("Do you want to buy this product?");

        if (c == true) {

            var card = {};

            card['action'] = 'buyCard';

            /*$("form[name]").each(function () {

                var kljuc = $(this).attr("name");

                var vrijednost = $(this).val();

                card[kljuc] = vrijednost;

            });

            card['id']=$('.ajdi').val();
            card['title']=$('#title').val();
            card['description']=$('#description').val();
            card['quantity']=$('#quantity').val();
            card['price']=$('#price').val();
            console.log(card['id']);
            $.ajax({

                url: "adapter.php",

                type: "POST",

                dataType: "JSON",

                data: card,

                async: true,

                success: function (data) {

                    if (data > 0) {

                        showSuccess("You added this to cart!");

                    }

                }

            });

            return false;

        }

    }

*/

    $('#tabela').on('click', '.buyButton', function () {
        var c = confirm("Do you want to buy this product?");
        var tr = $(this).closest('tr');
        if (c) {
            var card = {};
            card.action = 'buyCard';
            card.id = $('.ajdi', tr).val();
            card.title = $('.title', tr).val();
            card.description = $('.description', tr).val();
            card.quantity = $('.quantity', tr).val();
            card.price = $('.price', tr).val();
            //console.log(card);
            $.ajax({

                url: "adapter.php",
                type: "POST",
                dataType: "JSON",
                data: card,
                success: function (data) {
                    if (data > 0) {
                        showSuccess("You added this to cart!");
                    }
                }
            });
            return false;
        }
    });

function submitAll(){

    var confirmAll = {};

    confirmAll["action"] = "finalBuy";

    //confirmAll["confirm_index"]= "confirm";

    $.ajax({

        url:"adapter.php",

        type:"POST",

        dataType:"JSON",

        data:confirmAll,

        async: true,

        success:function(data){

            if(data > 0)

            {

                //location.reload();

            }

        }

    });

    return false;
}

</script>



