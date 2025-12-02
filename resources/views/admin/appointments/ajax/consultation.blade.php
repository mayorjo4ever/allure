<?php use App\Models\State;use App\Models\Country; use App\Models\Lga; ?>
<div class="row mt-0 pt-0">
        <div class="col-md-12 col-sm-12"> 
           <x-admin.card >
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-row">
                            <div class="col-sm-12">
                                <button onclick="addConsultTasks('notes'),activateBtn($(this),'allSubBtn')" class="btn btn-outline-info active w-100 allSubBtn p-2 m-2 font-weight-600 ">Make Some Notes / Comments </button>
                            </div>
                            <div class="col-sm-12">
                                 <button onclick="addConsultTasks('questionnaire'),activateBtn($(this),'allSubBtn')" class="btn btn-outline-info allSubBtn w-100 p-2 m-2 font-weight-600 "> Add Questionnaires </button>
                            </div>
                            <div class="col-sm-12">
                                <button onclick="addConsultTasks('investigations'),activateBtn($(this),'allSubBtn')" class="btn btn-outline-info allSubBtn w-100 p-2 m-2 font-weight-600">Add Investigations / Test </button>
                            </div>
<!--                            <div class="col-sm-12">
                                 <button onclick="addConsultTasks('diagnosis'),activateBtn($(this),'allSubBtn')" class="btn btn-outline-info allSubBtn w-100 p-2 m-2 font-weight-600">Add Diagnosis </button>
                            </div>                            -->
                            <div class="col-sm-12">
                                 <button onclick="addConsultTasks('prescriptions'),activateBtn($(this),'allSubBtn')" class="btn btn-outline-info allSubBtn w-100 p-2 m-2 font-weight-600">Prescribe Drugs /  Lenses / Frames </button>
                            </div>                            
                        </div>
                    
                    </div>
                    <div class="col-md-9">
                        <div id="consult_container">
                        <h5 class="h5 card-title bg-light p-2 font-weight-600" id="consult-header-title">Make Some Notes / Comments</h5> <!-- Complaints / Questions & Answers / Inquiries -->
                        <div class="consult-body-container"></div>
                        </div>
                    </div>
                </div>
            </x-admin.card>
    </div>            
</div>

<div class="row">
     <div class="col-md-12 col-sm-12"> 
         <x-admin.card header="Report Summary / General Notes " >
             <div class="doctors_consultation_summary"></div>
                 
         </x-admin.card>
     </div>
</div>
