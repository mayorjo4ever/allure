<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
  #  return view('welcome');
  return view('admin.login');
     // return redirect('portal/login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



## login page
##===================
Route::prefix('/portal')->namespace('App\Http\Controllers\Portal')->group(function(){
    Route::match(['get','post'],'login','LoginController@login');
    Route::get('logout','LoginController@logout');
});


## administrator end
##===================

// Admin dashboard without admin
 Route::prefix('/admin')->namespace('App\Http\Controllers\Admin')->group(function(){
## Route::prefix('/portal')->namespace('App\Http\Controllers\Admin')->group(function(){

    ## Route::match(['get','post'],'login','AdminController@login');

    Route::group(['middleware'=>['admin']],function(){

    ##    Route::get('/',function(){ return  dd(array('me'=>'trying to view admin'));});
        Route::get('dashboard','AdminController@dashboard');
        // update admin password
        Route::match(['get','post'], 'update-admin-password','AdminController@updateAdminPassword');
        // check admin password
        Route::post('check-admin-password', 'AdminController@checkAdminPassword');
        // update admin status
        Route::post('update-admin-status', 'AdminController@updateAdminStatus');
        // send sms for birthday users
        Route::post('send-birthday-sms', 'AdminController@sendTodaySms'); # ->name('birthdays.send');
        // 
        // update admin details
        Route::match(['get','post'], 'update-admin-details', 'AdminController@updateAdminDetails');

        // Drugs requests
        Route::get('drugs-category','DrugController@drug_category');
        Route::get('drugs','DrugController@drugs');
        Route::get('tests','TestController@tests');
        Route::match(['get','post'],'add-edit-drugs/{id?}','DrugController@addEditDrugSample');        
        Route::match(['get','post'],'add-edit-drug-category/{sid?}', 'DrugController@addEditDrugCategory');
        Route::match(['get','post'],'add-edit-test/{id?}', 'TestController@addEditTest');        
        
        // Lenses -category
        Route::get('lenses','LenseController@lenses');
        Route::get('frames','LenseController@frames');
        Route::get('lense-category','LenseController@lense_category');
        Route::get('lense-types','LenseController@lense_types');
        Route::match(['get','post'],'add-edit-lense-category/{sid?}', 'LenseController@addEditLenseCategory');
        Route::match(['get','post'],'add-edit-lense-type/{sid?}', 'LenseController@addEditLenseType');
        Route::match(['get','post'],'add-edit-lenses/{id?}', 'LenseController@addEditLenses');
        Route::match(['get','post'],'add-edit-frames/{id?}', 'LenseController@addEditFrames');
        // upload-lense-img
        Route::post('upload-lense-image', 'LenseController@upload_image');        
              
        #  update-bill-categ-status
        Route::post('update-bill-categ-status', 'BillingController@updateCategStatus');        
        Route::post('update-bill-type-status', 'BillingController@updateBillTypeStatus');
        Route::get('bill-samples/{category?}', 'BillingController@bill_samples');
        Route::get('bills', 'BillingController@bill_samples');        
        Route::match(['get','post'],'add-edit-bill/{id?}','BillingController@add_edit_bill_sample');
        
        Route::post('start-bill-template-setup', 'BillingController@startBillTemplateSetup');
        Route::post('submit-param-bill-template-form','BillingController@submit_param_bill_template_form');
        Route::post('submit-text-bill-template-form','BillingController@submit_text_bill_template_form');
        Route::post('update-bill-template-child-status','BillingController@update_bill_template_child_status');
        Route::get('delete-bill_type/{id}','BillingController@delete_bill_type');

        /** manage customers **/
        Route::get('customers','UserController@students');
        Route::get('families','UserController@families');
        Route::match(['get','post'],'add-edit-customer/{id?}','UserController@addEditStudent');
        Route::post('calculate-age','UserController@calculate_age');
        Route::get('customers/import','UserController@userImportView');
        Route::post('customers/read-excel','UserController@readExcel');
        Route::get('medical-report/{id}','UserController@patient_medical_report');        
        Route::post('load-country-states','UserController@load_country_states');
        Route::post('load-state-cities','UserController@load_state_cities');
        Route::post('filter-our-customers','UserController@filter_customers_to_display');
        Route::match(['get','post'],'family-members/{id}','UserController@family_members');
        Route::post('fetch-customer-info','UserController@fetch_customer_info');
        Route::post('fetch-customer-family-info','UserController@fetch_customer_family_info');
        Route::post('add-new-family-member','UserController@add_new_family_member');
       
        ## Appointments #
         # get-doctor-availability
        Route::post('get-doctor-availability', 'AdminController@get_doctor_availability');
        Route::post('set-doctor-availability', 'AdminController@set_doctor_availability');                        
        Route::get('appointment/new/{ref_no?}','ConsultationController@new_appointment');
        Route::post('filter-customers-for-appointment','ConsultationController@filter_customers_to_display');
        Route::post('get-doctor-slots', 'ConsultationController@get_doctor_slots');
        Route::post('book-doctor-appointment', 'ConsultationController@book_doctor_appointment');        
        
        ## Appointments
        Route::match(['get','post'],'appointments', 'ConsultationController@allAppointments');                
        Route::post('appointments/{id}/confirm', 'ConsultationController@confirmAppointment');
        Route::post('appointments/{id}/cancel', 'ConsultationController@cancelAppointment');
        Route::post('appointments/{id}/checkin', 'ConsultationController@checkinAppointment');
        Route::get('appointments/confirmed', 'ConsultationController@viewApprovedApps');
        Route::get('appointments/await-doctor', 'ConsultationController@view_awaiters');
        Route::get('appointments/{id}/admitted', 'ConsultationController@admittedAppointment');
        Route::post('appointments/get-patient-info/{id}', 'ConsultationController@getPatentInfo');
        Route::post('fetch-customer-medical-history/{id}', 'ConsultationController@fetchCustomerMedicalHistory');
        Route::post('/update-customer-medical-history/{id}', 'ConsultationController@updateCustomerMedicalHistory');
        Route::post('appointments/add-consultation-task/{id}', 'ConsultationController@addConsultTasks');
        Route::post('appointments/search-for-question', 'ConsultationController@search_for_question');
        Route::post('appointments/search-for-investigations', 'ConsultationController@search_for_investigations');
        Route::match(['get','post'],'appointments/consultationnotes', 'ConsultationController@manage_consultation_notes');
        Route::get('tests/result-computation/{param}', 'TestController@result_computation');
        Route::post('tests/investigation-result/{id}', 'TestController@storeResult');
        
        ## Inside Consultation Room 
        Route::post('appointments/save-doctors-comment/{patient_id}/{app_id}','ConsultationController@save_doctors_comment');
        Route::post('appointments/save-doctors-question/{patient_id}/{app_id}','ConsultationController@save_doctors_question');
        Route::post('appointments/display-consultation-summary','ConsultationController@display_consultation_summary');
        Route::post('appointments/add-patient-investigation/{patient_id}/{app_id}','ConsultationController@add_patient_investigation');
        Route::post('load-investigation-result','ConsultationController@load_investigation_result');
        Route::post('appointments/search-for-bills','ConsultationController@bill_search');
        Route::post('appointments/save-prescribed-bills','ConsultationController@submitPrescribedBills');
        
        ## Finalizing Appointment :
        Route::get('appointments/{app_id}/finalize/{bills?}/{finalamount}', 'ConsultationController@finalizeAppointment');        
        Route::post('appointments/{app_id}/finalize', 'ConsultationController@finalize2Appointment');        
        
        Route::get('/appointments/pending-investigations','TestController@pending_investigations');
 
        ## VIEW AND PROCESS ALL INVESTIGATIONS 
        
        /** manage tickets 
         Route::get('create-ticket/{id?}','TicketController@create_ticket');
         Route::post('search-customer-info','TicketController@search_customer_info');
         Route::post('fetch-customer-info','TicketController@fetch_customer_info');         
         Route::post('search-specimen-info','TicketController@search_specimen_info');
         Route::post('search-specimen-info-2','TicketController@search_specimen_info_2');
         Route::post('fetch-specimen-info','TicketController@fetch_specimen_info');
         Route::post('fetch-specimen-info-2','TicketController@fetch_specimen_info_2');
         Route::post('add-ticket-bill','TicketController@add_ticket_bill');
         Route::post('add-ticket-bill-2','TicketController@add_ticket_bill_2');
         Route::get('delete-ticket-bill/{id}','TicketController@delete_ticket_bill');
         Route::get('delete-ticket-bill/{ticket_no}/{bill_id}','TicketController@delete_ticket_bill_2');
         Route::get('reverse-ticket/{ticket_no}','TicketController@reverse_finalized_ticket');
         Route::post('fetch-ticket-summary','TicketController@ticket_summary');
         Route::post('finalize-ticket-summary-2','TicketController@finalize_ticket_summary_2');
         Route::post('submit-customer-ticket','TicketController@submit_customer_ticket');         
        
        // ticket page
         Route::get('tickets','TicketController@tickets');
         Route::post('load-pending-tickets','TicketController@load_pending_tickets');
         Route::get('process-ticket/{ticket_no}','TicketController@process_ticket');
        
        ## ticket processing room
        ###############################
         Route::post('preload-bill-result-template','TicketController@bill_result_template_loader');
         Route::post('submit-specimen-report','TicketController@submit_specimen_report');
         Route::post('save-specimen-perform-date','TicketController@save_specimen_perform_date');
         Route::post('save-pathologist-comment','TicketController@save_pathologist_comment');
         Route::post('finalize-test-process','TicketController@finalize_test_process');
         Route::post('add-more-investigation','TicketController@add_more_investigation');

        ## completed tickets
        ###################################
        # load-completed-tickets
        Route::get('load-completed-tickets','TicketController@load_completed_tickets');
        Route::post('load-completed-tickets-by-dates','TicketController@load_completed_tickets_by_dates');
        Route::post('search-customer-completed-ticket','TicketController@search_customer_completed_ticket');
        Route::post('fetch-customer-completed-ticket-info','TicketController@fetch_customer_completed_ticket_info');
        Route::get('print-ticket-result/{ticket_no}/{specimens}','TicketController@print_ticket_result');
        Route::get('download-ticket-result/{ticket_no}/{specimens}','TicketController@download_ticket_result');
    **/

        # ticket payment
        Route::get('payments-receipts','PaymentController@payments_receipts');
        Route::post('list-all-pending-payments','PaymentController@list_pending_payments');
        
        Route::get('ticket-payment','PaymentController@ticket_payment');
        Route::post('search-customer-payment-info','PaymentController@search_payment_info');
        Route::post('fetch-customer-payment-info','PaymentController@fetch_customer_payment_info');
        Route::post('submit-ticket-payment','PaymentController@submit_ticket_payment');
        Route::post('fetch-ticket-payment-by-dates','PaymentController@fetch_ticket_payment_by_dates');
        Route::post('fetch-ticket-payment-by-tickets','PaymentController@fetch_ticket_payment_by_tickets');
        Route::get('print-receipt/{ticket_no}','PaymentController@print_receipt');
        
        // users
         Route::get('users','UserController@users');
         Route::post('update-user-status','userController@updateUserStatus');

         ## roles and permissions
         Route::group(['middleware' => ['role:Super-Admin']], function () {
          Route::get('roles','RoleController@viewRoles');
          Route::get('permissions','RoleController@viewPermissions');
          Route::match(['get','post'],'add-edit-role/{id?}','RoleController@addEditRole');
          Route::match(['get','post'],'add-edit-permission/{id?}','RoleController@addEditPermission');
          Route::get('role-permission','RoleController@rolesPermission');
          Route::post('load-permissions','RoleController@loadPermissions');
          Route::post('change-role-permission','RoleController@changeRolePermission');
         }); ## end middleware



         ##  Administrative Staff
         Route::get('staff','AdminController@admins');
         Route::get('my-profile/{id}','AdminController@adminProfile');
         Route::match(['get','post'],'add-edit-staff/{id?}','AdminController@addEditAdmin');
         Route::get('staff/import','AdminController@adminImportView');
         Route::post('staff/read-excel','AdminController@readExcel');
         Route::post('get-admin-roles','AdminController@getAdminRoles');
         Route::post('set-admin-roles','AdminController@setAdminRoles');
         Route::get('staff/assign-role/{id?}','AdminController@assignRole');
        
        #Micro-Organisms
        Route::get('micro-organisms','MicroOrganismsController@index');
        Route::post('update-microorganism-status', 'MicroOrganismsController@status_update');
        Route::post('update-microorg-treament-status', 'MicroOrganismsController@microorg_treatment_status_update');
        Route::match(['get','post'],'add-edit-micro-organism/{id?}','MicroOrganismsController@create_update_micros');
        Route::match(['get','post'],'add-edit-micro-organism-treatment/{id?}','MicroOrganismsController@create_update_micros_treatment');        
        Route::get('micro-organism-treatments','MicroOrganismsController@micro_treatments');
        
        
        ## REPORTS
        Route::get('daily-reports','ReportController@daily_reports');
        Route::get('weekly-reports','ReportController@weekly_reports');
        Route::get('monthly-reports','ReportController@monthly_reports');
        Route::get('all-reports','ReportController@all_reports');
        Route::get('period-reports','ReportController@period_reports');
        Route::post('fetch-daily-reports','ReportController@fetch_daily_reports');
        Route::post('fetch-overall-reports','ReportController@fetch_overall_reports');
        
        ## QUESTIONNAIRES  
        Route::get('questionnaires','QuestionnaireController@questionnaires');
        Route::match(['get','post'],'add-edit-questionnaire/{id?}','QuestionnaireController@add_edit_questionnaire');
        Route::get('send-test-mail','AdminController@sendTestEmail');                      
        
         
       });
});





require __DIR__.'/auth.php';
