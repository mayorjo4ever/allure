<div class="form-row">
    <div class="col-md-12">        
        <input onkeyup="filter_drugs_lenses($(this).val().trim())" type="text" id="itemSearch" class="form-control" placeholder="Search drugs or lenses...">
    </div>
    <ul id="searchResults" class="list-group mt-2"></ul>

    <form id="prescriptionForm" onsubmit="submitPrescription()" action="javascript:void(0)"> @csrf
        <table class="table mt-3 w-100" id="prescriptionTable">
            <thead>
                <tr>
                    <th>Item</th>
                    <th>Type</th>
                    <th>Qty</th>
                    <th>Dosage</th>
                    <th></th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>

        <button type="submit" class="btn btn-primary p-2 w-100">Save Prescription</button>
    </form>

</div>
