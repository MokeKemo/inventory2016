$(function() {
    var dialog, form,
    
    // From http://www.whatwg.org/specs/web-apps/current-work/multipage/states-of-the-type-attribute.html#e-mail-state-%28type=email%29
        emailRegex = /^[a-zA-Z0-9.!#$%&'*+\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)*$/,
        name = $( "#name" ),
        email = $( "#email" ),
        password = $( "#password" ),
        allFields = $( [] ).add( name ).add( email ).add( password ),
        tips = $( ".validateTips" );

    function updateTips( t ) {
        tips
            .text( t )
            .addClass( "ui-state-highlight" );
        setTimeout(function() {
            tips.removeClass( "ui-state-highlight", 1500 );
        }, 500 );
    }

    function checkLength( o, n, min, max ) {
        if ( o.val().length > max || o.val().length < min ) {
            o.addClass( "ui-state-error" );
            updateTips( "Length of " + n + " must be between " +
                min + " and " + max + "." );
            return false;
        } else {
            return true;
        }
    }

    function checkRegexp( o, regexp, n ) {
        if ( !( regexp.test( o.val() ) ) ) {
            o.addClass( "ui-state-error" );
            updateTips( n );
            return false;
        } else {
            return true;
        }
    }
	
	var global;

    function addUser() {
        var valid = true;
        allFields.removeClass( "ui-state-error" );

        valid = valid && checkLength( name, "username", 3, 16 );
        valid = valid && checkLength( email, "email", 6, 80 );
        valid = valid && checkLength( password, "password", 5, 16 );

        valid = valid && checkRegexp( name, /^[a-z]([0-9a-z_\s])+$/i, "Username may consist of a-z, 0-9, underscores, spaces and must begin with a letter." );
        valid = valid && checkRegexp( email, emailRegex, "eg. ui@jquery.com" );
        valid = valid && checkRegexp( password, /^([0-9a-zA-Z])+$/, "Password field only allow : a-z 0-9" );

        if ( valid ) {
            $( "#users tbody" ).append( "<tr>" +
                "<td>" + name.val() + "</td>" +
                "<td>" + email.val() + "</td>" +
                "<td>" + password.val() + "</td>" +
                "</tr>" );
            dialog.dialog( "close" );
        }
        return valid;
    }
   
        dialog = $( "#dialog-form" ).dialog({
        autoOpen: false,
        height: 600,
        width: 960,
        modal: true,
        buttons: {
		    Edit: function(){
				updateProfile();
			}, 
            Cancel: function() {
                dialog.dialog( "close" );
            }
        },
        close: function() {
            form[ 0 ].reset();
            allFields.removeClass( "ui-state-error" );
        }
    });

    form = dialog.find( "form" ).on( "submit", function( event ) {
        event.preventDefault();
        addUser();
    });



   $('.openPopup').click(function () {
        dialog.dialog( "open" );
		
        var podaciForme ={};
        podaciForme['action'] = 'showProfile';

        
        podaciForme['id'] = $(this).val();
        
        $('#editID').attr('value',podaciForme['id']); 

         
        $.ajax({
            url:"settings/adapter.php",
            type:"POST",
            dataType:"JSON",
            data:podaciForme,
            async: true,
            success:function(data){
			console.log(data);
                if (data) {
					
                    var profile = data[0];
					//console.log(profile);
					 
                    
                    $('.popup-form input[name="title1"]').val(profile['title1']);
                    $('.popup-form input[name="descr"]').val(profile['description']);
                    $('.popup-form input[name="quant"]').val(profile['quantity']);
                    $('.popup-form input[name="title2"]').val(profile['title2']);
                    $('.popup-form input[name="serialnumber"]').val(profile['serialnumber']);
                    $('.popup-form input[name="invoice_number"]').val(profile['invoice_number']);
                    $('.popup-form input[name="cost"]').val(profile['price']);
                    $('.popup-form input[name="name1"]').val(profile['name1']);
                    $('.popup-form input[name="datum"]').val(profile['date']);
                    $('.popup-form input[name="name2"]').val(profile['name2']);
                    $('.popup-form input[name="title3"]').val(profile['title3']);
                }
                else
                {
                    console.log("ne radi: " + data);
                }
            }
        });
        

    });


/*
function callUpdate(){
    updateProfile(podaciForme['id']);
}
*/

 function updateProfile(id) {
        if (!confirm("Update Profile Data?")) {
            return;
        }

        var podaciPopupa = {};
        podaciPopupa['action'] = 'editProfile';
        podaciPopupa['id']=$('#editID').val();
        podaciPopupa['ajdi']=id;
        $(".popup-form [name]").each(function() {
            var kljuc = $(this).attr("name");
            var vrijednost = $(this).val();
            podaciPopupa[kljuc] = vrijednost;
        });
        

        console.log(podaciPopupa);
        
        

        if (
            podaciPopupa["title1"] == ""    ||  podaciPopupa["description"] == ""       ||podaciPopupa["quantity"] == ""       ||
           podaciPopupa["title2"] == ""     || podaciPopupa["serialnumber"] == ""    || podaciPopupa["price"] == ""     ||
            podaciPopupa["name1"] == ""  ||  podaciPopupa["date"] == ""  ||  podaciPopupa["name2"] == ""  ||  podaciPopupa["title3"] == ""){
            //console.log("You must fill out the form!");
            //alert("You must fill out the form!");
            $('#popup-message').text("You must fill out the form!");
            return false;
        }
        
         
        $.ajax({
            url:"settings/adapter.php",
            type:"POST",
            dataType:"JSON",
            data:podaciPopupa,
            async: true,
            success:function(data){
                if(data) {
                    console.log(podaciPopupa);
                    showSuccess("Profile updated!");
                    //console.log("Profile updated!");
                    $( "#dialog-form" ).dialog( "close" );
                    //location.reload();
                } else {
                    //showWarning("Error editing member profile. Please try again later.");
                    alert("Error editing member profile. Please try again later.");
                    console.log("Error editing member profile. Please try again later.");
                }
            }
        });

	

        return; //valid;
    }
	
	
	showPopupFunction = function(id)
{




    $('#popup-message').text('');
    var podaciForme ={};

    

    podaciForme['action'] = 'showProfile';
    podaciForme['id']=id;
    
    


    console.log(podaciForme);


    
    dialog = $( "#showUserForm" ).dialog({
        autoOpen: false,
        height: 600,
        width: 960,
        modal: true,
        buttons: {
            Edit: function(){
                updateProfileFromSearch(podaciForme['id']);
            },
            Cancel: function() {
                dialog.dialog( "close" );
            }
        },
        close: function() {
            dialog.dialog( "close" );
            allFields.removeClass( "ui-state-error" );
        }
    });

    form = dialog.find( "form" ).on( "submit", function( event ) {
        event.preventDefault();
        addUser();
    });
    //$('.popup-form input[name="id"]').val(podaciForme['id']);

    /*if (!podaciForme["id"]){
     showWarning("Error! Please try again later.");
     return false;
     }
     */

    $.ajax({
        url:"settings/adapter.php",
        type:"POST",
        dataType:"JSON",
        data:podaciForme,
        async: true,
        success:function(data){
            if (podaciForme) {
                //console.log(podaciForme); 
                //var profile = podaciForme[0];
                
                var profile = data[0];

                $('.popup-form input[name="title1"]').val(profile['title1']);
                $('.popup-form input[name="descr"]').val(profile['description']);
                $('.popup-form input[name="quant"]').val(profile['quantity']);
                $('.popup-form input[name="title2"]').val(profile['title2']);
                $('.popup-form input[name="serialnumber"]').val(profile['serialnumber']);
                $('.popup-form input[name="invoice_number"]').val(profile['invoice_number']);
                $('.popup-form input[name="cost"]').val(profile['price']);
                $('.popup-form input[name="name1"]').val(profile['name1']);
                $('.popup-form input[name="datum"]').val(profile['date']);
                $('.popup-form input[name="name2"]').val(profile['name2']);
                $('.popup-form input[name="title3"]').val(profile['title3']);
            } else {
                console.log("ne radi: " + data);
            }
        }
    });
    dialog.dialog( "open" );

}


 function updateProfileFromSearch(id) {
        if (!confirm("Update Profile Data?")) {
            return;
        }

        var podaciPopupa = {};
        podaciPopupa['action'] = 'editProfileFromSearch';
        //podaciPopupa['id']=$('#editID').val();
        podaciPopupa['id']=id;
        $(".popup-form [name]").each(function() {
            var kljuc = $(this).attr("name");
            var vrijednost = $(this).val();
            podaciPopupa[kljuc] = vrijednost;
        });
        

        //console.log(podaciPopupa);
        
        

        if (
            podaciPopupa["title1"] == ""    ||  podaciPopupa["description"] == ""       ||podaciPopupa["quantity"] == ""       ||
           podaciPopupa["title2"] == ""     || podaciPopupa["serialnumber"] == ""    || podaciPopupa["price"] == ""     ||
            podaciPopupa["name1"] == ""  ||  podaciPopupa["date"] == ""  ||  podaciPopupa["name2"] == ""  ||  podaciPopupa["title3"] == ""){
            //console.log("You must fill out the form!");
            //alert("You must fill out the form!");
            $('#popup-message').text("You must fill out the form!");
            return false;
        }
        
         
        $.ajax({
            url:"settings/adapter.php",
            type:"POST",
            dataType:"JSON",
            data:podaciPopupa,
            async: true,
            success:function(data){
                if(podaciPopupa) {
                    console.log(podaciPopupa);
                    showSuccess("Profile updated!");
                   
                    $( "#dialog-form" ).dialog( "close" );
                    location.reload();
                } else {
                    //showWarning("Error editing member profile. Please try again later.");
                    alert("Error editing member profile. Please try again later.");
                    console.log("Error editing member profile. Please try again later.");
                }
            }
        });

    
        /*
        var valid = true;
        allFields.removeClass( "ui-state-error" );

        valid = valid && checkLength( name, "username", 3, 16 );
        valid = valid && checkLength( email, "email", 6, 80 );
        valid = valid && checkLength( password, "password", 5, 16 );

        valid = valid && checkRegexp( name, /^[a-z]([0-9a-z_\s])+$/i, "Username may consist of a-z, 0-9, underscores, spaces and must begin with a letter." );
        valid = valid && checkRegexp( email, emailRegex, "eg. ui@jquery.com" );
        valid = valid && checkRegexp( password, /^([0-9a-zA-Z])+$/, "Password field only allow : a-z 0-9" );

        if ( valid ) {
            $( "#users tbody" ).append( "<tr>" +
                "<td>" + name.val() + "</td>" +
                "<td>" + email.val() + "</td>" +
                "<td>" + password.val() + "</td>" +
                "</tr>" );
            dialog.dialog( "close" );
        }*/
        return; //valid;
    }
    






	});






















