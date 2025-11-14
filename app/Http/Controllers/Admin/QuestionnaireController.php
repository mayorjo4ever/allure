<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Questionnaire;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use function GuzzleHttp\json_encode;
use function redirect;
use function response;
use function view;

class QuestionnaireController extends Controller
{
    //
    public function  questionnaires() {
        Session::put('page','services'); Session::put('subpage','app_questionnaires');        
        $page_info = ['title'=>'All Questionnaires','icon'=>'pe-7s-clock','sub-title'=> "  "];
        $questionnaires = Questionnaire::all();
        $btns = [           
           ['name'=>"Add New Questionnaire",'action'=>"admin/add-edit-questionnaire", 'class'=>'btn btn-primary'],
           ];
        #  print "<pre>"; print_r($questionnaires); die;
        return view('admin.questionnaire.questions',compact('page_info','questionnaires','btns'));  
    }
    
    public function add_edit_questionnaire(Request $request, $id=null) {
        Session::put('page','services'); Session::put('subpage','add_questionnaires');        
          $btns = [           
           ['name'=>"View Questionnaires",'action'=>"admin/questionnaires", 'class'=>'btn btn-primary'],
           ];
          if($id==""):
            $questionnaire = new Questionnaire; $msg = "Questionnaire Created Successfully!";
            $page_info = ['title'=>'Add New Questionnaire','icon'=>'pe-7s-clock',];
            else :
            $questionnaire = Questionnaire::findOrFail($id); $msg = "Questionnaire Updated Successfully!";
            $page_info = ['title'=>'Update Questionnaire No. '.$id,'icon'=>'pe-7s-clock',];
        endif;
        
        if($request->isMethod('post')){
           # print "<pre>"; print_r($request->all()); 
           # print_r($questionnaire->toArray());
           # die;
            $validated = $request->validate([
                'question' => 'required|string|max:500',
                'type' => 'required|in:text,boolean,choice',
                'options' => 'nullable|string', // JSON for choices
                'default_answer' => 'nullable|string|max:500',
            ]);
            
            $questionnaire->question = $validated['question'];
            $questionnaire->type = $validated['type'];            
            $questionnaire->options = $validated['options'] ? json_encode(explode(',', $validated['options'])) : null;
            $questionnaire->default_answer = $validated['default_answer'] ?? null; 
            $questionnaire->save(); 
            return redirect()->back()->with('success_message', $msg);
        }
        return view('admin.questionnaire.add_edit_question',compact('page_info','questionnaire','btns'));  
    }
    
    public function search_for_question(Request $request) {
        $question = $request->question; 
        $options = Questionnaire::where('question','LIKE','%'.$question.'%')->get(); 
        print_r($options);
        
        return response()->json([
                'status'=>'success',
                'view'=>(String)View::make('admin.appointments.ajax.question_body')]);
        
        
    }
    
}
