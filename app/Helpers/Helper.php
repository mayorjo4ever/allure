<?php

use App\Models\Admin;
use App\Models\AllTreatment;
use App\Models\Appointment;
use App\Models\BillType;
use App\Models\CustomerTicket;
use App\Models\DoctorAvailability;
use App\Models\FamilyGroup;
use App\Models\InvestigationTemplate;
use App\Models\Organization;
use App\Models\PaymentInvoice;
use App\Models\User as User2;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use NumberToWords\NumberToWords;


function timeSchedule($hours,$minutes, $force_show = false){
   $h = addS("Hour", $hours);
   $m = addS("Minute", $minutes);

   return $h." ".$m;
}

function addS($text,$number,$force_show = false){
    $rs ="";    ## result
    if($number == 0 ){
        $rs =  "";
    }
    if($number ==1 ){
        $rs = $number." ".$text;
    }
    if($number >=2 ){
        $rs =  $number." ".$text."s";
    }
    return $rs;
}

function show_age_label($number,$text){

    return $result = ($number == 0)?"" : addS($text, $number);

}

 function users_name($user_id){
    $user = User::find($user_id);
    return $user->surname.',  '.$user->firstname.' '.$user->othername;
}

function hosp_no($user_id){
    $user = User::find($user_id);
    return $user->regno;
}
 function users_info($user_id){
    $user = User::find($user_id);
    $age = Carbon::parse($user->dob)->age;
    return ['fullname'=>$user->surname.',  '.$user->firstname.' '.$user->othername,
        'regno'=>$user->regno,'age'=>$age,'dob'=>$user->dob,'email'=>$user->email,'sex'=>$user->sex,
        'phone'=>$user->phone,'account_type'=>$user->account_type];
}

 function admin_info($admin_id){
    $user = Admin::find($admin_id);
    return ['fullname'=>$user->title.' '.$user->surname.',  '.$user->firstname.' '.$user->othername,
       'mobile'=>$user->mobile,'email'=>$user->email];
}

    function calc_age($from,$to=null){
        if($to=="") : $to = Carbon::now(); endif; 
        $years = Carbon::parse($from)->diff(Carbon::parse($to))->format('%y,%m,%d ');
        $spt = explode(',',$years); // split

        $y = show_age_label($spt[0], 'Year');
        $m = show_age_label($spt[1], 'Month');
        $d = show_age_label($spt[2], 'Day');

        return $y.' '.$m.' '.$d;
    }

    function adminRoles($id){
        $admin = Admin::find($id);
        $my_roles = $admin->getRoleNames()->toArray();
        return implode(" <br/> ", $my_roles);
    }
    #
    function get_new_ticket_id(){
        $ticket = CustomerTicket::where([
            'create_mode'=>'completed',
            'year'=>date('Y')
            ])->count();
        $next = $ticket + 1;
        $padded = Str::padLeft($next, 4, '0');

        return date('y')."/".env('TICKET_SHORTCODE')."/".$padded ;
    }
    
    function paymode_amount($paymode,$amounts){
        ## just get the index and return
        if($paymode ==='cash') { return $amounts[0]; }
        if($paymode ==='pos') { return $amounts[1]; }
        if($paymode ==='transfer') { return $amounts[2]; }
    }

    function extract_amount($rows,$paymode){
        $modes = []; $amounts = [];
        foreach ($rows as $row){
            if(in_array($paymode, $row)){
                $modes[$paymode] = $paymode;
                $amounts[] = $row['amount_paid'];
            }
        }
        return $amounts;
        #$sum = empty($amounts)?0 : array_sum($amounts);
        # return [Arr::join($amounts,', '),$sum];
    }

function total_bill_cost($year) {
 $amount = CustomerTicket::where(['create_mode'=>'completed',
     'year'=>$year])->sum('total_cost');
    return $amount;
}

function total_bill_paid($year) {
 $amount = CustomerTicket::where(['create_mode'=>'completed',
     'year'=>$year])->sum('amount_paid');
 $refund = CustomerTicket::where(['create_mode'=>'completed',
     'year'=>$year])->sum('refund');

    return $amount;
}

function total_pending_payment($year) {
 $paid = CustomerTicket::where(['create_mode'=>'completed',
     'year'=>$year])->sum('amount_paid');
  $bill = total_bill_cost($year);

    return $pending = $bill - $paid ;
}

function extract_dates($dates){
    foreach($dates as $d){
        $dt[] = $d['date_paid'];
    }
   $simplify = array_unique($dt);
   $last =  Arr::last($simplify);
   return Carbon::parse($last)->toDayDateTimeString();
}

function bill_name($id){
    return BillType::bill_name($id);
}

function print_paymode($payments){
    $output = [];
    foreach ($payments as $payment){
        $output[] = $payment['paymode']." : ". number_format($payment['amount_paid']);
    }
    return Arr::join($output,', ',' and ');
}

function bill_has_template($bill_id) {
    $templates = BillType::has('template')->where('id',$bill_id)->exists();
    return $templates;
}

function list_customer_specimen($specimens,$results){
    $spec = "";
    foreach($specimens as $specimen):
        $spec.="<p class='p-1'>"; $borderClose = "</span>";
        $borderOpen = "<span class=' table-danger p-2 m-1 rounded' >";
        if(!empty($results)):
            foreach ($results as $result):
              if(in_array($specimen['bill_type_id'], $result)):
                   $borderOpen = "<span class=' table-success p-2 m-1 rounded' >";                   
                endif;
            endforeach;
        endif;
        
        $spec.= $borderOpen . bill_name($specimen['bill_type_id']);
        $spec.= $borderClose."</p>";
    endforeach;
    $spec .= "";

    return $spec;
}

function extract_result($templateId, $results){
    $ans = "";
   if(!empty($results)):
        foreach($results as $result):
            if($templateId == $result['template_id']) :
                $ans = $result['result'];
            endif;
        endforeach;
    endif;
    return $ans;
}

function extract_comment($templateId, $results){
    $ans = "";
   if(!empty($results)):
        foreach($results as $result):
            if($templateId == $result['template_id']) :
                $ans = $result['comment'];
            endif;
        endforeach;
    endif;
    return $ans;
}


function extract_checkbox($templateId, $results){
    $ans = "";
   if(!empty($results)):
        foreach($results as $result):
            if($templateId == $result['template_id']) :
                $ans = "checked";
            endif;
        endforeach;
    endif;
    return $ans;
}

function microorganism_treatment_name($ids='3,4,8'){
    if(Session::get('organism_treatment_names')==null):
        $treatments = AllTreatment::all()->pluck('name','id'); 
        Session::put('organism_treatment_names', $treatments);        
    endif;
    $treats = Session::get('organism_treatment_names'); 
    $lists = explode(",", $ids); 
    $results = array_map(fn($index)=>$treats[$index] , $lists);
    return Arr::join($results, ", ");
    
}

function get_new_family_id($account_type,$stud_id,$family_id,$im_host=0){
    $proceed = true; 
    #if($account_type == "personal") : $proceed = false; endif; 
    if(empty($family_id) && $account_type !== "personal" && $im_host==1 && $proceed ) : 
        $last = FamilyGroup::count();      
        $family_id =  $last+1; 
        return $family_id; 
      #elseif(!empty($family_id)):
      #    return $family_id;
    endif; 
}
    
function get_new_outsider_id(){
        $customer = User2::where([
            'account_type'=>'outsider'
            ])->count();
        $next = $customer + 1;
        $padded = Str::padLeft($next, 4, '0');

        return env('OUTSIDER_REG_SHORTCODE')."/".$padded."/".date('Y');
    }

    function get_new_corporate_id(){
        $customer = User2::where([
            'account_type'=>'corporate'
            ])->count();
        $next = $customer + 1;
        $padded = Str::padLeft($next, 4, '0');

        return env('CORPORATE_REG_SHORTCODE')."/".$padded."/".date('Y');
    }
    
    function my_appointment_time($doctor_id){        
        $days = DoctorAvailability::where('doctor_id',$doctor_id)
                ->where('is_active',true)
                ->pluck('day_of_week') // e.g., ["Mon","Wed","Fri"]
                 ->toArray();
           $output =  Str::of(collect($days)->join(' , ', ' & ')); 
        return "<b> $output  </b>";
        
    }
    
    function investigation_name($id){
       $name = InvestigationTemplate::findOrFail($id);
       return $name->name ?? "";
    }
       
    function get_general_bills($ids){
        $bills = explode(",",$ids);        
        $bill_info = BillType::whereIn('id',$bills)->get();         
        return $bill_info;               
    }
    
    function appointment_details($id){
        return Appointment::find($id);
    }
    
    
if (! function_exists('number_to_words')) {

    /**
     * Convert number / amount to words (NGN).
     *
     * @param float|int $amount
     * @return string
     */
     
    function number_to_words($amount)
    {
        if (! is_numeric($amount)) {
            return '';
        }

        $numberToWords = new NumberToWords();
        $numberTransformer = $numberToWords->getNumberTransformer('en');

        $naira = floor($amount);
        $kobo  = round(($amount - $naira) * 100);

        $words = $numberTransformer->toWords($naira) . ' naira only';

        if ($kobo > 0) {
            $words .= ' and ' . $numberTransformer->toWords($kobo) . ' kobo';
        }

        return ucfirst($words);
    } 
}

function new_org_invoice_no($org_id){
    $invoices = PaymentInvoice::
            where('status','closed')
            ->distinct('invoice_number')
            ->count('invoice_number'); 
    $new_id = $invoices + 1; 
    $prefix = 'AEI';
        $datePart = now()->format('ymd'); // e.g. 20251106
        $invoice_no = str_pad($new_id, 4, '0', STR_PAD_LEFT); // pad appointment ID
        $orgn = str_pad($org_id, 3, '0', STR_PAD_LEFT); // pad appointment ID
        
        return "{$prefix}{$orgn}{$datePart}{$invoice_no}";
}

function calculate_invoice_bill($invoice_number){
    $amounts = PaymentInvoice::where('invoice_number',$invoice_number)
            ->sum('amount');
     $discounts = PaymentInvoice::where('invoice_number',$invoice_number)
             ->sum('discount');
    
       return $amounts - $discounts;
}

function organization_name($id){
    $sql = Organization::findOrFail($id);
    return $sql->name;
}