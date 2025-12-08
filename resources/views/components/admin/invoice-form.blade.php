<div class="row" id="existng-invoice-form">
    <div class="col-md-9">
        <span class="h5">Select which Invoice to Add To ?</span>
    </div>
     <div class="col-md-3">
         <button class="btn btn-info font-weight-600 p-2">Create New Invoice &nbsp; <i class="fa fa-plus-circle"></i></button>
    </div>
</div>


<div class="row mt-2 pt-2" id="new-invoice-form">
    <div class="col-md-12">
        <span class="h5">Create New Invoice </span>
        <hr/>
        <span class="h6">Customer Details </span> <br/>
        <table class="table">
            <tr>
                <td>Name</td>
                <td></td>
            </tr>
            <tr>
                <td>HMO</td>
                <td></td>
            </tr>
        </table>
    </div>
     <div class="col-md-6 mb-3">
         <label>Select HMO / Organization </label>
         <select class="form-control ">
             <option value=""></option>
             <option value=""></option>                     
         </select>
    </div>
    <div class="col-md-6 mb-3">
         <label>Bill Amount</label>
         <input type="number" readonly="" class="form-control bg-white " placeholder="Bill Amount"/>             
    </div>
     <div class="col-md-6 mb-3">
         <label>Discount Amount</label>
         <input type="number" class="form-control bg-white " placeholder="Discount Amount"/>             
    </div>
    <div class="col-md-6 mb-3">
         <label>Final Amount</label>
         <input type="number" readonly="" class="form-control bg-white " placeholder="Discount Amount"/>             
    </div>
     <div class="col-md-12">
         <label>&nbsp;</label>
         <button type="submit" class="btn btn-success p-2 btn-block " placeholder="Discount Amount">
             Create Invoice
         </button>             
    </div>
</div>
