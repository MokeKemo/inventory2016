//*************** JS FUNKCIJE  *********************
//
//                         2015.
//
// Author:
// Boris
//****************************************************************


 //********** FIX ZA DATUM I VRIJEME NA DVOCIFRENEBROJEVE  ************************ 
      function addLeadingChars(string, nrOfChars, leadingChar) {
          string = string + '';
          return Array(Math.max(0, (nrOfChars || 2) - string.length + 1)).join(leadingChar || '0') + string;
      }
  //********** START ORDER - pocetna podesavanja  **********************
    function startO(attMessage){
          var startTS = new Date();
          tss = startTS.getTime();
          datumStart = new Date();
          mjesecS = addLeadingChars(datumStart.getMonth() + 1);
          danS = addLeadingChars(datumStart.getDate());
          satS = addLeadingChars(datumStart.getHours());
          minutS = addLeadingChars(datumStart.getMinutes());
          sekundaS = addLeadingChars(datumStart.getSeconds());

          dateEvent = danS + '.' + mjesecS + '.' + datumStart.getFullYear() + '.';
          startEvent = satS + ':' + minutS + ':' + sekundaS;

              // addEvent(document, "mouseout", function(e) {
              //     e = e ? e : window.event;
              //     var from = e.relatedTarget || e.toElement;
              //     if (orderFinished == false){
              //        if (!from || from.nodeName == "HTML") {
              //           // stop your drag event here
              //          // for now we can just use an alert   ****   POPUP JS ALERT ********
              //           alert(attMessage);
              //        }
              //     }
              // });

                    $(document).on("keydown", function(f){
                        if (orderFinished == false){
                             if ((f.which || f.keyCode) == 116) {
                                          f.preventDefault();
                                          alert(attMessage);
                             }
                        }
                    });
    }  
   //********** START ORDER - pocetna podesavanja - END **********************

    //********** Zavrsetak narudzbe *************************
    function endOrder(status) {

            var endTS = new Date();
            tse = endTS.getTime();
            datumEnd = new Date();
	          satE = addLeadingChars(datumEnd.getHours());
	          minutE = addLeadingChars(datumEnd.getMinutes());
	          sekundaE = addLeadingChars(datumEnd.getSeconds());

            sucessEvent = status;
            endEvent = satE + ':' + minutE + ':' + sekundaE;

          if (datumEnd < datumStart) {
                  datumEnd.setDate(datumEnd.getDate() + 1);
              }
            // durationEvent = endEvent - startEvent;

            orderFinished = true;
            // UPISIVANJE U JSON SAMO ZA HRVATSKU!!!
          // if (countryLocation == "HR"){
            writeJSONfile();
          // }
   } 
    //**********  END Zavrsetak narudzbe *************************

    //**********  POTVRDA OTKAZA NARUDZBE *************************
    function cancelConfirm(){
              var potvrda ={}
              potvrda.box = $('#confirm');
                     $('.newOrder').empty();
                     $('.newOrder').append("<strong>"+openText+"</strong>");
                     $('#otkazi_Button').attr('disabled', 'disabled');
                     $('#zakljuci_Button').attr('disabled', 'disabled');
                     $('#otkazBox').fadeOut('slow');
                            potvrda.box.empty();
                            potvrda.box.text(cancelText);
                            potvrda.box.show();
                            potvrda.box.select();

                    $('html, body').animate({
                                scrollTop: potvrda.box.offset().top
                    }, 1000); 
    }
    //**********  END POTVRDA OTKAZA NARUDZBE *************************

    //********** Event listener za popup  *************************
      function addEvent(obj, evt, fn) {
           
              if (obj.addEventListener) {
                  obj.addEventListener(evt, fn, false);
              }
              else if (obj.attachEvent) {
                  obj.attachEvent("on" + evt, fn);
              }
            
      }
    //********** END Event listener za popup  **********************


    //************* OTKAZIVANJE NARUDZBE ***************************
    function otkaz(razlog) {
                if (razlog <= 3) {
                                cancelConfirm();
                                if (razlog == 1){
                                  cancelReason = "PriceHigh";
                                  cancelEvent = "YES";
                                } 
                                else if (razlog == 2){
                                cancelReason = "Postage";
                                 cancelEvent = "YES";
                                }  
                                else if (razlog == 3){
                                  cancelReason = "NeedTime";
                                  cancelEvent = "YES";
                                }
                     endOrder("CANCELED!"); 
                }
                else {
                      $('.otherReason').fadeIn('slow');
                }                  
    }
    //************* END  OTKAZIVANJE NARUDZBE ***************************

    //************* INFORMACIJE O PROIZVODU  ***************************    
        function faqReason(faqRazlog) {
                        if (faqRazlog == 1) {
                                otherOptEvent = "PRODUCT > work";
                                } 
                                else if (faqRazlog == 2){
                                otherOptEvent = "PRODUCT > invoice";
                                }  
                                else if (faqRazlog == 3){
                                otherOptEvent = "PRODUCT > store";
                                }
                                else {
                                  otherEvent = "YES";
                        }
        }
    //*************END INFORMACIJE O PROIZVODU  ***************************    

    //*************PROVJERA PODATAKA - FINAL ORDER***************************    
    function provjera_podataka(){
            $('#podaci').slideDown("slow");
            $('#podaci').select();
              $('html, body').animate({
                  scrollTop: $("#podaci").offset().top
              }, 1000);

          var $P_ime=$('#ime').val();
          var $P_prezime=$('#surname').val();
          var $P_adresa=$('#address').val()+" "+$('#number').val();
          var $P_grad=$('#city').val();
          var $P_postanski=$('#postal').val();
          var $P_telefon=$('#phone').val();
          var $P_mail=$('#email').val();
          var $P_proizvod=$(".aktivniSp").attr("data-value");
          var $nazivPr = $(".chosen-single span").text();

          $(".P_ime, .P_prezime, .P_adresa, .P_grad, .P_postanski, .P_telefon, .P_mail, .P_proizvod").empty();
          $(".P_ime").append($P_ime);
          $(".P_prezime").append($P_prezime); 
          $(".P_adresa").append($P_adresa);
          $(".P_grad").append($P_grad);
          $(".P_postanski").append($P_postanski);
          $(".P_telefon").append($P_telefon);
          $(".P_mail").append($P_mail);
          $(".P_proizvod").append($nazivPr + " " + $P_proizvod);



    }
    //*************END PROVJERA PODATAKA - FINAL ORDER************************  


    //************  PROVJERA TACNOSTI ADRESE ZA OPERATERA ********************
    function gMapCheck () {
            var gUlica = $('#address').val();
            var gBroj = $('#number').val();
            var gSearch = gUlica + "+" + gBroj;
          
            window.open('http://www.google.com/maps?q='+gSearch, "_blank");
    }
     // **************************************************************************
     // ************** VIEW DATA FUNKCIJE ****************************************
     //***************************************************************************


      var stil = "";
      var sel = "";
      var sel2 = "";
      var sel3 = "";
      var inp1a = "01.01.2015.";
      var inp1b = "31.12.2018.";
      var jsonCCode = "";
      var arrayCountry = [];
      var arrayType = [];
      var numShow = 0;
      var ordStat = "";
      var tipO = "";
      var typeVal ="";
      var dateJson = new Array();
      var dateFromArr = new Array();
      var dateToArr = new Array();
      var dateBool = true;
      var ordStat ="";

      var tStampA = 1411423200000;
      var datumA = "";
      var datumAarr = "";
      var datumAall = "";

      var tStampB = 1531423200000;
      var datumB = "";
      var datumBarr = "";
      var datumBall = "";

      var tStampJ = 0;

     // ******************** SELECT ZA PROMJENU ZEMLJE ZA KOJU ZELIMO PODATKE ***
      function changeCountryView () {
        dateBool = true;
        var redni = 0;
        $("#rezult").empty();
        sel = document.getElementById("country").value;
        sel2 = document.getElementById("ordType").value;
        sel3 = document.getElementById("ordNum").value;
           if ($('#datumFrom').val() != ""){
              datumA = String($('#datumFrom').val());
              datumAarr = datumA.split(".");
              datumAall = datumAarr[1] + "." + datumAarr[0] + "." + datumAarr[2] + ".";
              var dateConvertedA = new Date(datumAall);
              tStampA = dateConvertedA.getTime();
              dateBool = false;
           }
                      // dateFromArr[0]  dateFromArr[1]  dateFromArr[2]   dan, mjesec, godina
           if ($('#datumTo').val() != ""){ 
              datumB = String($('#datumTo').val());
              datumBarr = datumB.split(".");
              datumBall = datumBarr[1] + "." + datumBarr[0] + "." + datumBarr[2] + ".";
              var dateConvertedB = new Date(datumBall);
              tStampB = dateConvertedB.getTime();       //******** Razdvoji datume na tri dijela radi poredjenja ****
              dateBool = false;
           }
                      // dateToArr[0]  dateToArr[1]  dateToArr[2]    dan, mjesec, godina
 

          if (sel == "ALL"){
              arrayCountry = ["BA", "HR", "RS"];
           } else if (sel == "HR"){
              arrayCountry = ["HR"];
           } else if (sel == "BA") {        //*********  PRETRAGA PO ZEMLJI *******
            arrayCountry = ["BA"];
           } else if (sel == "RS") {
            arrayCountry = ["RS"];
           }

          if (sel2 == "ALL"){
              arrayType = ["ORDER", "OTHER"];
           } else if (sel2 == "ORD"){
              arrayType = ["ORDER"];
           } else if (sel2 == "OTH"){        //*********  PRETRAGA PO TIPU *******
              arrayType = ["OTHER"];
           } 

          if (sel3 == "num10"){
              numShow = 10;
           } else if (sel3 == "num50"){      //********* BROJ REZULTATA  *******
              numShow = 50;
           } 

           




            for (i = 0; i < arrayCountry.length; i++){
                  $.getJSON("jsonDB/json-"+arrayCountry[i]+".json", function(data) {
                  var zadnji = data.length-1;
                  var redniBr = 1;               
                  var hrefB = "";
                  var hrefE = "";

                  if (sel3 == "numAll") {
                  numShow = data.length;

                  }



                      for (var i = 0; redni < numShow; i++) {
                        
                        var dateJson = data[zadnji]["date"].split(".");    
                        var dateJSONall = dateJson[1] + "." + dateJson[0] + "." + dateJson[2] + ".";
                        var dateConvertedJ = new Date(dateJSONall);
                        tStampJ = dateConvertedJ.getTime();
                        hrefB = "";
                        hrefE = "";      
                        
                         for (var j = 0; j < arrayType.length; j++) {
                          tipO = data[zadnji]["type"]; 
                          ordStat = data[zadnji]["sucess"];                     
                             
                            typeVal = arrayType[j];
                            // console.debug(dateJson[0]);

                                      if (ordStat == "CANCELED!"){
                                            stil = "style='background-color: #FF8686'";
                                      } else if (ordStat == "ORDERED!") {
                                            stil = "style='background-color: #64FC7D'";
                                            hrefB = "<a href='javascript:showBuyer("+zadnji+");'>";
                                            hrefE = "</a>";
                                      } else { 
                                        stil = ""; 
                                       }


                            
                          if(tipO == typeVal){               
                                 if (tStampJ >= tStampA && tStampJ <= tStampB || dateBool == true) {    
                                    

                                        redni = redni+1
                                       $("#rezult").append("<div class='tableLine'><div class='listBox uski'"+stil+">"+ redni +"</div><div class='listBox srednji'"+stil+">"+ data[zadnji]["country"] +"</div><div class='listBox'"+stil+">"+ data[zadnji]["date"] +"</div><div class='listBox srednji'"+stil+">"+ data[zadnji]["codeNum"] +"</div><div class='listBox srednji'"+stil+">"+hrefB+ data[zadnji]["callId"] +hrefE+"</div><div class='listBox'"+stil+">"+ data[zadnji]["start"] +"</div><div class='listBox'"+stil+">"+ data[zadnji]["end"] +"</div><div class='listBox srednji'"+stil+">"+ data[zadnji]["duration"] +"</div><div class='listBox'"+stil+">"+ data[zadnji]["type"] +"</div><div class='listBox'"+stil+">"+ data[zadnji]["otherOpt"] +"</div><div class='listBox'"+stil+">"+ data[zadnji]["productWork"] +"</div><div class='listBox'"+stil+">"+ data[zadnji]["getInvoice"] +"</div><div class='listBox'"+stil+">"+ data[zadnji]["buyStore"] +"</div><div class='listBox'"+stil+">"+ data[zadnji]["other"] +"</div><div class='listBox'"+stil+">"+ data[zadnji]["sucess"] +"</div><div class='listBox srednji'"+stil+">"+ data[zadnji]["cancel"] +"</div><div class='listBox'"+stil+">"+ data[zadnji]["cancelRe"] +"</div></div>");
                                         
                                         redniBr++;
                                         hrefB="";
                                         hrefE="";
                                         
                                 }    
                           } 
                          } zadnji = zadnji - 1;
                      }
                  });
            }  
      }
    //********** FUNKCIJE POPUPA ZA PRIKAZ INFORMACIJA O KUPCU ***************
    function showBuyer(idPopup){

      $('.showBuyerPopup').fadeIn('slow');

            $('#showName,#showSurname,#showStreet,#showCity,#showPhone,#showMail').empty();
   
            var podaci = {action:"showBuyer",id:idPopup};

                $.ajax({
                    url:"../includes/adapter.php",
                    type:"POST",
                    dataType:"JSON",
                    data:podaci,
                    async: true,
                    success:function(data){
                        if(data)
                        {
                            $('#showName').append(data.cName);
                            $('#showSurname').append(data.cSurname);
                            $('#showStreet').append(data.cAddress); 
                            $('#showCity').append(data.cCity);
                            $('#showPhone').append(data.cPhone);
                            $('#showMail').append(data.cMail); 
                        } else {
                            showError("Error occured!");
                        }
                    }
                }); return false;
   }
    $(document).ready(function (){

        $('.showBuyerPopup').click(function(){
                $(this).hide();
        });
    });

//**********END FUNKCIJE POPUPA ZA PRIKAZ INFORMACIJA O KUPCU ************
//*********************************************************************
//********** TOOGLE za vrstu narudzbe standardna / sms ****************
//*********************************************************************
function selectOrderType(obj){

    var tip = $(obj).val();
    $('#product_f').trigger('change'); // potreban trigger da se povuku i filtriraju ispravni paketi
    $('.dynamicPost').empty();
    if (tip == "1") {
        $('.codeSection').show();
        $('#campaigns').hide();
        $('#hidden_lp').val("");
        $('#http_rf').val("");
        $('#standardUpsell').show();
        $('#smsUpsell').hide();
        $('.dynamicPost').append($('#postHidden').val());
    } else if (tip == "2") {
        $('.codeSection').hide();
        $('#campaigns').show();
        $('#hidden_lp').val("");
        $('#http_rf').val("");
        $('#code').val("");
        $('#standardUpsell').hide();
        $('.dynamicPost').append("0.00");
        addHttpParams($('#campaigns'));
    } else if (tip == "3") {
        $('.codeSection').show();
        $('#campaigns').hide();
        $('#hidden_lp').val("");
        $('#http_rf').val("");
        $('#smsUpsell').hide();
        $('#standardUpsell').show();
        $('.dynamicPost').append($('#hiddenPost').val());
        //addHttpParams($('#campaigns'));
    } else if (tip == "4") {
        $('.codeSection').hide();
        $('#campaigns').hide();
        $('#rcampaigns').show();
        $('#hidden_lp').val("");
        $('#http_rf').val("");
        $('#smsUpsell').hide();
        $('#standardUpsell').show();
        $('.dynamicPost').append($('#hiddenPost').val());
        addHttpParams($('#rcampaigns'));
    }

}

//*********************************************************************
//********** Pokupi informacije kampanje ******************************
//*********************************************************************

function getCampaignInfo(obj) {
        var param = $(obj).val();
        var podaci = {action:"getCampaignInfo",campName:param};

        $.ajax({
            url:"../../includes/adapter.php",
            type:"POST",
            dataType:"JSON",
            data:podaci,
            async: true,
            success:function(data){
                if(data)
                {
                    $('#smsUpsell').empty();
                    $('#smsUpsell').show();
                    $('#smsUpsell').append("<strong>"+data[0].upsellText+"</strong>");

                    $('#standardUpsell').hide();
                } else {

                }
            }
        }); return false;

}

//*********************************************************************
//********** AUTO FILL FORME AKO POSTOJI KUPAC ************************
//*********************************************************************

function fillOrderForm(answer){
	if (answer == "No"){
		$('#fillInfo').hide('slow');
		return false;
	}

	var ime = $("#ime").val();
	var prezime = $("#surname").val();

	       var dataString = new Array();
	           dataString = {action:"fillOrderFormByName", cName:ime, cSurname:prezime, cCountry:countryLocation};

	            $.ajax
                ({
                type: "POST",
                url: "fillOrderForm.php",
                data: dataString,
                cache: false,
                success: function(eData){ 
                        if (eData != 0){
                         var eData2 = $.parseJSON(eData);
                            console.log(eData2);                       

                            if (answer == "check"){
                            	$('#fillPodaci').empty();
                            	$('#fillPodaci').append(eData2.name +' '+ eData2.surname +', '+ eData2.address +', '+ eData2.postcode +' '+ eData2.city +', '+ eData2.email);
                            	$('#fillInfo').show('slow');

                            } else if (answer == "Yes") {	
		                             $('#ime').val(eData2.name);
		                             $('#surname').val(eData2.surname);
		                             $('#address').val(eData2.address);
		                             $('#number').val("-");
		                             $('#postal').val(eData2.postcode);                             
		                             $('#city').val(eData2.city);
		                             $('#phone').val(eData2.telephone);
		                            if (eData2.email !== "No mail"){
		                             $('#email').val(eData2.email);
		                            }
                                $('.formGroup').css('border', '1px solid rgb(0, 240, 181)');
                                $('.formGroup').css('background-color', 'rgb(84, 237, 203)');
                            } 
                        }
                    }
                });
		    return false;
}
//*********************************************************************
//********** NEW AUTO FILL FORME AKO POSTOJI KUPAC ************************
//*********************************************************************

function fillOrderFormNew(answer, objNum){
    if (answer == "No"){
        $('#fillInfo').hide('slow');
        return false;
    } else if (answer == "Yes") {
        $('#ime').val(fillFormObj[objNum].name);
        $('#surname').val(fillFormObj[objNum].surname);
        $('#address').val(fillFormObj[objNum].address);
        $('#number').val("-");
        $('#postal').val(fillFormObj[objNum].postcode);
        $('#city').val(fillFormObj[objNum].city);
        $('#phone').val(fillFormObj[objNum].telephone);
        if (fillFormObj[objNum].email !== "No mail"){
            $('#email').val(fillFormObj[objNum].email);
        }
        $('#quest_provjera').hide();
        $('.formGroup').css('border', '1px solid rgb(0, 240, 181)');
        $('.formGroup').css('background-color', 'rgb(84, 237, 203)');
        return false;
    }
    $('#fillInfo').empty();
    $('.loaderGreen').show();
    var ime = $("#ime").val();
    var prezime = $("#surname").val();

    var dataString = new Array();
    dataString = {action:"fillOrderFormByNameNew", cName:ime, cSurname:prezime, cCountry:countryLocation};

    $.ajax
    ({
        type: "POST",
        url: "fillOrderForm.php",
        data: dataString,
        cache: false,
        success: function(eData){

            if (eData != 0){
                var eData2 = $.parseJSON(eData);


                $('#fillInfo').show();
                fillFormObj = eData2;
                for (var key in eData2) {
                    $('#fillInfo').append('<tr><td>'+eData2[key].name +'</td><td>'+ eData2[key].surname +'</td><td>'+ eData2[key].address +'</td><td>'+ eData2[key].postcode +'</td><td>'+ eData2[key].city +'</td><td>'+ eData2[key].email+'</td><td><button type="button" class="bigOrder GreyBtn" style="width:60px;height:28px;font-size: 12px;margin-left:5px;margin-top:0px;" onclick="fillOrderFormNew(\'Yes\', '+key+');" >OK</button></td></tr>');
                }

            }
        }
    }).done(function() {
        $('.loaderGreen').hide();
    });
    return false;
}



    //*********************************************************************
    //**********LISTA SALESPACKAGEA ( STATE+PRODUCT ) *********************
    //*********************************************************************

function getSalesPackagesList(){
    var selektOpt = $('#country').find('option:selected').val();
    var selektOpt2 = $('#Product').find('option:selected').val();
    var selektovan = {action:"getSalesPackages",state:selektOpt,product:selektOpt2};
    $.ajax({
        url:"../includes/adapter.php",
        type:"POST",
        dataType:"JSON",
        data:selektovan,
        async: true,
        success:function(data){
            if(data.length > 0)
            {
                $('#salesPack').empty();
                $('#salesPack').append('<option value="all">Choose Salespackage</option>');
                for(var i=0;i<data.length;i++)
                {
                    $('#salesPack').append('<option value="'+data[i].id+'">'+data[i].salespackagecode+'</option>');
                }
            } else {
                $('#salesPack').empty();
                $('#salesPack').append('<option value="all">Choose Salespackage</option>');
            }
        }
    });
    return false;
}


//*********************************************************************
//**********Uzmi senderID na osnovu state *****************************
//*********************************************************************

function getSenderId(){
    var selektOpt = $('#country').find('option:selected').val();

    var selektovan = {action:"getSenderId",state:selektOpt};
    $.ajax({
        url:"../includes/adapter.php",
        type:"POST",
        dataType:"JSON",
        data:selektovan,
        async: true,
        success:function(data){
           // console.log(data.distro_smsFrom);
            $('#senderId').val(data.distro_smsFrom);
        }
    });
    return false;
}
    //*********************************************************************
    //**********SNIMANJE SPECIAL OFFER ITEM-a *****************************
    //*********************************************************************


function addSpecialOffer(){
var statecode = $('#country option:selected').val();
var orderP = $('#ProductOrd option:selected').text();
var offerP = $('#Product option:selected').text();
var salesP = $('#salesPack option:selected').text();
//var state = $('#country').text();

if (orderP == "Choose product" || offerP == "Choose product" || salesP == "Choose product" || salesP == "Choose Salespackage"){
    showWarning("You must fill out the form!");
    return false;
}

    var podaciForme ={};
    podaciForme['action'] = 'addSpecialOffer';

    $("form [name]").each(function (){
        var kljuc = $(this).attr("name");
        var vrijednost = $(this).val();
        podaciForme[kljuc] = vrijednost;
    });
    $.ajax({
        url:"../includes/adapter.php",
        type:"POST",
        dataType:"JSON",
        data:podaciForme,
        async: true,
        success:function(data){
            if(data > 0)
            {
                $('#tabela').append('' +
                    '<div class="tableLine" style="margin-top:1px;">'+
                    '<div class="listBox srednji">-</div>'+
                    '<div class="listBox">'+statecode+'</div>'+
                    '<div class="listBox sirokiBox">'+orderP+'</div>'+
                    '<div class="listBox sirokiBox">'+offerP+'</div>'+
                    '<div class="listBox sirokiBox">'+salesP+'</div>'+
                    '<div class="listBox"><button type="button" data-id="'+data+'" class="delButton" style="width:100px;font-size: 12px;" onclick="deleteRow(this);">Delete</button></div>'+
                    '</div>');
                showSuccess("Special Offer Added to database!");

            }
        }
    });
    return false;
}

//*********************************************************************
//********** FUNKCIJA ZA UZIMANJE PODATAKA SPECIJALNE PONUDE **********
//*********************************************************************

function getOfferText(){
    var selektOpt = $('#specialProd').find('option:selected').val();
    var selektovan = {action:"getOfferText",offerId:selektOpt};
    $.ajax({
        url:"../../includes/adapter.php",
        type:"POST",
        dataType:"JSON",
        data:selektovan,
        async: true,
        success:function(data){
                $('#offerText').empty();

                var offerT = data.offerText;
                var imeKupca = $('#ime').val();
                var cijenaPon = $('#specialProd').find('option:selected').data("sp");
                var cijenaFix = cijenaPon.split(" ");
                
                offerT = offerT.replace(/\[\[name\]\]/g, imeKupca);
                offerT = offerT.replace(/\[\[price\]\]/g, cijenaFix[1]);
                
                $('#offerText').append(offerT);
                $('#offerTextHolder').fadeIn('fast');
        }
    });
    return false;
}
//*********************************************************************
//********** LISTA PROIZVODA KOJI SU NA SPEC. PONUDI ******************
//*********************************************************************

function getSpecialProducts(){
    var selektOpt = $('#stateHidden').val();
    var selektOpt2 = $('#product_f').find('option:selected').val();
    var selektovan = {action:"getSpecialList",state:selektOpt,product:selektOpt2};
    $.ajax({
        url:"../../includes/adapter.php",
        type:"POST",
        dataType:"JSON",
        data:selektovan,
        async: true,
        success:function(data){
            if(data.length > 0)
            {
                $('#specialProd').empty();
                if(data.length > 1){
                    $('#specialProd').append('<option value="" data-sp="">'+choosePr+'</option>');
                }
                for(var i=0;i<data.length;i++)
                {
                    var prodCurrency = data[i].currency;
                    var prodPrice = data[i].price;
                        prodPrice = prodPrice.replace(".",",");
                    var prodQuant = data[i].quantity;
                    var paket = "STAR "+prodPrice+prodCurrency+" | "+ prodQuant +"x | "+prodPrice+prodCurrency;



                    $('#specialProd').append('<option value="'+data[i].idNum+'" data-sp="'+paket+'" data-pr="'+data[i].prodId+'">'+data[i].title+'</option>');
                }
            } else {
                $('#specialProd').empty();
            }

        }
    });
    return false;
}
//*********************************************************************
//********** KUPAC NE ZELI SPECIJALNU PONUDU **************************
//*********************************************************************
function noSpecialOffer() {
    $('.specialPopup').hide('fast');
    $('#confirm').show('fast');
    $('html, body').animate({
        scrollTop: $("#confirm").offset().top
    }, 1000);
}

//*********************************************************************
//********** FUNKCIJA ZA FILTERE - STAVLJA PARAMETRE U GET ************
//*********************************************************************
var SearchFormSimple = {};

SearchFormSimple.search = function(obj) {

  var button  = $(obj);
  var forma   = button.parents('form');
  var objekti = forma.find("input,select");

  var podaci = '';
  objekti.each(function(){
    
    var ime = $(this).attr("name");
    var val = $(this).val();
    podaci += ime + "=" + val + "&";

  });
  
  location.search = encodeURI(podaci);
  return false;

}
//*********************************************************************
//********** BRISANJE SPECIJALNE PONUDE *******************************
//*********************************************************************

function deleteRow(table,obj,rowNum) {
    var r = confirm("Are you shure you want to delete the record?");
    if (r == true) {

        var idNum = $(obj).data('id');
        var podaci = {action:"deleteRow",id:idNum,table:table};
        var x = obj.rowIndex;

            $.ajax({
                url:"../includes/adapter.php",
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
//*********************************************************************
//********** ALERT  BOXES ***********************************************
//*********************************************************************

function showError($msg) {

    $('#messageE').empty();
    $('#messageE').append($msg);
    $('.errorB').fadeIn('fast');
    setTimeout(function(){$('.errorB').fadeOut('fast');},3000);
}
function showSuccess($msg) {

    $('#messageS').empty();
    $('#messageS').append($msg);
    $('.successB').fadeIn('fast');
    setTimeout(function(){$('.successB').fadeOut('fast');},3000);
}
function showWarning($msg) {

    $('#messageW').empty();
    $('#messageW').append($msg);
    $('.warningB').fadeIn('fast');
    setTimeout(function(){$('.warningB').fadeOut('fast');},3000);
}
//*********************************************************************
//********** DELETE ROW FROM TABLE ************************************
//*********************************************************************
function deleteTableRow(rowid)
{
    var row = document.getElementById(rowid);
    row.parentNode.removeChild(row);
}
//*********************************************************************
//********** select option by GET *************************************
//*********************************************************************
function getToOption(elementId,getName){
    //uhvati parametre iz GET-a
    var parseQueryString = function() {

        var str = window.location.search;
        var objURL = {};

        str.replace(
            new RegExp( "([^?=&]+)(=([^&]*))?", "g" ),
            function( $0, $1, $2, $3 ){
                objURL[ $1 ] = $3;
            }
        );
        return objURL;
    };
//sredi parametre
    var params = parseQueryString();
    var getFromGet = params[getName];
//Funkcija za odabir opcije
    function setOption(selectElement, value) {
        var options = selectElement.options;
        for (var i = 0, optionsLength = options.length; i < optionsLength; i++) {
            if (options[i].value == value) {
                selectElement.selectedIndex = i;
                return true;
            }
        }
        return false;
    }
    //Zavrsi odabir opcije
    setOption(document.getElementById(elementId), getFromGet);
}
//*********************************************************************
//********** POVECAJ POLJA SA DUGIM TEKSTOM NA DataView ***************
//*********************************************************************

$(document).on('mouseover','.makeBigger',function () { $(this).addClass('bigger')})
    .on('mouseleave','.bigger',function () { $(this).removeClass('bigger')});

//*********************************************************************
//**********Selekcija polja tabele - GENERALIZOVANO *******************
//*********************************************************************

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
            url:"../includes/adapter.php",
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
//*********************************************************************
//********** LISTA KAMPANJA *******************************************
//*********************************************************************

function getCampaigns(){
    var selektOpt = $('#country').val();
    var selektovan = {action:"getCampaigns",state:selektOpt};
    $.ajax({
        url:"../includes/adapter.php",
        type:"POST",
        dataType:"JSON",
        data:selektovan,
        async: true,
        success:function(data){
            if(data.length > 0)
            {
                $('#campName').empty();
                $('#campName').append('<option value="">Choose Campaign</option>');
                for(var i=0;i<data.length;i++)
                {
                    $('#campName').append('<option value="'+data[i].id+'" data-ime="'+data[i].CampaignName+'">'+data[i].CampaignName+'</option>');
                }
            } else {
                $('#campName').empty();
                $('#campName').append('<option value="">Choose Campaign</option>');
            }
        }
    });
    return false;
}
//*********************************************************************
//**********DAJE KLASU TRENUTNO SELEKTOVANOM SLAEPAKETU ***************
//*********************************************************************
function markSalespackage(obj)
{
   $(".cijeneButton").each(function(){
      $(this).removeClass("aktivniSp");
    $(this).css('background', '#fff');
    });
  var ovaj=$(obj);
  ovaj.addClass("aktivniSp");
  ovaj.css('background', '#54EDCB');

     var aktivniInfo = $(".aktivniSp").data("value");
     var aktivniInfo2 = aktivniInfo.split(" ");
     var samoCijena = aktivniInfo2[0].replace(",",".");

    //Sama cijena bez valute float type
     var numb = parseFloat(samoCijena);

     var ukCijena = 0;
     var assignPost = $('.dynamicPost').text();
     ukCijena = numb + parseFloat(assignPost);

     $('.dynamicPrice').empty();
     $('.dynamicPrice').append(ukCijena);

}
//*********************************************************************
//********** OZNACAVA PHONECODE DA JE ISKORISTEN **********************
//*********************************************************************


function setPhonecodeused()
   {
      var id=$("#phone_code_hidden").val();
      if(id.length>0)
      {
         $.ajax({
            url:'request_handler.php',
            type:"POST",
            dataType:"JSON",
            data:{action:"setCodeUsed",id:id},
            success:function(data)
            {
              
              //if wrong some log
            
            }
          });
      }
  }
//*********************************************************************
//********** Provjerava polje za kod i dodjeljuje utmove **************
//*********************************************************************


function checkCodeField()
{
    if($("#code").val() == ""){
        noCode();
    } else {
        getLandingPage();
    }
}

//*********************************************************************
//********** Funkcija za brojanje karaktera u elementu ****************
//*********************************************************************
function countChars(obj) {
    $("#charCount").empty();

    $("#charCount").append(obj.value.length);
    var encodeT = obj.value;
    var encode = {action:"checkEncode",encText:encodeT};

    $.ajax({
        url:"adapter.php",
        type:"POST",

        data:encode,
        success:function(data)
        {
            if (data > 0){
                $("#charSet").empty();
                $("#charSet").append("UTF-8");
            } else {
                $("#charSet").empty();
                //$("#charSet").append("GSM");
            }
        }
    });
    return false;
}
//*********************************************************************
//********** Funkcija za odjavu maila i broja korisnika ***************
//*********************************************************************
    function unsubNumber(unNumber, state) {

        var unData = {action:"unsubNumber",number:unNumber, state:state};
        $.ajax({
            url:"../../includes/adapter.php",
            type:"POST",
            data:unData,
            success:function(data)
            {
                if (data > 0){
                    $(".odjavaNotify").fadeIn('slow');
                    $(".odjavaNotify").css("background-color","#cfc");
                    $("#odjavaNotify").append(yNum+" "+unNumber+" "+isDeleted);
                   // $("#odjavaNotify").append(unNumber+" removed. ");
                } else {
                   showError("Error");
                }
            }
        });
        return false;
    }
    function unsubMail(unMail, state) {

        var unData = {action:"unsubMail",mail:unMail, state:state};
        $.ajax({
            url:"../../includes/adapter.php",
            type:"POST",
            data:unData,
            success:function(data)
            {
                if (data > 0){
                    $(".odjavaNotify").fadeIn('slow');
                    $(".odjavaNotify").css("background-color","#cfc");
                    //$("#odjavaNotify").append(unMail+" removed.");
                    $("#odjavaNotify").append(yMail+" "+unMail+" "+isDeleted);
                } else {
                    showError("Error");
                }
            }
        });
        return false;
    }



function unsubscribeUser() {
$("#odjavaNotify").empty();
var unNumber = $("#odjavaPhone").val();
var unMail = $("#odjavaMail").val();
var state = $('#stateHidden').val();

if (unNumber == "" && unMail == "") {
    showWarning(unMsg);
    return false;
}

    if (unNumber.length > 0 && unNumber.length < 6) {
        $(".odjavaNotify").fadeIn('slow');
        $(".odjavaNotify").css("background-color","#fcc");
        $("#odjavaNotify").append(supNum+" "+unNumber+" "+noValidNum);
        //$("#odjavaNotify").append(unNumber+" not valid.");
        return false;
    }

    if (unNumber !== "") {
        unsubNumber(unNumber, state);
    }
    if (unMail !== "") {
        unsubMail(unMail, state);
    }
}

//*********************************************************************
//********** Filtriranje ako korisnik zeli vise proizvoda *************
//*********************************************************************

function ChangeQuant(answer) {

    if (answer == "yes") {
        multiProduct = 1;
        $('#quest8a2').slideDown();
    } else {
        multiProduct = 0;
        $('#quest8a2').slideUp();
    }

    $('#product_f').trigger('change'); // potreban trigger da se povuku i filtriraju ispravni paketi
}
//*********************************************************************
//********** Show CSV in whiteBox *************************************
//*********************************************************************

function readTextFile(file)
{
    $('#csvViewBox').empty();
    $('.csvViewBox').show();
    console.log(file);
    var rawFile = new XMLHttpRequest();
    rawFile.open("GET", file, true);
    rawFile.onreadystatechange = function ()
    {
        if(rawFile.readyState === 4)
        {
            if(rawFile.status === 200 || rawFile.status == 0)
            {
                var allText = rawFile.responseText;
                $('#csvViewBox').append(allText);
            }
        }
    }
    rawFile.send(null);
}