$(function(){
//    showpop('good. working');
//    register user via ajax

    loadStaffRoles();
    if($('ul.tabs-animated-shadow a').length >0) {
        $('ul.tabs-animated-shadow a')[0].click();
    }
    
     if($('select.select2').length > 0 ){       
        $('select.select2').select2();         
    }
    
     if($('#country').length > 0 ){
        $('#country').trigger('change'); 
       //  setTimeout(load_student_state_of_origin(),1000);    
    }
     if($('#account_type').length > 0 ){
        $("div.family").hide();
        $('select#account_type').trigger('change'); 
        if($('select#account_type').val()=="family"){ $("div.family").show('fast'); }
        else {  $("div.family").hide('fast'); }
        
        toggleShowAddress();
        toggleShowNok();        
    }
    
    if($('#is_for_sale').length > 0 ){
        $("div.sales_propts").hide();
        $('input#is_for_sale').trigger('change'); 
        if($('input#is_for_sale').prop('checked')){
            $("div.sales_propts").show('fast'); 
            $("input#new_qty").prop("required",true); 
            
        }
         else {
             $("div.sales_propts").hide('fast'); 
             $("input#new_qty").prop("required",false); 
            }
    }
    
    // when viewing ticket page  
    if($('#filteration').length > 0 ){
      show_pending_tickets(); 
    }
    
    hideInactiveTables(); add_tinymce();

    var log_messager = $("#login-message"); log_messager.hide('fast');
    $('#loginForm').submit(function(ev){ ev.preventDefault();
        var l = Ladda.create(document.querySelector('.login-btn'));
        var formdata = $(this).serialize();
          $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/portal/login',
            data:formdata,
            beforeSend :function(){ $(document).find('span.error-text').text(''); log_messager.hide('fast'); l.start(); $("span.message").text(''); ; } ,
            success:function(resp, textStatus, http){ l.stop();
              if(resp.type==="success"){
                   log_messager.show('fast');
                   log_messager.removeClass('alert-orange').addClass('alert-success');
                   $("span.message").text(resp.message);
                   window.location.href = resp.url;
              }
              else if(resp.type==="incorrect" || resp.type==="inactive"){
                  log_messager.show('fast');
                  log_messager.removeClass('alert-success').addClass('alert-orange');
                  $("span.message").text(resp.message);
              }
              else if(resp.type==="error"){
                  $.each(resp.errors,function(prefix,val){
                       $('span.admin_'+prefix+'_error').text(val[0]);
                  });
              }
            },
            error:function(jhx,textStatus,errorThrown){ l.stop();
                checkStatus(jhx.status); }
            });
        });



    /*************************************/
        $('#current_password').on('keyup',function(){
        var current_password = $(this).val();
        $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/check-admin-password',
            data:{current_password:current_password},
            success:function(resp, textStatus, http){
                if(resp == "false") { $("#check_password").html("<font color='red'>current password is incorrect </font>");}
                else if(resp == "true") { $("#check_password").html("<font color='green'>current password is correct </font>");}
            },
            error:function(jhx,textStatus,errorThrown){
                checkStatus(jhx.status); }
        });
    });

   /******** CALCULATE ADULT VS CHILDREN PRICE ***********/

    $('#price1').on('keyup',function(){
        // var aprice = $(this).val();
        // var discount = parseFloat(aprice) * 0.75;
        // var bprice = aprice - discount;
        // $('#price2').val(discount); //   var bprice =
    });

$(document).on('click','.updateAdminStatus',function(){
    var status = $(this).children('i').attr('status');
    var admin_id = $(this).attr('admin_id');
     $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/update-admin-status',
            data:{status:status,admin_id:admin_id},
            success:function(resp, textStatus, http){ // alert(resp);
                 if(resp['status'] == "0") { $("#admin-"+admin_id).html("<i class='pe-7s-attention pe-2x font-weight-bold  text-danger' status='inactive'></i>");}
                 else if(resp['status'] == "1") { $("#admin-"+admin_id).html("<i class='pe-7s-check pe-2x font-weight-bold  text-success' status='active'></i>");}
                    showpop(resp['status'],'success');
            },
            error:function(jhx,textStatus,errorThrown){
                checkStatus(jhx.status); }
        });
});


$(document).on('click','.updateDrugCategStatus',function(){
    var status = $(this).children('i').attr('status');    
    var url="/admin/update-drug-categ-status";
    var ref_name = "drug_categ_id";
    var real_value = $(this).attr(ref_name);
    var real_ref = $("#"+ref_name+"-"+real_value);
    var loader = "."+ref_name+"-"+real_value;
    var message = ['Drug Category Successfully Deleted','Drug Category Successfully Restored'];
       //  alert("."+ref_name+"_"+real_value); exit ; 
     $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')  
            },
            type:'post',
            url:url, beforeSend:function(){startLoader(loader,true);},
            data:{status:status,data_id:real_value},
            success:function(resp){ // alert(resp);
                 if(resp['status'] == "0") { 
                     real_ref.html("<i class='pe-7s-attention pe-2x font-weight-bold  text-danger' status='inactive'></i>  Deleted ");
                     real_ref.closest('tr').removeClass('active');
                     real_ref.closest('tr').addClass('inactive'); 
                }
                 else if(resp['status'] == "1") { 
                     real_ref.html("<i class='pe-7s-check pe-2x font-weight-bold  text-success' status='active'></i> Active");
                     real_ref.closest('tr').removeClass('inactive');
                     real_ref.closest('tr').addClass('active');  
                }
                stopLoader(loader,true);
               showpop(message[resp['status']],'success');  hideInactiveTables();
            }, 
		error:function(jhx,textStatus,errorThrown){  
                checkStatus(jhx.status); 
                }
        });
});

$(document).on('click','.updateBillTypeStatus',function(){
    var status = $(this).children('i').attr('status');
    var bill_type_id = $(this).attr('bill_type_id');
     var message= ['Bill Sample Successfully Deleted','Bill Sample Successfully Restored'];
     $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/update-bill-type-status',
            data:{status:status,bill_type_id:bill_type_id},
            success:function(resp, textStatus, http){ // alert(resp);
                 if(resp['status'] == "0") {
                     $("#bill_type_id-"+bill_type_id).html("<i class='pe-7s-attention pe-2x font-weight-bold  text-danger' status='inactive'></i> Inactive ");
                     $("#bill_type_id-"+bill_type_id).closest('tr').removeClass('active');
                     $("#bill_type_id-"+bill_type_id).closest('tr').addClass('inactive');
                }
                 else if(resp['status'] == "1") {
                     $("#bill_type_id-"+bill_type_id).html("<i class='pe-7s-check pe-2x font-weight-bold  text-success' status='active'></i> Active ");
                     $("#bill_type_id-"+bill_type_id).closest('tr').removeClass('inactive');
                     $("#bill_type_id-"+bill_type_id).closest('tr').addClass('active');
                }
              showpop(message[resp['status']],'success');  hideInactiveTables();
            },
            error:function(jhx,textStatus,errorThrown){
                checkStatus(jhx.status); }
        });
});


$(document).on('click','.updateMicroOrgStatus',function(){
    var status = $(this).children('i').attr('status');
    var micro_id = $(this).attr('microorg_id');
    var message= ['Micro-Organism Successfully Deleted','Micro-Organism Successfully Restored'];
     $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/update-microorganism-status',
            data:{status:status,micro_id:micro_id},
            success:function(resp, textStatus, http){ // alert(resp);
                 if(resp['status'] == "0") {
                    $("#microorg_id-"+micro_id).html("<i class='pe-7s-attention pe-2x font-weight-bold  text-danger' status='inactive'></i> Not Active");
                    $("#microorg_id-"+micro_id).closest('tr').removeClass('active');
                    $("#microorg_id-"+micro_id).closest('tr').addClass('inactive');
                 }
                 else if(resp['status'] == "1") { 
                    $("#microorg_id-"+micro_id).html("<i class='pe-7s-check pe-2x font-weight-bold  text-success' status='active'></i> Active ");
                    $("#microorg_id-"+micro_id).closest('tr').removeClass('inactive');
                    $("#microorg_id-"+micro_id).closest('tr').addClass('active');
                }
                showpop(message[resp['status']],'success');  hideInactiveTables();
            },
            error:function(jhx,textStatus,errorThrown){
                checkStatus(jhx.status); }
        });
});


$(document).on('click','.updateMicroTreatmentStatus',function(){   
    var status = $(this).children('i').attr('status');    
    var url="/admin/update-microorg-treament-status";
    var ref_name = "treatment_id";
    var real_value = $(this).attr(ref_name);
    var real_ref = $("#"+ref_name+"-"+real_value);
    var loader = "."+ref_name+"-"+real_value;
    var message = ['MicroOrganism Teatment Successfully Deleted','MicroOrganism Teatment Successfully Restored'];
       //  alert("."+ref_name+"_"+real_value); exit ; 
     $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')  
            },
            type:'post',
            url:url, beforeSend:function(){startLoader(loader,true);},
            data:{status:status,data_id:real_value},
            success:function(resp){ // alert(resp);
                 if(resp['status'] == "0") { 
                     real_ref.html("<i class='pe-7s-attention pe-2x font-weight-bold  text-danger' status='inactive'></i>  Deleted ");
                     real_ref.closest('tr').removeClass('active');
                     real_ref.closest('tr').addClass('inactive'); 
                }
                 else if(resp['status'] == "1") { 
                     real_ref.html("<i class='pe-7s-check pe-2x font-weight-bold  text-success' status='active'></i> Active");
                     real_ref.closest('tr').removeClass('inactive');
                     real_ref.closest('tr').addClass('active');  
                }
                stopLoader(loader,true);
               showpop(message[resp['status']],'success');  hideInactiveTables();
            }, 
		error:function(jhx,textStatus,errorThrown){  
                checkStatus(jhx.status); 
                }
        });
});

$(document).on('click','.updateBillTemplateChildStatus',function(){   
    var status = $(this).children('i').attr('status');    
    var url="/admin/update-bill-template-child-status";
    var ref_name = "templist_id";
    var real_value = $(this).attr(ref_name);
    var real_ref = $("#"+ref_name+"-"+real_value);
    var loader = "."+ref_name+"-"+real_value;
    var message = ['Template Sample Successfully Deleted','Template Sample Successfully Restored'];
       //  alert("."+ref_name+"_"+real_value); exit ; 
     $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')  
            },
            type:'post',
            url:url, beforeSend:function(){startLoader(loader,true);},
            data:{status:status,data_id:real_value},
            success:function(resp){ // alert(resp);
                 if(resp['status'] == "0") { 
                     real_ref.html("<i class='pe-7s-attention pe-2x font-weight-bold  text-danger' status='inactive'></i>  Deleted ");
                     real_ref.closest('tr').removeClass('active');
                     real_ref.closest('tr').addClass('inactive'); 
                }
                 else if(resp['status'] == "1") { 
                     real_ref.html("<i class='pe-7s-check pe-2x font-weight-bold  text-success' status='active'></i> Active");
                     real_ref.closest('tr').removeClass('inactive');
                     real_ref.closest('tr').addClass('active');  
                }
                stopLoader(loader,true);
               showpop(message[resp['status']],'success');  hideInactiveTables();
            }, 
		error:function(jhx,textStatus,errorThrown){  
                checkStatus(jhx.status); 
                }
        });
});


/// 

$(document).on('click','.updateTestStatus',function(){   
    var status = $(this).children('i').attr('status');    
    var url="/admin/update-test-status";
    var ref_name = "test_id";
    var real_value = $(this).attr(ref_name);
    var real_ref = $("#"+ref_name+"-"+real_value);
    var loader = "."+ref_name+"-"+real_value;
    var message = ['Test Successfully Deleted','Test Successfully Restored'];
       //  alert("."+ref_name+"_"+real_value); exit ; 
     $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')  
            },
            type:'post',
            url:url, beforeSend:function(){startLoader(loader,true);},
            data:{status:status,data_id:real_value},
            success:function(resp){ // alert(resp);
                 if(resp['status'] == "0") { 
                     real_ref.html("<i class='pe-7s-attention pe-2x font-weight-bold  text-danger' status='inactive'></i>  Deleted ");
                     real_ref.closest('tr').removeClass('active');
                     real_ref.closest('tr').addClass('inactive'); 
                }
                 else if(resp['status'] == "1") { 
                     real_ref.html("<i class='pe-7s-check pe-2x font-weight-bold  text-success' status='active'></i> Active");
                     real_ref.closest('tr').removeClass('inactive');
                     real_ref.closest('tr').addClass('active');  
                }
                stopLoader(loader,true);
               showpop(message[resp['status']],'success');  hideInactiveTables();
            }, 
		error:function(jhx,textStatus,errorThrown){  
                checkStatus(jhx.status); 
                }
        });
});

$(document).on('click','.updateDrugStatus',function(){   
    var status = $(this).children('i').attr('status');    
    var url="/admin/update-drug-status";
    var ref_name = "drug_id";
    var real_value = $(this).attr(ref_name);
    var real_ref = $("#"+ref_name+"-"+real_value);
    var loader = "."+ref_name+"-"+real_value;
    var message = ['Drug Successfully Deleted','Drug Successfully Restored'];
       //  alert("."+ref_name+"_"+real_value); exit ; 
     $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')  
            },
            type:'post',
            url:url, beforeSend:function(){startLoader(loader,true);},
            data:{status:status,data_id:real_value},
            success:function(resp){ // alert(resp);
                 if(resp['status'] == "0") { 
                     real_ref.html("<i class='pe-7s-attention pe-2x font-weight-bold  text-danger' status='inactive'></i>  Deleted ");
                     real_ref.closest('tr').removeClass('active');
                     real_ref.closest('tr').addClass('inactive'); 
                }
                 else if(resp['status'] == "1") { 
                     real_ref.html("<i class='pe-7s-check pe-2x font-weight-bold  text-success' status='active'></i> Active");
                     real_ref.closest('tr').removeClass('inactive');
                     real_ref.closest('tr').addClass('active');  
                }
                stopLoader(loader,true);
               showpop(message[resp['status']],'success');  hideInactiveTables();
            }, 
		error:function(jhx,textStatus,errorThrown){  
                checkStatus(jhx.status); 
                }
        });
});

$(document).on('click','.updateLenseStatus',function(){   
    var status = $(this).children('i').attr('status');    
    var url="/admin/update-lense-status";
    var ref_name = "lense_id";
    var real_value = $(this).attr(ref_name);
    var real_ref = $("#"+ref_name+"-"+real_value);
    var loader = "."+ref_name+"-"+real_value;
    var message = ['Lense Successfully Deleted','Lense Successfully Restored'];
       //  alert("."+ref_name+"_"+real_value); exit ; 
     $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')  
            },
            type:'post',
            url:url, beforeSend:function(){startLoader(loader,true);},
            data:{status:status,data_id:real_value},
            success:function(resp){ // alert(resp);
                 if(resp['status'] == "0") { 
                     real_ref.html("<i class='pe-7s-attention pe-2x font-weight-bold  text-danger' status='inactive'></i>  Deleted ");
                     real_ref.closest('tr').removeClass('active');
                     real_ref.closest('tr').addClass('inactive'); 
                }
                 else if(resp['status'] == "1") { 
                     real_ref.html("<i class='pe-7s-check pe-2x font-weight-bold  text-success' status='active'></i> Active");
                     real_ref.closest('tr').removeClass('inactive');
                     real_ref.closest('tr').addClass('active');  
                }
                stopLoader(loader,true);
               showpop(message[resp['status']],'success');  hideInactiveTables();
            }, 
		error:function(jhx,textStatus,errorThrown){  
                checkStatus(jhx.status); 
                }
        });
});


$(document).on('click','.updateLenseCategStatus',function(){
    var status = $(this).children('i').attr('status');    
    var url="/admin/update-lense-categ-status";
    var ref_name = "lense_categ_id";
    var real_value = $(this).attr(ref_name);
    var real_ref = $("#"+ref_name+"-"+real_value);
    var loader = "."+ref_name+"-"+real_value;
    var message = ['Lense Category Successfully Deleted','Lense Category Successfully Restored'];
       //  alert("."+ref_name+"_"+real_value); exit ; 
     $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')  
            },
            type:'post',
            url:url, beforeSend:function(){startLoader(loader,true);},
            data:{status:status,data_id:real_value},
            success:function(resp){ // alert(resp);
                 if(resp['status'] == "0") { 
                     real_ref.html("<i class='pe-7s-attention pe-2x font-weight-bold  text-danger' status='inactive'></i>  Deleted ");
                     real_ref.closest('tr').removeClass('active');
                     real_ref.closest('tr').addClass('inactive'); 
                }
                 else if(resp['status'] == "1") { 
                     real_ref.html("<i class='pe-7s-check pe-2x font-weight-bold  text-success' status='active'></i> Active");
                     real_ref.closest('tr').removeClass('inactive');
                     real_ref.closest('tr').addClass('active');  
                }
                stopLoader(loader,true);
               showpop(message[resp['status']],'success');  hideInactiveTables();
            }, 
		error:function(jhx,textStatus,errorThrown){  
                checkStatus(jhx.status); 
                }
        });
});

$(document).on('click','.updateLenseTypeStatus',function(){
    var status = $(this).children('i').attr('status');    
    var url="/admin/update-lense-type-status";
    var ref_name = "lense_type_id";
    var real_value = $(this).attr(ref_name);
    var real_ref = $("#"+ref_name+"-"+real_value);
    var loader = "."+ref_name+"-"+real_value;
    var message = ['Lense Type Successfully Deleted','Lense Type Successfully Restored'];
       //  alert("."+ref_name+"_"+real_value); exit ; 
     $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')  
            },
            type:'post',
            url:url, beforeSend:function(){startLoader(loader,true);},
            data:{status:status,data_id:real_value},
            success:function(resp){ // alert(resp);
                 if(resp['status'] == "0") { 
                     real_ref.html("<i class='pe-7s-attention pe-2x font-weight-bold  text-danger' status='inactive'></i>  Deleted ");
                     real_ref.closest('tr').removeClass('active');
                     real_ref.closest('tr').addClass('inactive'); 
                }
                 else if(resp['status'] == "1") { 
                     real_ref.html("<i class='pe-7s-check pe-2x font-weight-bold  text-success' status='active'></i> Active");
                     real_ref.closest('tr').removeClass('inactive');
                     real_ref.closest('tr').addClass('active');  
                }
                stopLoader(loader,true);
               showpop(message[resp['status']],'success');  hideInactiveTables();
            }, 
		error:function(jhx,textStatus,errorThrown){  
                checkStatus(jhx.status); 
                }
        });
});

$(document).on('click','.updateFrameStatus',function(){
    var status = $(this).children('i').attr('status');    
    var url="/admin/update-frame-status";
    var ref_name = "frame_id";
    var real_value = $(this).attr(ref_name);
    var real_ref = $("#"+ref_name+"-"+real_value);
    var loader = "."+ref_name+"-"+real_value;
    var message = ['Frame Successfully Deleted','Frame Successfully Restored'];
       //  alert("."+ref_name+"_"+real_value); exit ; 
     $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')  
            },
            type:'post',
            url:url, beforeSend:function(){startLoader(loader,true);},
            data:{status:status,data_id:real_value},
            success:function(resp){ // alert(resp);
                 if(resp['status'] == "0") { 
                     real_ref.html("<i class='pe-7s-attention pe-2x font-weight-bold  text-danger' status='inactive'></i>  Deleted ");
                     real_ref.closest('tr').removeClass('active');
                     real_ref.closest('tr').addClass('inactive'); 
                }
                 else if(resp['status'] == "1") { 
                     real_ref.html("<i class='pe-7s-check pe-2x font-weight-bold  text-success' status='active'></i> Active");
                     real_ref.closest('tr').removeClass('inactive');
                     real_ref.closest('tr').addClass('active');  
                }
                stopLoader(loader,true);
               showpop(message[resp['status']],'success');  hideInactiveTables();
            }, 
		error:function(jhx,textStatus,errorThrown){  
                checkStatus(jhx.status); 
                }
        });
});

$(document).on('click','.updateBankAccountStatus',function(){
    var status = $(this).children('i').attr('status');    
    var url="/admin/update-bank-account-status";
    var ref_name = "account_id";
    var real_value = $(this).attr(ref_name);
    var real_ref = $("#"+ref_name+"-"+real_value);
    var loader = "."+ref_name+"-"+real_value;
    var message = ['Account Successfully Deleted','Account Successfully Restored'];
       //  alert("."+ref_name+"_"+real_value); exit ; 
     $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')  
            },
            type:'post',
            url:url, beforeSend:function(){startLoader(loader,true);},
            data:{status:status,data_id:real_value},
            success:function(resp){ // alert(resp);
                 if(resp['status'] == "0") { 
                     real_ref.html("<i class='pe-7s-attention pe-2x font-weight-bold  text-danger' status='inactive'></i>  Deleted ");
                     real_ref.closest('tr').removeClass('active');
                     real_ref.closest('tr').addClass('inactive'); 
                }
                 else if(resp['status'] == "1") { 
                     real_ref.html("<i class='pe-7s-check pe-2x font-weight-bold  text-success' status='active'></i> Active");
                     real_ref.closest('tr').removeClass('inactive');
                     real_ref.closest('tr').addClass('active');  
                }
                stopLoader(loader,true);
               showpop(message[resp['status']],'success');  hideInactiveTables();
            }, 
		error:function(jhx,textStatus,errorThrown){  
                checkStatus(jhx.status); 
                }
        });
});

$(document).on('click','.updateOrganizationStatus',function(){
    var status = $(this).children('i').attr('status');    
    var url="/admin/update-organization-status";
    var ref_name = "organization_id";
    var real_value = $(this).attr(ref_name);
    var real_ref = $("#"+ref_name+"-"+real_value);
    var loader = "."+ref_name+"-"+real_value;
    var message = ['Organization Body Successfully Deleted','Organization Body Successfully Restored'];
       //  alert("."+ref_name+"_"+real_value); exit ; 
     $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')  
            },
            type:'post',
            url:url, beforeSend:function(){startLoader(loader,true);},
            data:{status:status,data_id:real_value},
            success:function(resp){ // alert(resp);
                 if(resp['status'] == "0") { 
                     real_ref.html("<i class='pe-7s-attention pe-2x font-weight-bold  text-danger' status='inactive'></i>  Deleted ");
                     real_ref.closest('tr').removeClass('active');
                     real_ref.closest('tr').addClass('inactive'); 
                }
                 else if(resp['status'] == "1") { 
                     real_ref.html("<i class='pe-7s-check pe-2x font-weight-bold  text-success' status='active'></i> Active");
                     real_ref.closest('tr').removeClass('inactive');
                     real_ref.closest('tr').addClass('active');  
                }
                stopLoader(loader,true);
               showpop(message[resp['status']],'success');  hideInactiveTables();
            }, 
		error:function(jhx,textStatus,errorThrown){  
                checkStatus(jhx.status); 
                }
        });
});

   

// Perission Filter
$(document).on('click','.role-perm-btn',function(){
    var l = Ladda.create(this);
    var role_id = $('#role').val();
    if(role_id==""){
        $('#permissions-view').html('');
        showpop('Please select Role','error');
    }
    else {
        $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/load-permissions',
            data:{role_id:role_id },
            beforeSend:function(){ l.start(); },
            success:function(resp, textStatus, http){  // alert(resp);
                l.stop();
                $('#permissions-view').html(resp.view);
            },
            error:function(jhx,textStatus,errorThrown){   l.stop();
                checkStatus(jhx.status); }
        });
    }

});


// checkboxes permissions
$(document).on('click','.role-perm-custom',function(){
    var perm = $(this).val();
    var role_id = $(this).data('role');
    var status = 'inactive';  $(this).closest('div.col-md-3').removeClass('table-success');
    if($(this).prop('checked')) {  status = 'active';
       $(this).closest('div.col-md-3').addClass('table-success'); }
     var process = "<span class='fa fa-spin fa-spinner fa-3x text-dark'></span>";
    // update permission
    $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/change-role-permission',
            data:{role_id:role_id,perm:perm,status:status },
            beforeSend:function(){ showpop(process,'info'); },
            success:function(resp, textStatus, http){  // alert(resp);
               showpop(resp.message) ;
            },
            error:function(jhx,textStatus,errorThrown){   l.stop();
                checkStatus(jhx.status); }
        });
   // console.log('perm - '+perm+" id = "+roleid + " status = "+status) ;
});
 // role-perm-custom

 // start bill template setup form
 /******************************************/
 var checks =  $('input.result_temp:checked').length;
 if(checks>=1){
     setTimeout(function(){$('button.start-bill-template-btn').click(); },500);
 }
 /******************************************/
$(document).on('click','.start-bill-template-btn',function(){
  var btn = '.start-bill-template-btn';
  var result_temp = $('input:radio.result_temp:checked').val();
   if(result_temp === undefined){
        $('.body-form').html('');
        showpop('Please select one type of template for this Test','error');
    }
    else {
        $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/start-bill-template-setup',
            data: $('form#bill_template_setup').serialize() ,
            beforeSend:function(){ startLoader(btn); startLoader();  $('.body-form').html('');  },
            success:function(resp, textStatus, http){  // alert(resp);
                stopLoader(btn); stopLoader();
                $('.body-form').html(resp.view);
                reload_unit_tinymce();
                reload_text_tinymce();
            },
            error:function(jhx,textStatus,errorThrown){ stopLoader(btn); stopLoader();
                checkStatus(jhx.status); }
        });
    }
});

 //  param-template-submit-btn
  // continue bill template setup form
 /******************************************/
$(document).on('click','.param-template-submit-btn',function(){
  var btn = '.param-template-submit-btn';
   tinymce.triggerSave();
  var forms = $('form#param_temp_form').serialize();
  $.ajax({
    headers:{
      'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
    },
    type:'post',
    url:'/admin/submit-param-bill-template-form',
    data: forms ,
    beforeSend:function(){ startLoader(btn);  $(document).find('span.error-text').text(''); },
    success:function(resp, textStatus, http){  // alert(resp);
        stopLoader(btn); stopLoader();
          if(resp.type==="success"){
            showpop(resp.message);
            window.location.href = resp.url;
        }
        else if(resp.type==="error"){
           $.each(resp.errors,function(prefix,val){
                $('span.temp_'+prefix+'_error').text(val[0]);
           });
        }
    },
    error:function(jhx,textStatus,errorThrown){ stopLoader(btn); stopLoader();
        checkStatus(jhx.status); }
    });

 });
//  text-template-submit-btn
$(document).on('click','.text-template-submit-btn',function(){
  var btn = '.text-template-submit-btn';
  tinymce.triggerSave();
  var forms = $('form#text_temp_form').serialize();
  $.ajax({
    headers:{
      'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
    },
    type:'post',
    url:'/admin/submit-text-bill-template-form',
    data: forms ,
    beforeSend:function(){ startLoader(btn);  $(document).find('span.error-text').text(''); },
    success:function(resp, textStatus, http){  // alert(resp);
        stopLoader(btn); stopLoader();
          if(resp.type==="success"){
            showpop(resp.message);
            window.location.href = resp.url;
        }
        else if(resp.type==="error"){
           $.each(resp.errors,function(prefix,val){
                $('span.temp_'+prefix+'_error').text(val[0]);
           });
        }
    },
    error:function(jhx,textStatus,errorThrown){ stopLoader(btn); stopLoader();
        checkStatus(jhx.status); }
    });

 });

    // ticket search
    $(document).on('keyup','#customer_searcher',function(){
      var btn = '.customer-search-btn';
      var vals = $(this).val();
      if(vals.length > 2){
        $('#customer_searcher').attr('custom_id','');  // clear current custom id
          var forms = $('form#ticket_customer_search').serialize();
          $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/search-customer-info',
            data: forms ,
            beforeSend:function(){ startLoader(btn);  $('#customer_searcher').removeData('regno'); },
            success:function(resp, textStatus, http){  // alert(resp);
                stopLoader(btn); stopLoader();
                $('.found-customer').html(resp);
                $('.final-specimen-form').html("");
                $('#specimen_searcher').val('');
            },
            error:function(jhx,textStatus,errorThrown){ stopLoader(btn); stopLoader();
                checkStatus(jhx.status); }
            });
        } else {
            $('.found-customer').html("");
        }

     });

    // all customer search / filter
    $(document).on('keyup','#all_customer_filter',function(){
      var loader = '.customer-loader';
      var vals = $(this).val();
      if(vals.length > 2){
          var forms = $('form#all_customer_search').serialize();
          $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/filter-our-customers',
            data: {param:vals} ,
            beforeSend:function(){ startLoader(loader,true);   },  // $('#customer_searcher').removeData('regno');
            success:function(resp, textStatus, http){  // alert(resp);
                stopLoader(loader,true);
                $('.filtered_customers').html(resp.view);
                $("table.dataTable").dataTable();
            },
            error:function(jhx,textStatus,errorThrown){ stopLoader(btn); stopLoader();
                checkStatus(jhx.status); }
            });
        } else {
            $('.filtered_customers').html("");
        }

     });
     
     // all customer search / filter
    $(document).on('keyup','#search_customer_appointment',function(){
      var loader = '.customer-loader';
      var vals = $(this).val();
      if(vals.length > 2){          
          $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/filter-customers-for-appointment',
            data: {param:vals} ,
            beforeSend:function(){ startLoader(loader,true);   },  // $('#customer_searcher').removeData('regno');
            success:function(resp, textStatus, http){  // alert(resp);
                stopLoader(loader,true);
                $('.filtered_customers').html(resp.view);
                $("table.dataTable").dataTable();
            },
            error:function(jhx,textStatus,errorThrown){ stopLoader(btn); stopLoader();
                checkStatus(jhx.status); }
            });
        } else {
            $('.filtered_customers').html("");
        }

     });

     // payment / receipt search
    $(document).on('keyup','#customer_searcher_payment',function(){
      var btn = '.customer-search-payment-btn';
      var vals = $(this).val();
      if(vals.length > 2){
          var forms = $('form#ticket_customer_search').serialize();
          $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/search-customer-payment-info',
            data: forms ,
            beforeSend:function(){ startLoader(btn);  $('#customer_searcher_payment').removeData('ticket_no'); },
            success:function(resp, textStatus, http){  // alert(resp);
                stopLoader(btn); stopLoader();
                $('.found-payment').html(resp);
            },
            error:function(jhx,textStatus,errorThrown){ stopLoader(btn); stopLoader();
                 checkStatus(jhx.status); }
            });
        } else {
            $('.found-ticket').html("");
        }

     });

  // payment / receipt search
    $(document).on('keyup','#customer_searcher_payment',function(){
      var btn = '.customer-search-payment-btn';
      var vals = $(this).val();
      if(vals.length > 2){
          var forms = $('form#ticket_customer_search').serialize();
          $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/search-customer-payment-info',
            data: forms ,
            beforeSend:function(){ startLoader(btn);  $('#customer_searcher_payment').removeData('ticket_no'); },
            success:function(resp, textStatus, http){  // alert(resp);
                stopLoader(btn); stopLoader();
                $('.found-payment').html(resp);
            },
            error:function(jhx,textStatus,errorThrown){ stopLoader(btn); stopLoader();
                 checkStatus(jhx.status); }
            });
        } else {
            $('.found-ticket').html("");
        }

     });

     // auto detect customer account type 
    $(document).on('change','#account_type',function(){
        var account_type = $(this).val(); 
        var init_regno = $('input#init-user-regno').val();
        
        if(account_type==="outsider"){
            $('input#user-regno').prop('readonly',true);
            $('input#user-regno').val('auto-generate');
            // family
            $("div.family").hide();
        }
        else if(account_type==="personal"){
            $('input#user-regno').prop('readonly',false);
            $('input#user-regno').val(init_regno);
            $("div.family").hide();
        }
        else if(account_type==="family"){
            $('input#user-regno').prop('readonly',false);
            $('input#user-regno').val(init_regno);
            $("div.family").show();
        }
        else {
            $('input#user-regno').prop('readonly',false);
            $('input#user-regno').val(init_regno);
              
        }

     });

    //
    // searched ticket - auto click next
     $(document).on('click','.search-customer-completed-ticket-btn',function(){
        var btn = '.search-customer-completed-ticket-btn';
        var ticket_no = $('#ticket_by_ticket').val();
         if(ticket_no===""){
             showpop('Please Enter Ticket No','error');
         }
         else {
           // search and json data for continuation
            $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/fetch-customer-completed-ticket-info',
            data: { ticket_no:ticket_no } ,
            beforeSend:function(){ startLoader(btn);  $(document).find('span.error-text').text(''); $('.found-payment').html('');   },
            success:function(resp, textStatus, http){  // alert(resp);
                stopLoader(btn); stopLoader();
               if(resp.type==="error"){
                  $.each(resp.errors,function(prefix,val){
                       $('span.admin_'+prefix+'_error').text(val[0]);
                  });
              }
              if(resp.type ==="success"){
                  $('.found-ticket-ticket').html(resp.view);
                   // showPaymode('cash', 'cashmode');
                    //showPaymode('pos', 'posmode');
                    ///showPaymode('transfer', 'transfermode');
                    //
              }
            },
            error:function(jhx,textStatus,errorThrown){ stopLoader(btn); stopLoader();
                checkStatus(jhx.status); }
            });
         }
        });
        //

    //
    // start with new customer
     $(document).on('click','.new-customer-ticket-btn',function(){
         $('ul.tabs-animated-shadow a')[1].click();
         $('.ticket-customer-profile-btn').removeClass('btn-primary').addClass('btn-success');
         $('.ticket-customer-profile-btn').text('Create New Customer');
         $('input:text.form-control,input#user-id').val('');
         $('input#male-sex').prop('checked',false);
         $('input#female-sex').prop('checked',false);
    });

    // searched customer - auto click next
     $(document).on('click','.customer-search-btn',function(){
        var btn = '.customer-search-btn';
        var regno = $('#customer_searcher').data('regno');
        var custom_id = $('#customer_searcher').attr('custom_id'); 
        
         if(regno===undefined){
             showpop('No Customer Found','error');
         }
         else {
           // search and json data for continuation
            $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/fetch-customer-info',
            data: { regno:regno, custom_id:custom_id } ,
            beforeSend:function(){ startLoader(btn); },
            success:function(resp, textStatus, http){  // alert(resp);
                stopLoader(btn); stopLoader();
                $.each(resp,function(prefix,val){
                    $('input#user-'+prefix).val(val);
                  });
                $('div.customer').html('Create Ticket For : #'+resp.regno+',  '+resp.surname+' '+resp.firstname+' ');
                $('ul.tabs-animated-shadow a')[1].click();

            },
            error:function(jhx,textStatus,errorThrown){ stopLoader(btn); stopLoader();
                checkStatus(jhx.status); }
            });
         }
        });
    
    // searched customer - to include for family
     $(document).on('click','.add-family-dependant-start-btn',function(){ // customer-search-btn
        var btn = '.add-family-dependant-start-btn';
        var regno = $('#customer_searcher').data('regno');
        var custom_id = $('#customer_searcher').attr('custom_id'); 
        var family_id = $('#family_id').val(); 
        // alert(custom_id); exit; 
         if(custom_id===""){
             showpop('No Customer Has Been Selected','error');
         }
         else {
           // search and json data for continuation
            $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/fetch-customer-family-info',
            data: { regno:regno, custom_id:custom_id,family_id:family_id} ,
            beforeSend:function(){ startLoader(btn); },
            success:function(resp, textStatus, http){  // alert(resp);
                stopLoader(btn); stopLoader();
                $('.output-search').html(resp.view);
            },
            error:function(jhx,textStatus,errorThrown){ stopLoader(btn); stopLoader();
                checkStatus(jhx.status); }
            });
         }
        });       
        
     // searched ticket - auto click next
     $(document).on('click','.customer-search-payment-btn',function(){
        var btn = '.customer-search-payment-btn';
        var ticket_no = $('#customer_searcher_payment').val();
         if(ticket_no===""){
             showpop('Please Enter Ticket No','error');
         }
         else {
           // search and json data for continuation
            $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/fetch-customer-payment-info',
            data: { ticketno:ticket_no } ,
            beforeSend:function(){ startLoader(btn);  $(document).find('span.error-text').text(''); $('.found-payment').html('');   },
            success:function(resp, textStatus, http){  // alert(resp);
                stopLoader(btn); stopLoader();
               if(resp.type==="error"){
                  $.each(resp.errors,function(prefix,val){
                       $('span.admin_'+prefix+'_error').text(val[0]);
                  });
              }
              if(resp.type ==="success"){
                  $('.found-payment').html(resp.view);
                    showPaymode('cash', 'cashmode');
                    showPaymode('pos', 'posmode');
                    showPaymode('transfer', 'transfermode');
                 }
             },
            error:function(jhx,textStatus,errorThrown){ stopLoader(btn); stopLoader();
                checkStatus(jhx.status); }
            });
         }
        });
        //

    // specimen search
    $(document).on('keyup','#specimen_searcher',function(){
      var btn = '.specimen-search-btn';
      var vals = $(this).val();
      if(vals.length > 2){
          var forms = $('form#ticket_specimen_search').serialize();
          $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/search-specimen-info',
            data: forms ,
            beforeSend:function(){ startLoader(btn);  $('#specimen_searcher').removeData('bill_id'); },
            success:function(resp, textStatus, http){  // alert(resp);
                stopLoader(btn); stopLoader();
                $('.found-specimen').html(resp);
                $('.final-specimen-form').html("");
            },
            error:function(jhx,textStatus,errorThrown){ stopLoader(btn); stopLoader();
                checkStatus(jhx.status); }
            });
        } else {
            $('.found-specimen').html("");
        }

     });
     
        // specimen search
    $(document).on('keyup','#specimen_searcher_2',function(){
      var btn = '.specimen-search-btn-2'; // during processing
      var vals = $(this).val();
      if(vals.length > 2){
          var forms = $('form#ticket_specimen_search_2').serialize();
          $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/search-specimen-info-2',
            data: forms ,
            beforeSend:function(){ startLoader(btn);  $('#specimen_searcher').removeData('bill_id'); },
            success:function(resp, textStatus, http){  // alert(resp);
                stopLoader(btn); stopLoader();
                $('.found-specimen').html(resp);
                $('.final-specimen-form').html("");
            },
            error:function(jhx,textStatus,errorThrown){ stopLoader(btn); stopLoader();
                checkStatus(jhx.status); }
            });
        } else {
            $('.found-specimen').html("");
        }

     });

    // searched specimen - auto click next
     $(document).on('click','.specimen-search-btn',function(){
        var btn = '.specimen-search-btn';
        var bill_id = $('#specimen_searcher').data('bill_id');
        var user_id = $('#user-id').val();
         if(bill_id===undefined){
             showpop('No Specimen / Bill Found','error');
         }
         else if(user_id===""){
              showpop('You have not selected any customer','error');
         }
         else {
           // search and json data for continuation
            $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/fetch-specimen-info',
            data: { bill_id:bill_id, user_id:user_id } ,
            beforeSend:function(){ startLoader(btn); },
            success:function(resp, textStatus, http){  // alert(resp);
                stopLoader(btn); stopLoader();
                $('.final-specimen-form').html(resp.view);
            },
            error:function(jhx,textStatus,errorThrown){ stopLoader(btn); stopLoader();
                checkStatus(jhx.status); }
            });
         }
        });
       
    // searched specimen - auto click next
     $(document).on('click','.specimen-search-btn-2',function(){
        var btn = '.specimen-search-btn-2';
        var bill_id = $('#specimen_searcher_2').data('bill_id');
        var user_id = $('#user_id').val();
        var ticket_no = $('#ticket_no').val();
         if(bill_id===undefined){
             showpop('No Specimen / Bill Found','error');
         }
         else if(user_id===""){
              showpop('No Customer Found','error');
         }
         else {
           // search and json data for continuation
            $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/fetch-specimen-info-2',
            data: { bill_id:bill_id, user_id:user_id,ticket_no:ticket_no },
            beforeSend:function(){ startLoader(btn); },
            success:function(resp, textStatus, http){  // alert(resp);
                stopLoader(btn); stopLoader();
                $('.final-specimen-form').html(resp.view);
            },
            error:function(jhx,textStatus,errorThrown){ stopLoader(btn); stopLoader();
                checkStatus(jhx.status); }
            });
         }
        });
 
    //
     $(document).on('click','.add-specimen-btn',function(){
        var btn = '.add-specimen-btn';
        var bill_id = $('#bill-id').val();
        var user_id = $('#user-id').val();
        var specimen = $('#specimen_sample').val();
        var price = $('#price').val();
            // search and json data for continuation
            $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/add-ticket-bill',
            data:  { user_id:user_id , bill_id:bill_id, specimen:specimen, price:price },
            beforeSend:function(){ startLoader(btn); },
            success:function(resp, textStatus, http){  // alert(resp);
                stopLoader(btn); stopLoader();
                if(resp.type=="success"){
                    showpop(resp.message);
                    $('.specimen-search-btn').trigger('click');
                }
            },
            error:function(jhx,textStatus,errorThrown){ stopLoader(btn); stopLoader();
                checkStatus(jhx.status); }
            });
         });

    $(document).on('click','.add-specimen-btn-2',function(){
        var btn = '.add-specimen-btn-2';
        var bill_id = $('#bill-id').val();
        var user_id = $('#user-id').val();
        var ticket_no= $('#ticket_no').val();        
        var specimen = $('#specimen_sample').val();
        var price = $('#price').val(); 
        
      // if($('#final_price').length > 0){
            var final_price = $('#final_price').val();
            var qty_buy = $('#qty_buy').val();
            var max_qty = $('#final_price').attr('max');                   
      // }        
            // search and json data for continuation
            $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/add-ticket-bill-2',
            data:  { user_id:user_id , bill_id:bill_id, specimen:specimen, price:price,ticket_no:ticket_no,qty_buy:qty_buy, final_price:final_price },
            beforeSend:function(){ startLoader(btn); },
            success:function(resp, textStatus, http){  // alert(resp);
                stopLoader(btn); stopLoader();
               if(resp.type=="success"){               
                    $('.specimen-search-btn-2').trigger('click');
                }
               showpop(resp.message,resp.type);
            },
            error:function(jhx,textStatus,errorThrown){ stopLoader(btn); stopLoader();
                checkStatus(jhx.status); }
            });
         });

      //
      $(document).on('click','.process-investigation-report-btn',function(){
        // var btn = '.add-specimen-btn';
        var bill_id = $(this).attr('bill_id');
        var ticket_no = $('#ticket_no').val();
        // alert(ticket_no +' - '+ bill_id);
         if(bill_id==="")  {
             showpop('Please select a specimen','error');
         }
         else{
             $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/preload-bill-result-template',
            data: {bill_id:bill_id, ticket_no:ticket_no},
            beforeSend:function(){ startLoader(); },
            success:function(resp, textStatus, http){  // alert(resp);
              stopLoader();
                $('.result-body').html(resp.view);
                setTimeout(function(){ reload_text_tinymce(); highlight_check_rows();   },500);
            },
            error:function(jhx,textStatus,errorThrown){ stopLoader();
                checkStatus(jhx.status); }
            });
         }
         });

    //
     $(document).on('click','.add-more-investigation-btn',function(){
        var loader = ".ajaxLoader";
        var ticket_no = $('#ticket_no').val();
        var user_id = $('#user-id').val();
          
           $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/add-more-investigation',
            data: {ticket_no:ticket_no,user_id:user_id},  // $('form#result_preloader').serialize(),
            beforeSend:function(){ startLoader(loader,true); },
            success:function(resp, textStatus, http){  // alert(resp);
              stopLoader(loader,true);;
                $('.result-body').html(resp.view); // 
              //  setTimeout(function(){ reload_text_tinymce(); highlight_check_rows();   },500);
            },
            error:function(jhx,textStatus,errorThrown){ stopLoader(loader,true);;
                checkStatus(jhx.status); }
            });
         
         });

    // submiting report for each template
    //
     $(document).on('click','button.text-report-submit-btn',function(){
        var btn = '.text-report-submit-btn';
        tinymce.triggerSave(); report2 = ""; 
        if($('#result_text_2').length >0) { report2 = $('#result_text_2').val(); }
        var ticket_no = $('#ticket_no').val(); var bill_id = $('#bill_id').val();
        var report = $('#result_text').val();  var comment = $('#text_comment').val();
            $.ajax({
            headers:{  'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') },
            type:'post',
            url:'/admin/submit-specimen-report',
            data: { report_type:$('#report_type').val(), ticket_no:ticket_no,bill_id:bill_id, report:report,comment:comment, report2:report2},
            beforeSend:function(){ startLoader(btn); },
            success:function(resp, textStatus, http){ // alert(resp);
              stopLoader(btn);
              showpop(resp.message,resp.type);
              if(resp.type=="success"){                  
                    setTimeout(function(){location.reload();},2000);
                }               
            },
            error:function(jhx,textStatus,errorThrown){ stopLoader();
                checkStatus(jhx.status); }
            });
         });



 $(".confirmDelete").click(function(){
    var module = $(this).attr('module');
    var moduleid = $(this).attr('moduleid');
    var title = $(this).attr('title');
  Swal.fire({
            title: 'Are you sure you want to delete this '+title+' '+module+' ?',
            text: "You won't be able to revert this!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire(
                'Deleted!',
                'Request Successful !!!',
                'success',
              )
              // window.setTimeout(function(){
                  window.location = "/admin/delete-"+module+"/"+moduleid;
              // }, 1500);

            }
          })
});

 $(".confirmBillDelete").click(function(){
    var bill_id = $(this).attr('bill_id');
    var ticket = $(this).attr('data-text');
    var title = $(this).attr('title');
    Swal.fire({
            title: 'Are you sure you want to delete this '+title+' from the Investigations'+' ?',
            text: "You won't be able to revert this!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire(
                'Deleted!',
                'Request Successful !!!',
                'success',
              )             
            window.location = "/admin/delete-ticket-bill"+"/"+ticket+"/"+bill_id;
            }
        })
});

    // Product Attrbutes Add/Remove
        var maxField = 5; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = '<div class="form-row"><div class="col-md-3 mb-3">\n\
            <input type="text" value="" class="form-control" name="size[]" placeholder="Size" require="" /> <div class="invalid-feedback">enter the size </div> </div> <div class="col-md-3 mb-3">\n\
            <input type="text" value="" class="form-control" name="sku[]" placeholder="SKU" require=""/>  <div class="invalid-feedback">enter the sku </div> </div> <div class="col-md-3 mb-3"> \n\
            <input type="text" value="" class="form-control" name="price[]" placeholder="Price" require=""/>  <div class="invalid-feedback">enter the price </div> </div> <div class="col-md-2 mb-3">\n\
            <input type="text" value="" class="form-control" name="stock[]" placeholder="Stock" require=""/> <div class="invalid-feedback">enter the stock qty </div> </div> <div class="col-mb-1 mb-3"><a href="javascript:void(0);" class="remove_button text-danger  "><i class="pe-7s-close-circle pe-2x"/></i></a></div>\n\
            </div>';
            //New input field html
        var x = 1; //Initial field counter is 1

        //Once add button is clicked
        $(addButton).click(function(){
            //Check maximum number of input fields
            if(x < maxField){
                x++; //Increment field counter
                $(wrapper).append(fieldHTML); //Add field html
            }
        });

    //Once remove button is clicked
    $(wrapper).on('click', '.remove_button', function(e){
        e.preventDefault();
        $(this).closest('div.form-row').remove();
        x--; //Decrement field counter
    });


    // Product Category Selection filters
    $('#category_id').on('change',function(){
       var category_id = $(this).val();
        $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/category_filters',
            data:{category_id:category_id},
            success:function(resp, textStatus, http){
                 $('.loadFilters').html(resp.view);
            },
            error:function(jhx,textStatus,errorThrown){
                checkStatus(jhx.status); }
        });

    });


    //---------------------------------------------

    $('.dataTable').dataTable();

    initDatePicker();
    
    
});

 function initDatePicker(){
    if($(".datepicker").length >0){
    flatpickr('.datepicker', {weekNumbers: true, altInput: true,
    altFormat: "F j, Y",
    dateFormat: "Y-m-d H:i",
    // enableTime: true,
    // time_24hr: true
     });
     }
     
    if($(".datetimepicker").length >0){
     flatpickr('.datetimepicker', {weekNumbers: true, altInput: true,
        altFormat: "F j, Y H:i",
        dateFormat: "Y-m-d H:i",
         enableTime: true,
         time_24hr: false
         });
     }
      if($(".timepicker").length >0){
       flatpickr('.timepicker', {weekNumbers: true, altInput: true,
        enableTime: true,     // enable time selection
        noCalendar: true,     // remove calendar, time picker only
        dateFormat: "H:i",    // 24-hour format like 14:30
        time_24hr: false      // use 12-hour clock (AM/PM)
         });
      }
     if($(".calendar").length >0){ 
      flatpickr(".calendar", {inline:true, dateFormat: "Y-m-d H:i"});
      }
 }


    function save_selected_customer(regno='',custom_id=''){
        $('#customer_searcher').val(regno);
        $('#customer_searcher').attr('custom_id',custom_id);
        $('.found-customer').html("");
        if(regno !==""){
            $('#customer_searcher').data('regno',regno);
            $('.customer-search-btn'). click();
        }
    }
    
    
    function load_student_state_of_origin(){
        var country_id = $('#country').val(); var stud_id = $('#stud_id').val();
        load_country_states(country_id,stud_id); 
       // setTimeout( load_student_cities(),2000);
    }
    
    
    function load_student_cities(){
        var state_id = $('#state').val(); var stud_id = $('#stud_id').val();
        load_state_cities(state_id,stud_id); 
    }
    
    
    function load_country_states(country_id,stud_id = ''){
       $.ajax({
        headers:{
          'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')  
        },
        type:'post',
        url:'/admin/load-country-states',
        data: {country_id:country_id, stud_id:stud_id} ,
        beforeSend:function(){ startLoader(); },
        success:function(resp){  
            $('.state_loader').html(resp.view);
            stopLoader();  setTimeout( function(){$('#state').trigger('change');},500); 
        },
        error:function(jhx,textStatus,errorThrown){ stopLoader();
           checkStatus(jhx.status); 
       }
    }); 
    }
    
    function load_state_cities(state_id, stud_id=''){
       var country_id = $('#country').val();
       $.ajax({
        headers:{
          'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')  
        },
        type:'post',
        url:'/admin/load-state-cities',
        data: {state_id:state_id, stud_id:stud_id,country_id:country_id} ,
        beforeSend:function(){ startLoader(); },
        success:function(resp){  
            $('.city_loader').html(resp.view);
            stopLoader();           
        },
        error:function(jhx,textStatus,errorThrown){ stopLoader();
           checkStatus(jhx.status); 
       }
    }); 
    }

     function save_selected_ticket(ticket_no=''){
        $('#customer_searcher_payment').val(ticket_no);
        $('#ticket_by_ticket').val(ticket_no);
        $('.found-ticket').html("");
        $('.found-ticket-ticket').html("");
        if(ticket_no !==""){
            //$('#customer_searcher').data('regno',regno);
            $('.customer-search-payment-btn').click();
            $('.search-customer-completed-ticket-btn').click();
        }
    }


     function save_selected_specimen(bill_id,name){
        $('#specimen_searcher').val(name);
        $('.found-specimen').html("");
        if(bill_id !=""){
            $('#specimen_searcher').data('bill_id',bill_id);
            $('.specimen-search-btn').click();
        }
    }
     function save_selected_specimen_2(bill_id,name){
        $('#specimen_searcher_2').val(name);
        $('.found-specimen').html("");
        if(bill_id !=""){
            $('#specimen_searcher_2').data('bill_id',bill_id);
            $('.specimen-search-btn-2').click();
        }
    }

    function finalize_bill_ticket(){
         var user_id = $('#user-id').val();
         $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/fetch-ticket-summary',
            data: { user_id:user_id } ,
            success:function(resp, textStatus, http){  // alert(resp);
                $('ul.tabs-animated-shadow a')[2].click();
                $('div.ticket-summary').html(resp.view);
                initDatePicker();
            },
            error:function(jhx,textStatus,errorThrown){ stopLoader(btn); stopLoader();
                checkStatus(jhx.status); }
            });
    }
    
    
    function finalize_bill_ticket_2(){
         var user_id = $('#user-id').val();
         var ticket_no = $('#ticket_no').val();
         $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/finalize-ticket-summary-2',
            data: { user_id:user_id,ticket_no:ticket_no } ,
            success:function(resp, textStatus, http){  // alert(resp);
                $('ul.tabs-animated-shadow a')[2].click();
                $('div.ticket-summary').html(resp.view);
                initDatePicker();
            },
            error:function(jhx,textStatus,errorThrown){ stopLoader(btn); stopLoader();
                checkStatus(jhx.status); }
            });
    }


    function complete_customer_ticket(){
        forms = $('form#complete-customer-ticket').serialize();
        var btn = '.complete-customer-ticket-btn';
        if(confirm('Do you want to submit the form ?')){
         $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/submit-customer-ticket',
            beforeSend:function(){ startLoader(btn); },
            data: forms  ,
            success:function(resp, textStatus, http){ // alert(resp);
               stopLoader(btn);
               if(resp.type==="success"){
                   showpop(resp.message);
                   setTimeout(function(){ window.location.href = resp.url; },1000);
               }
            },
            error:function(jhx,textStatus,errorThrown){ stopLoader(btn); stopLoader();
                checkStatus(jhx.status); }
            });
        }
    }

    function show_pending_tickets(){
        var filteration = $("#filteration").val();
        $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',data:{filteration:filteration},
            url:'/admin/load-pending-tickets',
            beforeSend:function(){ startLoader(); },
            success:function(resp, textStatus, http){ // alert(resp);
               stopLoader();
               $('.pending-tickets').html(resp.view);
            },
            error:function(jhx,textStatus,errorThrown){ stopLoader();
                checkStatus(jhx.status); }
            });
    }

    function show_completed_tickets(){
        $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'get',
            url:'/admin/load-completed-tickets',
            beforeSend:function(){ startLoader(); },
            success:function(resp, textStatus, http){ // alert(resp);
               stopLoader();
               $('.completed-tickets').html(resp.view);
            },
            error:function(jhx,textStatus,errorThrown){ stopLoader();
                checkStatus(jhx.status); }
            });
    }

function save_param_specimen_result() {
   var temps = []; temp_id = [];  scores = [];  comments = [];
   var btn = $('.param-report-submit-btn');
   var ticket_no = $('#ticket_no').val(); var bill_id = $('#bill_id').val();

   // test_comment = $('#test_comment');
   // date_perform = $('#date_perform');
   // var custom_bill_info = $('#save_specimen_result_btn').attr('data-text'); // ticket_no |  bill_type_id
   proceed = true;

   $("input:checkbox.checkboxes:checked").each(function () {
      temps.push($(this).val());
   });
   if (temps.length == 0) {
      showpop('Please ensure you select the result type to save', 'error');
      proceed = false;
      return false;
   }   else {
      $("input:checkbox.checkboxes:checked").each(function () {
         var txt = $(this).closest('tr').find('input[type=text].result');
         var comm = $(this).closest('tr').find('input[type=text].comment');
         if (txt.val() == "") {
            txt.removeClass('border-success').addClass('border-danger'); //textbox is empty
            proceed = false;   txt.focus();
         } else {
            /****** save all results ***********/
            temp_id.push($(this).val()); scores.push(txt.val());  comments.push(comm.val())
            /*******************************/
            txt.removeClass('border-danger').addClass('border-success');
         }
      }); // end forEach
   }
  // continue to save
    if(proceed === true) {
        $.ajax({
        headers:{  'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') },
        type:'post',
        url:'/admin/submit-specimen-report',
        data: { report_type:'param', ticket_no:ticket_no,bill_id:bill_id,
            temp_id:temp_id, scores:scores,comments:comments },
        beforeSend:function(){ startLoader(); },
        success:function(resp, textStatus, http){ // alert(textStatus+ ' and '+http.status);
          stopLoader();          
            showpop(resp.message,resp.type);          
            if(resp.type=="success"){                
               setTimeout(function(){location.reload();},2000);
            }            
        },
        error:function(jhx,textStatus,errorThrown){ stopLoader();
            checkStatus(jhx.status); }
        });

    } // end proced

} // end function

   function save_spec_perform_date(id,elemdate,btn){
       var spec = id; var date = elemdate.val();
       if(date ===""){
           showpop('Please Select date performed','error');
       }
       else {
           // submit date
           $.ajax({
        headers:{  'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') },
        type:'post',
        url:'/admin/save-specimen-perform-date',
        data: { spec:spec, date:date },
        beforeSend:function(){ startLoader(btn); },
        success:function(resp, textStatus, http){ // alert(textStatus+ ' and '+http.status);
          stopLoader(btn);
            if(resp.type=="success"){
                showpop(resp.message);
                //$('.specimen-search-btn').trigger('click');
            }
        },
        error:function(jhx,textStatus,errorThrown){ stopLoader(btn);
            checkStatus(jhx.status); }
        });

       }
   }
   /*******************/
   // comment for specimen by pathologist
    function save_spec_path_comment(id,elem,btn){
       var spec = id; var comment = elem.val();
       if(comment ===""){
           showpop('Please Enter some comment','error');
       }
       else {
           // submit date
           $.ajax({
        headers:{  'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') },
        type:'post',
        url:'/admin/save-pathologist-comment',
        data: { spec:spec, comment:comment },
        beforeSend:function(){ startLoader(btn); },
        success:function(resp, textStatus, http){ // alert(textStatus+ ' and '+http.status);
          stopLoader(btn);
            if(resp.type=="success"){
                showpop(resp.message);
                //$('.specimen-search-btn').trigger('click');
            }
        },
        error:function(jhx,textStatus,errorThrown){ stopLoader(btn);
            checkStatus(jhx.status); }
        });

       }
   }

   function  finalize_test_process(ticket_no,data_text){
    // alert(ticket_no+' --- and --- '+data_text);
    var processes = data_text.split('|'); // yes or no
    var date = $('#date-fin').val();
    var btn = '#finalize_test_process';
    if($.inArray('no',processes) !==-1) showpop('Cannot Finalize Now Because All the reports has not been computed','error');
    else {
            // finalize the report
            /*********************/
            $.ajax({
            headers:{  'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') },
            type:'post',
            url:'/admin/finalize-test-process',
            data: { ticket_no:ticket_no,date:date },
            beforeSend:function(){ startLoader(btn); },
            success:function(resp, textStatus, http){ // alert(textStatus+ ' and '+http.status);
              stopLoader(btn);
                if(resp.type==="success"){
                    showpop(resp.message);
                    window.location.href= resp.url;
                }
            },
            error:function(jhx,textStatus,errorThrown){ stopLoader(btn);
                checkStatus(jhx.status); }
            });
           /*********************/

            }
	}

   //
   /************** functions ***************/
	function print_results(ticket_no){
            specimens = [];
            $("input:checkbox.specimen_results_check:checked").each(function() {
                specimens.push($(this).val());
            });
            // alert(specimens);
            if(specimens.length==0){
                showpop('No Completed Result Was Selected','error'); }
             else {
                    $(this).target = "_blank";
                    /// var url = "tick_result_part_print.php?r_val="+ ticket_no+'&spc='+specimens;
                    var url = "print-ticket-result/"+ ticket_no+'/'+specimens;
                    //var url = "tick_result_part_print.php?r_val="+ ticket_no+'&spc='+specimens;
                    // window.open($(this).prop('href'));
                   $("input:checkbox.specimen_results_check").prop('checked',false);
                    window.open(url);// part_prints
           }
	}
	/************** functions ***************/
	function download_results(ticket_no,type='pdf'){
		specimens = [];
		$("input:checkbox.specimen_results_check:checked").each(function() {
			specimens.push($(this).val());
		});
		if(specimens.length==0){ showpop('No Completed Result Was Selected','error'); }
		 else {
                    $(this).target = "_blank";
                        /// var url = "tick_result_part_print.php?r_val="+ ticket_no+'&spc='+specimens;
                         var url = "download-ticket-result/"+ ticket_no+'/'+specimens;
                        // window.open($(this).prop('href'));
                        $("input:checkbox.specimen_results_check").prop('checked',false);
                        window.open(url);// part_prints

		 }
	}
	/************** functions ***************/


 
      function submit_family_dependent(){
           var family_id = $('input#family_id').val();
           var my_id = $('input#my_id').val();
           var btn = '.submit-family-dependent-btn';
           // submit 
            $.ajax({
            headers:{  'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') },
            type:'post',
            url:'/admin/add-new-family-member',
            data: { family_id:family_id,my_id:my_id },
            beforeSend:function(){ startLoader(btn); },
            success:function(resp, textStatus, http){ // alert(textStatus+ ' and '+http.status);
              stopLoader(btn);
                if(resp.type==="success"){                   
                    window.location.reload();
                }
                 showpop(resp.message, resp.type);
            },
            error:function(jhx,textStatus,errorThrown){ stopLoader(btn);
                checkStatus(jhx.status); }
            });
           
        }

  function showpop(messages,  types='success'){
        const notyf = new Notyf({
        position: {
            x: 'center',
            y: 'top',
        } ,
        duration:5000,  dismissible:false, icon: true
        });

        notyf.open({
          type: types,
          message: '<span class="font-weight-700">'+messages+'</span>'
        });
    }

    function loadStaffRoles(){
       var admin_id = $('#admin-staff').val();
       // console.log(admin_id);
       if(admin_id!=="") load_admin_roles(admin_id);
       else {
            $('#role_list').html("");
       }
    }

     function startLoader(elem='',addBtn=false){
        if(elem===""){
          elem = '.ajaxLoader';  // l.start(); 
        }
       if($(elem).length >0){
             var l = Ladda.create(document.querySelector(elem));  
              if(addBtn===true){ $(elem).addClass(' btn p-4 '); }
              l.start(); 
        } 
    }
    
    function stopLoader(elem='',addBtn=false){
        if(elem===""){
          elem = '.ajaxLoader';  // l.stop(); 
        }
       if($(elem).length >0){
             var l = Ladda.create(document.querySelector(elem));  
              if(addBtn===true){ $(elem).removeClass(' btn p-4 '); }
              l.stop(); 
        } 
    }

    function load_admin_roles(admin_id=''){
        // startLoader();
        if(admin_id !==""){
        $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/get-admin-roles',
            beforeSend:function(){ startLoader(); },
            data:{admin_id:admin_id},
            success:function(resp, textStatus, http){stopLoader();
               $('#role_list').html(resp.view);
            },
            error:function(jhx,textStatus,errorThrown){ stopLoader();
                checkStatus(jhx.status); }
        });
        }
    }

    function handleRoleAssignment(){
        var admin_id = $('#admin-staff').val();
        var roles = $('input:checkbox.role-list:checked').val();
        if(admin_id===undefined || roles===undefined ){
            showpop('Ensure you select the user and the equivalent role qualified for him/her', 'error');
        }
        else {
            $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/set-admin-roles',
            beforeSend:function(){ startLoader('.assign-staff-role-btn'); },
            data: $('#assignRoleForm').serialize(),
            success:function(resp, textStatus, http){stopLoader('.assign-staff-role-btn');
               showpop(resp.message,resp.status);
            },
            error:function(jhx,textStatus,errorThrown){ stopLoader();
                checkStatus(jhx.status); }
            });
        }
    }

    function count_selected_courses(){
      var tot = $('input.level-subject-custom:checked').length;
       $('span.tot-subject').text(tot);
       console.log(tot);
    }

    function reload_unit_tinymce(){
        // tinymce.EditorManager.editors = [];
        // console.log(tinymce.EditorManager.editors );
       if(tinymce.execCommand('mceRemoveEditor', false, 'unit')) {
            tinymce.init({
            height:150,
            selector :"textarea#unit", menubar: true, plugins:[' charmap' ], toolbar:"undo redo | insert | bold italic underline "
            });
        }
    }

    function reload_text_tinymce_old(elem='result_text',height=600){
        
        tinymce.init({
            selector: 'textarea#'+elem,
            height: height,
            menubar: false,
            plugins: [
              'advlist autolink lists link image charmap print preview anchor',
              'searchreplace visualblocks code fullscreen',
              'insertdatetime media table help wordcount'
            ],
            toolbar: 'undo redo | formatselect | ' +
                     'bold italic underline backcolor | alignleft aligncenter ' +
                     'alignright alignjustify | bullist numlist outdent indent | ' +
                     'removeformat | table | help',

            // Enable tables
            table_toolbar: "tableprops tabledelete | tableinsertrowbefore tableinsertrowafter tabledeleterow | " +
                           "tableinsertcolbefore tableinsertcolafter tabledeletecol | cellprops celldelete",

            // Paste into dark mode friendly
            content_style: `
              body { font-family:Helvetica,Arial,sans-serif; font-size:14px; }
              .mce-content-body { background-color: #ffffff; color: #333333; }
            `,

            // Optional: Dark mode toggle
            skin: window.matchMedia('(prefers-color-scheme: dark)').matches ? 'oxide-dark' : 'oxide',
            content_css: window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'default',

            // Make dropdowns always show above containers
            fixed_toolbar_container: '#tiny-editor-toolbar-wrapper', // optional wrapper
            table_default_styles: {
              width: '100%',
              borderCollapse: 'collapse',
              border: '1px solid #ccc'
            }
          });
    }
    
    
    function reload_text_tinymce(elem='result_text',height=600){
    //  tinymce.EditorManager.editors = [];
        if(tinymce.execCommand('mceRemoveEditor', false, elem)) {
            tinymce.init({
              selector: 'textarea#'+elem,
              height:height,
              plugins: [
                    'advlist autolink lists link image charmap print preview hr anchor pagebreak',
                    'searchreplace wordcount visualblocks visualchars code fullscreen',
                    'insertdatetime media nonbreaking save table directionality',
                    'emoticons template paste textpattern imagetools codesample toc help'
              ],
              toolbar1: 'undo redo | insert | styleselect | bold italic underline | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
              // toolbar2: 'print preview media | forecolor backcolor emoticons | codesample help',
            });
        }
    }
    
    function add_tinymce(elem='complaint_forms'){
        
        if(window.editor){
            window.editor.destroy();
        }

        ClassicEditor
        .create(document.querySelector('#'+elem), {
            toolbar: {
                items: [
                    'undo', 'redo', '|',
                    'heading', 'bold', 'italic', 'underline', '|',
                    'link', 'blockQuote', '|',
                    'insertTable', 'tableColumn', 'tableRow', 'mergeTableCells', '|',
                    'sourceEditing'
                ]
            },
            heading: {
                options: [
                    { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph' },
                    { model: 'heading1', view: 'h1', title: 'Heading 1', class: 'ck-heading_heading1' },
                    { model: 'heading2', view: 'h2', title: 'Heading 2', class: 'ck-heading_heading2' },
                    { model: 'heading3', view: 'h3', title: 'Heading 3', class: 'ck-heading_heading3' }
                ]
            },
            table: {
                contentToolbar: [
                    'tableColumn',
                    'tableRow',
                    'mergeTableCells'
                ]
            },
            htmlSupport: {
                allow: [
                    {
                        name: /.*/,       // allow all tags
                        attributes: true, // allow all attributes
                        classes: true,    // allow all classes
                        styles: true      // allow inline styles
                    }
                ]
            }
        })
        .then(editor => {
            window.editor = editor;
        })
        .catch(err => {
            console.error(err.stack);
        });
    
    }

        
    function confirmDelete(module,moduleid,title){
          Swal.fire({
            title: 'Are you sure you want to delete this '+title+' '+module+' ?',
            text: "You won't be able to revert this!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
          }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                  'Deleted!',
                  'Request Successful !!!',
                  'success',
                )
                $.ajax({
                    headers:{'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')  },
                    type:'get', url:"/admin/delete-"+module+"/"+moduleid,
                });

                $('.specimen-search-btn').trigger('click');

              }
             })
       // });
}

function highlight_check_rows(){
    $('tr .checkboxes').each(function() {
        if(this.checked) {
            $(this).closest('tr').removeClass('table-default border-dark');
            $(this).closest('tr').addClass('table-light border-dark');
        }
        else {
            $(this).closest('tr').removeClass('table-light border-dark');
            $(this).closest('tr').addClass('table-default border-dark');
        }
    });
}

function checkStatus(code){
    if(code===419){
        swal.fire('Your Active Session Has Expired ','You have to login again','error').then((result) => {
           window.location = "/portal/login";
         });
    }
}

function showPaymode(cbox, divlem){
    var money = $('input:checkbox#'+cbox);
    if(money.prop('checked')) {  $('#'+divlem).show(); }
     else {  $('#'+divlem).hide();
         // remove from calculatd amount
         recalc_amount(cbox,0); // cash / pos/ transfer- set to 0
         $('input:text.'+cbox).val(0);
     }
}

function submitPayment(forms){
    var paymodes = $('input:checkbox.paymode:checked').length;
    var btn = '.exec-payment-btn';
    if(paymodes===0){
        showpop("Please select payment method",'error');
    }
    else{
       $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/submit-ticket-payment',
            beforeSend:function(){ startLoader(btn); },
            data: forms,
            success:function(resp, textStatus, http){stopLoader(btn);
              if(resp.type==="success"){
                  showpop(resp.message,resp.status);
                  recalc_amount('cash',0); // cash / pos/ transfer- set to 0
                  recalc_amount('pos',0);
                  recalc_amount('transfer',0);
                  $('.customer-search-payment-btn').trigger('click');
              }

            },
            error:function(jhx,textStatus,errorThrown){ stopLoader(btn);
                console.log(""+textStatus+' - '+errorThrown);
                checkStatus(jhx.status);
            }
            });
    }
}

    var sums = 0;
    var cash_amount = 0;
    var pos_amount = 0;
    var transfer_amount = 0;

 function recalc_amount(paymode='',amount=0){
     var paymodes = [];
     $("input:checkbox.paymode:checked").each(function () {
      paymodes.push($(this).val());
      });
      console.log(paymodes);
      if(paymode==='cash'){ cash_amount = parseFloat(amount); }
      if(paymode==='pos'){ pos_amount = parseFloat(amount); }
      if(paymode==='transfer'){ transfer_amount = parseFloat(amount); }
      // //
      var sums = cash_amount + pos_amount + transfer_amount;
      $('span.total-amount').text(numberSeperator(sums,true));
 }

 function search_payment_by_date(forms){
     var btn = '.date-search-payment-btn';
     var dfrom = $('#pay_sum_from').val();
     var dto = $('#pay_sum_to').val();

     if(dfrom ==="" || dto ===""){
         showpop('Please select complete date','error');
     }
     else {
         // submit
         $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/fetch-ticket-payment-by-dates',
            beforeSend:function(){ startLoader(btn); },
            data: forms,
            success:function(resp, textStatus, http){stopLoader(btn);
              if(resp.type==="success"){
                 //  showpop(resp.message,resp.status);
                  $('.found-date-payment').html(resp.view);
              }
            },
            error:function(jhx,textStatus,errorThrown){ stopLoader(btn);
                // console.log(""+textStatus+' - '+errorThrown);
                checkStatus(jhx.status);
            }
            });
     }
 }

function search_payment_by_ticket(forms){
     var btn = '.ticket-search-payment-btn';
     var dfrom = $('#ticket_from').val();
     var dto = $('#ticket_to').val();

     if(dfrom ==="" || dto ===""){
         showpop('Please select complete date','error');
     }
     else {
         // submit
         $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/fetch-ticket-payment-by-tickets',
            beforeSend:function(){ startLoader(btn); },
            data: forms,
            success:function(resp, textStatus, http){stopLoader(btn);
              if(resp.type==="success"){
                 //  showpop(resp.message,resp.status);
                  $('.found-ticket-payment').html(resp.view);
              }
            },
            error:function(jhx,textStatus,errorThrown){ stopLoader(btn);
                // console.log(""+textStatus+' - '+errorThrown);
                checkStatus(jhx.status);
            }
            });
     }
 }

function search_completed_ticket_by_date(forms){
     var btn = '.date-search-completed-ticket-btn';
     var dfrom = $('#comp_from').val();
     var dto = $('#comp_to').val();

     if(dfrom ==="" || dto ===""){
         showpop('Please select complete date','error');
     }
     else {
         // submit
         $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/load-completed-tickets-by-dates',
            beforeSend:function(){ startLoader(btn); },
            data: forms,
            success:function(resp, textStatus, http){stopLoader(btn);
              if(resp.type==="success"){
                 //  showpop(resp.message,resp.status);
                 $('.found-completed-date').html(resp.view);
              }
            },
            error:function(jhx,textStatus,errorThrown){ stopLoader(btn);
                // console.log(""+textStatus+' - '+errorThrown);
                checkStatus(jhx.status);
            }
            });
     }
 }

function list_all_pending_payments(forms){
     var btn = '.pending-payment-list-btn';    
         $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/list-all-pending-payments',
            beforeSend:function(){ startLoader(btn); },
            data: forms,
            success:function(resp, textStatus, http){stopLoader(btn);
              if(resp.type==="success"){
                 //  showpop(resp.message,resp.status);
                 $('.found-pending-payments').html(resp.view);
              }
            },
            error:function(jhx,textStatus,errorThrown){ stopLoader(btn);
                // console.log(""+textStatus+' - '+errorThrown);
                checkStatus(jhx.status);
            }
            });    
 }

function filter_daily_report(forms){
     btn = ".daily-report-btn";
     $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/fetch-daily-reports',
            beforeSend:function(){ startLoader(btn); },
            data: forms,
            success:function(resp, textStatus, http){stopLoader(btn);
              if(resp.type==="success"){
                 // showpop(resp.message,resp.status);                  
                 $('.report_view').html(resp.view);
                  // $('.customer-search-payment-btn').trigger('click');
              }
              if(resp.type==="error"){
                  var msg = "";
                  $.each(resp.errors,function(prefix,val){
                       msg+="- <span>"+val[0]+"</span><br/> ";
                  });
                 showpop(msg,'error');                                    
              }

            },
            error:function(jhx,textStatus,errorThrown){ stopLoader(btn);
                console.log(""+textStatus+' - '+errorThrown);
                checkStatus(jhx.status);
            }
            });
}

function filter_overall_report(forms){
     btn = ".overall-report-btn";
     $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/fetch-overall-reports',
            beforeSend:function(){ startLoader(btn); },
            data: forms,
            success:function(resp, textStatus, http){stopLoader(btn);
              if(resp.type==="success"){
                 // showpop(resp.message,resp.status);                  
                 $('.report_view').html(resp.view);
                  // $('.customer-search-payment-btn').trigger('click');
              }
              if(resp.type==="error"){
                  var msg = "";
                  $.each(resp.errors,function(prefix,val){
                       msg+="- <span>"+val[0]+"</span><br/> ";
                  });
                 showpop(msg,'error');                                    
              }

            },
            error:function(jhx,textStatus,errorThrown){ stopLoader(btn);
                console.log(""+textStatus+' - '+errorThrown);
                checkStatus(jhx.status);
            }
            });
}

 function hideInactiveTables(){
     $('table tr.inactive').hide();
     // $('.dataTable').dataTable();
 }


 function showInactiveTables(){
     $('table tr.inactive').show();
     // $('.dataTable').dataTable();
 }
 
 function showTab(a_id){
      $('#'+a_id).tab('show');
 }
 
 function paste_ticket_no(ticketno){
     setTimeout(function(){
         $("#customer_searcher_payment").val(ticketno);
     },500);
     setTimeout(function(){
         $(".customer-search-payment-btn").click();
     },1000);
 }
 
 function calculateAge(){
      var btn = ".age-calculator-btn";
      var forms = $("form#ageCalc").serializeArray();
      $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',  url:'/admin/calculate-age',
            beforeSend:function(){ startLoader(btn); $('input#dob').val(); },
            data: forms,
            success:function(resp, textStatus, http){stopLoader(btn);
                $('input#dob').val(resp.dob);    
                initDatePicker();              
            },
            error:function(jhx,textStatus,errorThrown){ stopLoader(btn);
                // console.log(""+textStatus+' - '+errorThrown);
                checkStatus(jhx.status);
            }
            });
 }
 
    function reverseTicket(ticket){
        // var ticket = $(this).attr('for');
     Swal.fire({
            title: 'Are you sure you want to Reverse this Ticket ?' ,
            text: "It will go back to pending mode !!",
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, Reverse it!'
          }).then((result) => {
            if (result.isConfirmed) {
              Swal.fire(
                'Ticket Reversed!',
                'Request Successful !!!',
                'success',
              )             
            window.location = "/admin/reverse-ticket"+"/"+ticket+"/";
            }
        });
    }
     
    function uploadme(){ // student passport
       var attached = $('#file').val();  // file attached
       var elem =  $('.picture_loader'); var spinner = "<span class='fa fa-spin fa-spinner fa-2x'></span>";
       if(attached==""){
            // alert("please browse for the passport");
              $('.picture_loader').html("<div class='alert alert-danger'>please browse for the passport</div> ");
            }
            else if(!is_valid_img(attached)){
              elem.html("<div class='alert alert-danger'> Please Upload Image - For the Lense </div> ");
            }
            else {
                    mysize = $('#file')[0].files[0].size;
                    mysize = Math.round(mysize / 1024) ;
                    if(mysize > 5000){
                        elem.html("<div class='alert alert-danger'> Passport must not be greater than 5MB, size uploading  is "+mysize +" MB");
                    }
                    else {
                         var fmD = new FormData(); var pix = $('#file')[0].files;
                         fmD.append('picture',pix[0]); // fmD.append('matricno',matricno);
                         // send to server
                          $.ajax({
                               headers:{
                                 'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                                  },
                                url:'/admin/upload-lense-image', type: 'post',
                                data: fmD,  contentType: false, processData: false,
                                beforeSend:function(){
                                    elem.html("<div class='alert alert-info'> Uploading Image &nbsp; &nbsp;"+spinner);
                                    },
                                success: function(response){
                                    $('img.student-passport').attr('src',response['path']);
                                    elem.html("<div class='alert alert-"+response['type']+"'>"+response['message']+"</div");
                                },
                               error:function(jhx,textStatus,errorThrown){ stopLoader();
                                    checkStatus(jhx.status);
                                    }
                            });

				// completed
			 }  // end else  - succesful upload
		}
    }
    
        function is_valid_img(file) {
		var ext = file.split(".");
		ext = ext[ext.length-1].toLowerCase();
		var arrayExtensions = ["jpg" , "jpeg", "png" ]; // , "png", "bmp", "gif"

		if(arrayExtensions.lastIndexOf(ext) == -1) {
			return false;
		}
		return true;
	}

	function getFileSize(file){
		return Math.round(file.size/(1024*1024));
	}

    
    function toggleShowAddress(){
        $("div.address").toggle();
    }
    function toggleShowNok(){
        $("div.nok").toggle();
    }
    
    function toggleSalesPropts(){
       if($('input#is_for_sale').prop('checked')){
           $("div.sales_propts").show('fast'); 
           $("input#new_qty").prop("required",true); 
       }
       else { 
           $("div.sales_propts").hide('fast');
           $("input#new_qty").prop("required",false); 
            }               
        }
       
      function control_product_price(){
          var qty_buy = $('input#qty_buy').val(); 
          var unit_price = $('input#price').val(); 
          var final_price = unit_price * qty_buy ;
          $('input#final_price').val(final_price);
          // console.log(qty_buy);
          // console.log(unit_price);
          $('span.final_price').html(numberSeperator(final_price,true));
      }
    function reset_custom_search(){
        $('#customer_searcher').attr('custom_id','');
        $('#customer_searcher').val('');
    }
    
 // Currency Separator
    var commaCounter = 10;
    function numberSeperator(elem,is_val=false) {
        let Number; 
        if(!is_val){
            Number = elem.val();
        }
        else {
            Number = elem;
        }
         
        Number += '';
        for (var i = 0; i < commaCounter; i++) {
            Number = Number.replace(',', '');
        }

        x = Number.split('.');
        y = x[0];
        z = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;

        while (rgx.test(y)) {
            y = y.replace(rgx, '$1' + ',' + '$2');
        }
        commaCounter++;
         
        if(!is_val){
           elem.val(y + z);
        }
        else {
           return (y + z);
        }
        
    }
    
    
    function submit_doctor_availability_form(){
        var form = $("form.doctor_availability_form").serialize();
        var btn = ".doctor-avail-update-btn";
        $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/set-doctor-availability',
            beforeSend:function(){ startLoader(btn); },
            data : form,
            success:function(resp, textStatus, http){ 
                
              //  alert(resp); 
              if(resp.status==="success"){
                 showpop(resp.message,resp.status);                  
                 $('.report_view').html(resp.view);
                  // $('.customer-search-payment-btn').trigger('click');
              }
              if(resp.status==="error"){
                  var msg = "";
                  $.each(resp.errors,function(prefix,val){
                       msg+="- <span>"+val[0]+"</span><br/> ";
                  });
                 showpop(msg,'error');                                    
              }
              
              stopLoader(btn);

            },
            error:function(jhx,textStatus,errorThrown){ //stopLoader();
                console.log(""+textStatus+' - '+errorThrown);
                checkStatus(jhx.status);
                stopLoader(btn);
            }
            });
    }
    
    function get_doctor_availability(doctor_id){    
        $("input#doctor_id").val(doctor_id);
        $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/get-doctor-availability',
            beforeSend:function(){ startLoader(); },
            data:{ doctor_id:doctor_id } ,
            success:function(response, textStatus, http){ // stopLoader();                
               response.days.forEach(function(days) {
                    $("#my_" + days).prop("checked", true);
                });

                let availability = response.availability;
                let daysMap = { "Sun":0, "Mon":1, "Tue":2, "Wed":3, "Thu":4, "Fri":5, "Sat":6 };
                let allowedDays = response.days.map(d => daysMap[d]);

                 flatpickr("#appointment_date", {
                    dateFormat: "Y-m-d",
                    minDate: "today",
                    enableTime: true,
                    disable: [
                        function(date) {
                            return !allowedDays.includes(date.getDay());
                        }
                    ],
                    onChange: function(selectedDates, dateStr, instance) {
                        if (!selectedDates.length) return;
                        let dayIndex = selectedDates[0].getDay();
                        let selectedDay = availability.find(a => daysMap[a.day_of_week] === dayIndex);
                        if (selectedDay) {
                            instance.set("minTime", selectedDay.start_time);
                            instance.set("maxTime", selectedDay.end_time);
                        }
                    }
                });
                    },
            error:function(jhx,textStatus,errorThrown){ //stopLoader();
                console.log(""+textStatus+' - '+errorThrown);
                checkStatus(jhx.status);
            }
            });
}

function show_doctor_availability(doctor_id,user){    
       // $("input#doctor_id").val(doctor_id);
        $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/get-doctor-availability',
            beforeSend:function(){ startLoader(); },
            data:{ doctor_id:doctor_id } ,
            success:function(response, textStatus, http){ // stopLoader();                               
                let availability = response.availability;
                let daysMap = { "Sun":0, "Mon":1, "Tue":2, "Wed":3, "Thu":4, "Fri":5, "Sat":6 };
                let allowedDays = response.days.map(d => daysMap[d]);
                $('#doctor-name').html("<span class=' h5 bg-primary text-white font-weight-bold m-1 p-2'>"+response.name+" Available Time </span>");
                 flatpickr("#doctor-calendar", {
                    inline: true,   
                    dateFormat: "Y-m-d",
                    minDate: "today",
                   // enableTime: true,
                    disable: [
                        function(date) {
                            return !allowedDays.includes(date.getDay());
                        }
                    ],
                    onChange: function(selectedDates, dateStr, instance) {
                        $.ajax({
                            headers:{
                                  'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                                },
                                type:'post',
                                url: '/admin/get-doctor-slots',
                                data: { date: dateStr , doctor_id:doctor_id },
                                success: function(response) {
                                    let container = $("#time-slots");
                                    container.empty();
                                    if (response.slots.length === 0) {
                                        container.html("<p>No available slots</p>");
                                        return;
                                    }
                                    container.append('<p class="table-success p-2 m-1 font-weight-bold">Select Convinient Time </p>'); 
                                    response.slots.forEach(function(slot) {
                                        let disabledClass = slot.booked ? "disabled btn-secondary" : "btn-outline-primary";
                                        let disabledAttr = slot.booked ? "disabled" : "";
                                        
                                        container.append(
                                              `<button class="btn btn-sm p-2 font-weight-bold m-1 slot-btn ${disabledClass}" 
                                                    data-time="${slot.time}" ${disabledAttr}>
                                               ${slot.time}
                                            </button>`
                                        );
                                    });
                                    // Slot click event
                                    $(".slot-btn").on("click", function() {
                                        $(".slot-btn").removeClass("active");
                                        $(this).addClass("active");
                                        let selectedTime = $(this).data("time");                                        
                                        console.log("Selected slot: " + dateStr + " " + selectedTime);
                                        /*** save the time selected  ****/
                                        $.ajax({
                                            headers:{
                                              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                                            },
                                            type:'post',
                                            url: "/admin/book-doctor-appointment",                                           
                                            data: {                                               
                                                date: dateStr, user:user,
                                                time: selectedTime,doctor_id:doctor_id
                                            },
                                            success: function(response) {
                                                showpop(response.message,response.status);
                                            },
                                            error: function(xhr) {
                                                showpop(xhr.responseJSON.message || "Error booking appointment","error");
                                            }
                                        });
                                        
                                        /****************/                                        
                                    });
                                }
                            });

                    }
                });
                    },
            error:function(jhx,textStatus,errorThrown){ //stopLoader();
                console.log(""+textStatus+' - '+errorThrown);
                checkStatus(jhx.status);
            }
            });
}

function getSlots(doctor_id, dateStr){
    $.ajax({
        headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url: '/admin/get-doctor-slots',
            data: { date: dateStr , doctor_id:doctor_id },
            success: function(response) {
                let container = $("#time-slots");
                container.empty();
                if (response.slots.length === 0) {
                    container.html("<p>No available slots</p>");
                    return;
                }
                response.slots.forEach(function(slot) {
                    container.append(
                        `<button class="btn btn-sm btn-outline-primary m-1 slot-btn" data-time="${slot}">
                            ${slot}
                        </button>`
                    );
                });
                // Slot click event
                $(".slot-btn").on("click", function() {
                    $(".slot-btn").removeClass("active");
                    $(this).addClass("active");
                    let selectedTime = $(this).data("time");
                    console.log("Selected slot: " + dateStr + " " + selectedTime);
                });
            },
            error:function(jhx,textStatus,errorThrown){ //stopLoader();
                console.log(""+textStatus+' - '+errorThrown);
                checkStatus(jhx.status);
            }
        });
}



function schedule_next_appointment(doctor_id,user,app_id){    
       // $("input#doctor_id").val(doctor_id);
        $.ajax({
            headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
            type:'post',
            url:'/admin/get-doctor-availability',
            beforeSend:function(){ startLoader(); },
            data:{ doctor_id:doctor_id } ,
            success:function(response, textStatus, http){ // stopLoader();                               
                let availability = response.availability;
                let daysMap = { "Sun":0, "Mon":1, "Tue":2, "Wed":3, "Thu":4, "Fri":5, "Sat":6 };
                let allowedDays = response.days.map(d => daysMap[d]);
                $('#doctor-name').html("<span class=' h5 bg-primary text-white font-weight-bold m-1 p-2'>"+response.name+" Available Time </span>");
                 flatpickr("#doctor-calendar", {
                    inline: true,   
                    dateFormat: "Y-m-d",
                    minDate: "today",
                   // enableTime: true,
                    disable: [
                        function(date) {
                            return !allowedDays.includes(date.getDay());
                        }
                    ],
                    onChange: function(selectedDates, dateStr, instance) {
                        $.ajax({
                            headers:{
                                  'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                                },
                                type:'post',
                                url: '/admin/get-doctor-slots',
                                data: { date: dateStr , doctor_id:doctor_id },
                                success: function(response) {
                                    let container = $("#time-slots");
                                    container.empty();
                                    if (response.slots.length === 0) {
                                        container.html("<p>No available slots</p>");
                                        return;
                                    }
                                    container.append('<p class="table-success p-2 m-1 font-weight-bold">Select Convinient Time </p>'); 
                                    response.slots.forEach(function(slot) {
                                        let disabledClass = slot.booked ? "disabled btn-secondary" : "btn-outline-primary";
                                        let disabledAttr = slot.booked ? "disabled" : "";
                                        
                                        container.append(
                                              `<button class="btn btn-sm p-2 font-weight-bold m-1 slot-btn ${disabledClass}" 
                                                    data-time="${slot.time}" ${disabledAttr}>
                                               ${slot.time}
                                            </button>`
                                        );
                                    });
                                    // Slot click event
                                    $(".slot-btn").on("click", function() {
                                        $(".slot-btn").removeClass("active");
                                        $(this).addClass("active");
                                        let selectedTime = $(this).data("time");                                        
                                        console.log("Selected slot: " + dateStr + " " + selectedTime);
                                        /*** save the time selected  ****/
                                        // show confirmation 
                                         Swal.fire({
                                            title: 'Are you sure you want to schedule this date for the next appointment?',
                                            text: "Date : "+dateStr+" - Time:  "+selectedTime,
                                            icon: 'question',
                                            showCancelButton: true,
                                            confirmButtonColor: '#3085d6',
                                            cancelButtonColor: '#d33',
                                            confirmButtonText: 'Yes, Schedule!'
                                          }).then((result) => {
                                            if (result.isConfirmed) {
                                                //
                                                  Swal.fire({
                                                   title: 'Scheduling Next Appointment...',
                                                   text: 'Please wait while we complete the process.',
                                                   allowOutsideClick: false,
                                                   allowEscapeKey: false,
                                                   didOpen: () => {
                                                     Swal.showLoading();
                                                   }
                                                 });                                        
                                                $.ajax({
                                                    headers:{
                                                      'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                                                    },
                                                    type:'post',
                                                    url: "/admin/book-doctor-next-appointment",                                           
                                                    data: {                                               
                                                        date: dateStr, user:user,app_id:app_id,
                                                        time: selectedTime,doctor_id:doctor_id
                                                    },
                                                    success: function(response) {
                                                       // showpop(response.message,response.status);
                                                        Swal.fire({
                                                            title: 'Successful!',
                                                            text: response.message,
                                                            icon: 'success',
                                                            timer: 2000
                                                          });
                                                    },
                                                    error: function(xhr) {
                                                        showpop(xhr.responseJSON.message || "Error booking appointment","error");
                                                    }
                                                });  // end ajax submit slot 
                                                }
                                             });
                                        
                                        /****************/                                        
                                    });  // end slot btn click
                                }// end succes - get slot 
                            });

                    }
                });
                    },
            error:function(jhx,textStatus,errorThrown){ //stopLoader();
                console.log(""+textStatus+' - '+errorThrown);
                checkStatus(jhx.status);
            }
            });
}

$(document).on('click', '.appointment-confirm-btn', function (e) {
    e.preventDefault();
    let id = $(this).data('id');
    
    $.ajax({
        headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
        url: '/admin/appointments/' + id + '/confirm',
        type: 'POST',
        beforeSend:function (){ },
        data: {           
        },
        success: function (response) {
            showpop(response.message,response.status);
            // Optionally update UI without reload
            $("#row_" + id + " .status").text("Confirmed");
            $("#row_" + id + " .actions").hide("fast");
            $("#row_" + id + " .status").removeClass("table-warning").addClass('table-success');
        }, error:function(jhx,textStatus,errorThrown){ //stopLoader();
                console.log(""+textStatus+' - '+errorThrown);
                checkStatus(jhx.status);
            }
    });
});

$(document).on('click', '.appointment-cancel-btn', function (e) {
    e.preventDefault();
    let id = $(this).data('id');

    $.ajax({
        headers:{
              'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
            },
        url: '/admin/appointments/' + id + '/cancel',
        type: 'POST',
        data: {            
        },
        success: function (response) {
             showpop(response.message,response.status);
            // Optionally update UI without reload
            $("#row_" + id + " .status").text("Canceled");
            $("#row_" + id + " .actions").hide("fast");
            $("#row_" + id + " .status").removeClass("table-warning").addClass('table-danger');
        }, error:function(jhx,textStatus,errorThrown){ //stopLoader();
                console.log(""+textStatus+' - '+errorThrown);
                checkStatus(jhx.status);
            }
    });
});

function startCountdown() {
    const countdowns = document.querySelectorAll('.countdown');

    countdowns.forEach(function (el) {
        const targetTime = new Date(el.getAttribute('data-time')).getTime();

        function updateTimer() {
            const now = new Date().getTime();
            const distance = targetTime - now;

            if (distance <= 0) {
                el.innerHTML = " Started ";
                el.style.color = "green";
                return;
            }

            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            let text = "";
            if (days > 0) text += days + "d ";
            text += hours + "h " + minutes + "m " + seconds + "s";

            el.innerHTML = text;

            // 🔥 Color coding
            if (distance <= 60 * 60 * 1000) {
                // < 1 hour
                el.style.color = "red";
                el.style.fontWeight = "bold";
            } else if (distance <= 6 * 60 * 60 * 1000) {
                // < 6 hours
                el.style.color = "orange";
            } else if (distance <= 24 * 60 * 60 * 1000) {
                // < 1 day
                el.style.color = "blue";
            } else {
                // > 1 day
                el.style.color = "green";
            }
        }

        // run immediately
        updateTimer();
        // update every second
        setInterval(updateTimer, 1000);
    });
}
document.addEventListener('DOMContentLoaded', startCountdown);
///

$(document).on('click', '.appointment-checkin-btn', function (e) {
    e.preventDefault();
    let id = $(this).data('id');
    $.ajax({
        headers:{ 'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') },
        url: '/admin/appointments/' + id + '/checkin',
        type: 'POST', data: { },
        success: function (response) {
             showpop(response.message,response.status);
            // Optionally update UI without reload
            if(response.status==="success"){
                $("#checkin-" + id ).html(response.checkin_time);
            }
        }, error:function(jhx,textStatus,errorThrown){ //stopLoader();
                console.log(""+textStatus+' - '+errorThrown);
                checkStatus(jhx.status);
            }
    });
});

function activateBtn(elem,btnClass='allBtn'){
    $('.'+btnClass).removeClass('active');
    elem.addClass('active');
}

let info_types = {'consultation':"Take Notes / Observations",
    'profile':"Brief Profile",'history':"Medical History",'appointments':"Previous Appointments"};
    
var process = "<span class='fa fa-spin fa-spinner fa-3x text-dark'></span>";

function getPatientInfo(info_type="consultation"){
    heading = $(".heading");
    heading.html(info_types[info_type]);    
    var patient_id = $('input#patient').val();
    var app_id = $('#app_id').val(); // appointment id
   
     $.ajax({
        headers:{ 'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') },
        url: '/admin/appointments/get-patient-info/'+patient_id,
        type: 'POST', data: { info_type:info_type,app_id:app_id },
        beforeSend:function(){$(".data-body").html(process);  },
        success: function (response) {           
            if(response.status==="success"){
                $(".data-body").html(response.view);               
                if(info_type==="consultation"){
                    display_consultation_summary(app_id,patient_id);
                }
            }
        }, error:function(jhx,textStatus,errorThrown){ //stopLoader();
                console.log(""+textStatus+' - '+errorThrown);
                checkStatus(jhx.status);
            }
    });    
}

 let custom_id = $('#user_id').val();
    if(custom_id !=="") {
        populateCustomerBiodata(custom_id);
    }
            
function populateCustomerBiodata(custom_id){
    btn = $(".ajaxLoader");
     $.ajax({
        headers:{ 'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') },
        url: '/admin/fetch-customer-info',
        type: 'POST', data: { custom_id:custom_id },
          beforeSend:function(){ btn.html(process+" Loading..."); },
        success: function (response) {            
           btn.html(""); 
          
           $("#hmo").val(response.hmo);
           $("#enrole_no").val(response.enrole_no);
           $("#user-surname").val(response.surname);
           $("#user-regno").val(response.regno);
           $("#user-regno").val(response.regno);
           $("#user-firstname").val(response.firstname);
           $("#user-othername").val(response.othername);
           $("#"+response.sex+"_sex").val(response.sex).prop('checked',true);
           $("#dob").val(response.dob);
          // $("#dob").val(response.dob);
           $("#user-phone").val(response.phone);
           $("#user-email").val(response.email);
           $("#user-occupation").val(response.occupation);
           $("#user-nok-name").val(response.nok_name);
           $("#user-nok-phone").val(response.nok_phone);
           $("#user-nok-address").val(response.nok_address);
           $("#user-nok-occupation").val(response.nok_occupation);
           $("#user-nok-relationship").val(response.nok_relationship);
        }, error:function(jhx,textStatus,errorThrown){  btn.html(""); 
                console.log(""+textStatus+' - '+errorThrown);
                checkStatus(jhx.status);
            }
    });    
}

function populateCustomerMedicalHistory(custom_id){
     $.ajax({
        headers:{ 'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') },
        url: '/admin/fetch-customer-medical-history/'+custom_id,
        type: 'POST', data: { },
        // beforeSend:function(){$(".data-body").html(process);  },
        success: function (response) {           
           //  showpop(response);
           $("#history").val(response.history.history);
           $("#drug-history").val(response.history.drug_history);
           $("#family-history").val(response.history.family_history);
        }, error:function(jhx,textStatus,errorThrown){ //stopLoader();
                console.log(""+textStatus+' - '+errorThrown);
                checkStatus(jhx.status);
            }
    });    
}

function submit_updated_customer_profile(){
    form = $("#customer_profile").serialize();
    user_id = $("#user_id").val(); btn = ".submit-updated-customer-profile-btn";
    $.ajax({
        headers:{ 'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') },
        url: '/admin/add-edit-customer/'+user_id,
        type: 'POST', data: form,
        beforeSend:function(){ startLoader(btn); },
        success: function (response) {  stopLoader(btn);      
            if(response.status==="success"){
                showpop(response.message);
                // $(".data-body").html(response.view);               
            }
            if(response.status==="error"){
                  var msg = "";
                  $.each(response.errors,function(prefix,val){
                       msg+="- <span>"+val[0]+"</span><br/> ";
                  });
                 showpop(msg,'error');                                    
              }
        }, error:function(jhx,textStatus,errorThrown){  stopLoader(btn); 
                console.log(""+textStatus+' - '+errorThrown);
                checkStatus(jhx.status);
            }
    });    
}

function submit_updated_customer_medical_history(){
    form = $("#customer_medical_history").serialize();
    user_id = $(".user_id").val(); btn = ".submit-updated-customer-medical-history-btn";
    $.ajax({
        headers:{ 'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') },
        url: '/admin/update-customer-medical-history/'+user_id,
        type: 'POST', data: form,
        beforeSend:function(){ startLoader(btn); },
        success: function (response) {  stopLoader(btn);      
            if(response.status==="success"){
                showpop(response.message);
                // $(".data-body").html(response.view);               
            }
            if(response.status==="error"){
                  var msg = "";
                  $.each(response.errors,function(prefix,val){
                       msg+="- <span>"+val[0]+"</span><br/> ";
                  });
                 showpop(msg,'error');                                    
              }
        }, error:function(jhx,textStatus,errorThrown){  stopLoader(btn); 
                console.log(""+textStatus+' - '+errorThrown);
                checkStatus(jhx.status);
            }
    });    
}
  
let consult_tasks = {'notes':"Make Some Notes / Comments",
    'questionnaire':"Ask Some Questions",'investigations':"Make Some Investigations / Test",
    'prescriptions':"Prescibe Drugs or Lenses For Patient"};

function addConsultTasks(task="notes"){
    heading = $("#consult-header-title");
    heading.html(consult_tasks[task]);    
    var patient_id = $('input#patient').val();
    var app_id = $('#app_id').val(); // appointment id
    var process = "<span class='fa fa-spin fa-spinner fa-3x text-dark'></span>";
   //  console.log(patient_id); exit; 
     $.ajax({
        headers:{ 'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') },
        url: '/admin/appointments/add-consultation-task/'+patient_id,
        type: 'POST', data: { consult_type:task,app_id:app_id },
        beforeSend:function(){$(".consult-body-container").html(process);  },
        success: function (response) { 
            if(response.status==="success"){
                $(".consult-body-container").html(response.view);   
               // add_tinymce();                
            }
        }, error:function(jhx,textStatus,errorThrown){ //stopLoader();
                console.log(""+textStatus+' - '+errorThrown);
                checkStatus(jhx.status);
            }
    });    
}
 
    function display_consultation_summary(app_id,patient_id){
     elem = $(".doctors_consultation_summary");        
     general_body = $(".consult-body-container");
     $.ajax({
        headers:{ 'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') },
        url: '/admin/appointments/display-consultation-summary',
        type: 'POST', data: { app_id:app_id,patient_id:patient_id },
        beforeSend:function(){ elem.html(process);  },
        success: function (response) {           
           //  showpop(response);
           elem.html(response.view);
           // add_tinymce();
           var btn = $('.allSubBtn.active').click();
           
           general_body.html(response.body);
           
            calc_other_bills(); startCountdown(); 
           
           
        }, error:function(jhx,textStatus,errorThrown){ //stopLoader();
                console.log(""+textStatus+' - '+errorThrown);
                checkStatus(jhx.status);
            }
    });    
}

 function display_this_consultation(app_id,patient_id){
     elem = $(".past_consultation_summary");        
     // general_body = $(".consult-body-container");
     $.ajax({
        headers:{ 'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') },
        url: '/admin/appointments/display-dummy-consultation-summary',
        type: 'POST', data: { app_id:app_id,patient_id:patient_id },
        beforeSend:function(){ elem.html(process);  },
        success: function (response) {           
           //  showpop(response);
           elem.html(response.body);
           elem.append(response.view);
           add_tinymce('dummy_notes');
          //  var btn = $('.allSubBtn.active').click();
           
           // general_body.html(response.body);
           // elem.html(response.body);
           
            calc_other_bills(); startCountdown(); 
           
           
        }, error:function(jhx,textStatus,errorThrown){ //stopLoader();
                console.log(""+textStatus+' - '+errorThrown);
                checkStatus(jhx.status);
            }
    });    
}

    // when doctor is commentingn on patient's complaint, after admitting  
    function save_doctors_comment(){
         // tinymce.triggerSave();
         btn = ".save-doctors-comment-btn";
         var report = window.editor.getData(); 
         var app_id = $('#app_id').val(); // appointment id
         var patient_id = $('#patient').val(); // user id
         var regno = $('#regno').val(); // user id
         $.ajax({
            headers:{ 'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') },
            url: '/admin/appointments/save-doctors-comment/'+patient_id+'/'+app_id,
            type: 'POST', data: { report:report,regno:regno },
            beforeSend:function(){ startLoader(btn);  },
            success: function (response) {   stopLoader(btn);
                if(response.status==="success"){
                   showpop(response.message,response.type);  
                   display_consultation_summary(app_id,patient_id);
                }
                else if(response.status==="error"){
                  var msg = "";
                  $.each(response.errors,function(prefix,val){
                       msg+="- <span>"+val[0]+"</span><br/> ";
                  });
                 showpop(msg,'error');                                    
              }              
            }, error:function(jhx,textStatus,errorThrown){  stopLoader(btn);
                    console.log(""+textStatus+' - '+errorThrown);
                    checkStatus(jhx.status);
                }
        });
    }
    
    function repopcomment(comment){       
     //  tinymce.get('complaint_forms').setContent(comment);
       window.editor.setData(comment); 
    }
    
    function filter_qestionaires (question){
        var elem = $('.display_option');
         $.ajax({
            headers:{ 'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') },
            url: '/admin/appointments/search-for-question/',
            type: 'POST', data: { question:question },
            beforeSend:function(){  },
            success: function (response) { 
               // if(response.status==="success"){
                elem.html(response.view);
                // }
            }, error:function(jhx,textStatus,errorThrown){  stopLoader(btn);
                    console.log(""+textStatus+' - '+errorThrown);
                    checkStatus(jhx.status);
                }
        });       
    }
    
    function filter_investigations (test){
        var elem = $('.test_display_option');
         $.ajax({
            headers:{ 'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') },
            url: '/admin/appointments/search-for-investigations/',
            type: 'POST', data: { test:test},
            beforeSend:function(){  },
            success: function (response) { 
               // if(response.status==="success"){
                elem.html(response.view);
                // }
            }, error:function(jhx,textStatus,errorThrown){  stopLoader(btn);
                    console.log(""+textStatus+' - '+errorThrown);
                    checkStatus(jhx.status);
                }
        });       
    }
    
    function filter_drugs_lenses(q){
        if (q.length < 2) {
            $('#searchResults').empty();
            return;
        }
        $.ajax({
            headers:{ 'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') },            
            url: '/admin/appointments/search-for-bills/',
            method: 'POST',
            data: { q: q },
            success: function(data) {
                let list = $('#searchResults').empty();
                $.each(data, function(_, item) {
                    let li = $('<li>')
                        .addClass('list-group-item list-group-item-action')
                        .html(`
                            <strong>${item.name}</strong> 
                            <br><small>Type: ${item.type}</small> 
                            <br><small>₦${item.sales_price} | In Stock: ${item.qty_rem}</small>
                        `)
                        .data('item', item);
                
                         if(item.qty_rem <= 0) {
                            li.addClass('disabled text-muted')
                                .append(' <span class="badge bg-danger text-white ms-2">Out of stock</span>');
                            list.append(li);
                            return; // stop processing this item
                            }
                            
                        li.on('click', function() {
                            addPrescription($(this).data('item'));
                        });                       

                    list.append(li);
                });
            }
        });
    }

    // ➕ Add item to prescription table
    function addPrescription(item) {
        let tbody = $('#prescriptionTable tbody');
        let row = $('<tr>');

        row.append(`<td>${item.name}<input type="hidden" name="item_id[]" value="${item.id}"></td>`);
        row.append(`<td>${item.type}<input type="hidden" name="item_type[]" value="${item.type}"></td>`);
        row.append(`<td>
                    <input type="number" name="quantity[]" 
                           class="form-control form-control-sm qty-input" 
                           value="1" min="1" max="${item.qty_rem}" 
                           data-max="${item.qty_rem}">
                    <small class="text-muted">Max: ${item.qty_rem}</small>
                </td>`);
        row.append(`<td><input type="text" name="dosage[]" class="form-control form-control-sm" placeholder="e.g. 1 tab x 2 daily"></td>`);
        row.append(`<td><button type="button" class="btn btn-sm btn-danger remove-item">Remove</button></td>`);

        tbody.append(row);
        $('#itemSearch').val('');
        $('#searchResults').empty();
    }

// 🧮 Validate quantity input dynamically
    $(document).on('input', '.qty-input', function() {
        let max = parseInt($(this).data('max'));
        let val = parseInt($(this).val());
        if (val > max) {
            alert(`You cannot prescribe more than ${max} units of this item.`);
            $(this).val(max);
        } else if (val < 1 || isNaN(val)) {
            $(this).val(1);
        }
    });

    // ❌ Remove item
    $(document).on('click', '.remove-item', function() {
        $(this).closest('tr').remove();
    });

    function submitPrescription(){
        let prescriptions = [];
        $('#prescriptionTable tbody tr').each(function() {
            prescriptions.push({
                item_id: $(this).find('[name="item_id[]"]').val(),
                item_type: $(this).find('[name="item_type[]"]').val(),
                quantity: $(this).find('[name="quantity[]"]').val(),
                dosage: $(this).find('[name="dosage[]"]').val()
            });
        });
        var app_id = $('#app_id').val(); // appointment id
        var patient_id = $('#patient').val(); // user id
         
        if (prescriptions.length === 0) {
            showpop('Please add at least one prescription.','error');
            return;
        }
        // submit
         $.ajax({
            url: '/admin/appointments/save-prescribed-bills/',
            method: 'POST',
            headers:{ 'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') },            
            contentType: 'application/json',
            data: JSON.stringify({
                patient_id: patient_id,
                app_id: app_id,
                prescriptions: prescriptions
            }),
            success: function(res) {
                showpop(res.message,res.type);
                $('#prescriptionTable tbody').empty();
                display_consultation_summary(app_id,patient_id);
            },
            error: function(xhr) {
                console.error(xhr.responseText);
                alert('Error saving prescription.');
            }
        });
    }  // end function 
    
     
  
    
    
    function addPatientInvestigation(form){        
        patient_id = $('#patient').val(); 
        app_id = $('#app_id').val(); 
        regno = $('#regno').val(); 
        $.ajax({
            headers:{ 'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') },
            url: '/admin/appointments/add-patient-investigation/'+patient_id+'/'+app_id,
            type: 'POST',  data: form.serialize() + '&regno=' + regno + '&patient_id=' + patient_id + '&app_id=' + app_id,
            beforeSend:function(){   }, // startLoader(btn);
            success: function (response) {  // stopLoader(btn);                  
                if(response.status==="success"){
                   showpop(response.message,response.type);  
                   display_consultation_summary(app_id,patient_id);
                }
                else if(response.status==="error"){
//                  var msg = "";
//                  $.each(response.errors,function(prefix,val){
//                       msg+="- <span>"+val[0]+"</span><br/> ";
//                  });
                 showpop(response.message,response.status);                                    
              }               
            }, error:function(jhx,textStatus,errorThrown){  // stopLoader(btn);
                    console.log(""+textStatus+' - '+errorThrown);
                    checkStatus(jhx.status);
                }
        });
    }
    
    
    function handleQuestionnaireResult(form){        
        patient_id = $('#patient').val(); 
        app_id = $('#app_id').val(); 
        regno = $('#regno').val(); 
        $.ajax({
            headers:{ 'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') },
            url: '/admin/appointments/save-doctors-question/'+patient_id+'/'+app_id,
            type: 'POST',  data: form.serialize() + '&regno=' + regno + '&patient_id=' + patient_id + '&app_id=' + app_id,
            beforeSend:function(){   }, // startLoader(btn);
            success: function (response) {  // stopLoader(btn);                  
                if(response.status==="success"){
                   showpop(response.message,response.type);  
                   display_consultation_summary(app_id,patient_id);
                }
                else if(response.status==="error"){
//                  var msg = "";
//                  $.each(response.errors,function(prefix,val){
//                       msg+="- <span>"+val[0]+"</span><br/> ";
//                  });
                 showpop(response.message,response.status);                                    
              }               
            }, error:function(jhx,textStatus,errorThrown){  // stopLoader(btn);
                    console.log(""+textStatus+' - '+errorThrown);
                    checkStatus(jhx.status);
                }
        });
    }
    
    function load_investigation_result(investg_id){
        var elem = $("#invest-result"); var process = "<span class='fa fa-spin fa-spinner fa-3x text-dark'></span>";        
       $.ajax({
            headers:{ 'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') },
            url: '/admin/load-investigation-result',
            type: 'POST',  data:{investg_id:investg_id},
            beforeSend:function(){ elem.html(process);  }, // startLoader(btn);
            success: function (response) { 
              elem.html(response.view);
                
            }, error:function(jhx,textStatus,errorThrown){  // stopLoader(btn);
                    console.log(""+textStatus+' - '+errorThrown);
                    checkStatus(jhx.status);
                }
        });
        
    }
 
 
 
  function calc_other_bills(){
    //  var amount = 0;  
      var init_fee = $('#init_fee').val(); var final_bills = 0;       
      $('input:checkbox.bills').each(function() {
        var amount = parseFloat($(this).data('amount')) || 0; // get data-amount         
        if ($(this).is(':checked')) {             
            final_bills += amount; 
        }
        // showpop(final_bills);
        }); 
      
      var total = (final_bills + parseFloat(init_fee));
      
      if(final_bills > 0) {
          $('.appendix').html("&nbsp;+ &nbsp;"+ numberSeperator(final_bills,true));
          $('.final_total').html(numberSeperator(total,true));
      }
      else {
          $('.appendix').html("");
          $('.final_total').html(numberSeperator(total,true));
      }
     // showpop(final_bills);
  }
  
  function closeAppointment() {
    let patient_id = $('#patient').val(); 
    let app_id = $('#app_id').val(); 
    let regno = $('#regno').val(); 
    let bills = []; 
    let extraAmount = 0; 
    let init_fee = parseFloat($('#init_fee').val()) || 0; 
    let final_fees = 0;   

    $('input:checkbox.bills').each(function() {
      let amount = parseFloat($(this).data('amount')) || 0; // get data-amount         
      if ($(this).is(':checked')) {             
        bills.push($(this).val());
        extraAmount += amount;
      }          
    }); 

    final_fees = extraAmount + init_fee;

    Swal.fire({
      title: 'Are you sure you have completed this appointment?',
      text: "No other operations will continue after closing!",
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, Completed!'
    }).then((result) => {
      if (result.isConfirmed) {
          //
           Swal.fire({
            title: 'Finalizing Appointment...',
            text: 'Please wait while we complete the process.',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
              Swal.showLoading();
            }
          });
          //
          $.ajax({
          headers:{ 'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content') },
          url: `/admin/appointments/${app_id}/finalize`,
          method: 'POST',
          data: {
            bills: bills,          
            final_fees: final_fees,
            _token: $('meta[name="csrf-token"]').attr('content') // important!
          },
          success: function(response) {
            Swal.fire({
              title: 'Appointment Finalized Successfully!',
              text: response.message,
              icon: 'success',
              timer: 2000
            });
          },
          error: function(xhr) {
            Swal.fire({
              title: 'Error!',
              text: 'Something went wrong: ' + xhr.statusText,
              icon: 'error'
            });
          }
        });
 
    }
  });
}

 function deleteConsultationTest(params){
       info = params.split('|');  /// investigation-id | name       
        var patient_id = $('input#patient').val();
        var app_id = $('#app_id').val(); // appointment id
        Swal.fire({
           title: 'Delete This Investigation?',
           text: info[1],
           icon: 'question',
           showCancelButton: true,
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
           confirmButtonText: 'Yes, Delete!'
         }).then((result) => {
           if (result.isConfirmed) {
               //
                 Swal.fire({
                  title: 'Deleting Investigation...',
                  text: 'Please wait while we complete the process.',
                  allowOutsideClick: false,
                  allowEscapeKey: false,
                  didOpen: () => {
                    Swal.showLoading();
                  }
                });                                        
               $.ajax({
                   headers:{
                     'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                   },
                   type:'post',
                   url: "/admin/delete-patient-investigation",                                           
                   data: {                                               
                       params : params
                   },
                   success: function(response) {
                      display_consultation_summary(app_id,patient_id);
                      Swal.fire({
                           title: 'Successful!',
                           text: response.message,
                           icon: 'success',
                           timer: 2000
                         });
                   },
                   error: function(xhr) {
                       showpop(xhr.responseJSON.message || "Error booking appointment","error");
                   }
               });  // end ajax submit slot 
               }
            });

    }
    
    
 function deleteConsultationPrescriptions(params){
       info = params.split('|');  /// prescriptions-id | name | type      
        var patient_id = $('input#patient').val();
        var app_id = $('#app_id').val(); // appointment id
        Swal.fire({
           title: 'Delete This '+info[2],
           text: info[1],
           icon: 'question',
           showCancelButton: true,
           confirmButtonColor: '#3085d6',
           cancelButtonColor: '#d33',
           confirmButtonText: 'Yes, Delete!'
         }).then((result) => {
           if (result.isConfirmed) {
               //
                 Swal.fire({
                  title: 'Deleting Items...',
                  text: 'Please wait while we complete the process.',
                  allowOutsideClick: false,
                  allowEscapeKey: false,
                  didOpen: () => {
                    Swal.showLoading();
                  }
                });                                        
               $.ajax({
                   headers:{
                     'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
                   },
                   type:'post',
                   url: "/admin/delete-patient-prescription",                                           
                   data: {                                               
                       params : params
                   },
                   success: function(response) {
                      display_consultation_summary(app_id,patient_id);
                      Swal.fire({
                           title: 'Successful!',
                           text: response.message,
                           icon: 'success',
                           timer: 2000
                         });
                   },
                   error: function(xhr) {
                       showpop(xhr.responseJSON.message || "Error booking appointment","error");
                   }
               });  // end ajax submit slot 
               }
            });

    }