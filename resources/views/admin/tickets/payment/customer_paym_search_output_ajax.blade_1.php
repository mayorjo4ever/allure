<?php
   use Carbon\Carbon;
   ## use Str;
   ?>
<div class="row">
   <div class="col-md-6">
      <div class="card ">
         <div class="card-body" >
            <!-- payment form  -->
            @if($payments['payment_completed']=="no")
            <p class="card-title"> Make Payment <span class="pull-right pe-7s-note2 pe-2x text-warning font-weight-600"></span> </p>
            <div class="font-weight-600 text-uppercase" style="font-size: 20px">
                Total Cost:
                <?php $price = 0; ?>
                @foreach($payments['specimen'] as $spec)
                <?php $price += $spec['bill_price']; ?>
                @endforeach
                {{ "N".number_format($price)}}
            </div><!-- ./  -->

            <?php $prev_pay = 0;  ?>
            @if(empty($payments['payment']))
            @else
                @foreach($payments['payment'] as $payment)
                <?php $prev_pay += $payment['amount_paid']; ?>
                @endforeach
            @endif
            @php
             $discount = $payments['discount'] ?? 0;
             $balance =  $price - $discount - $prev_pay;
            @endphp

            <form id="make_payment_form" onsubmit="submitPayment($(this).serialize())" method="post" class="needs-validation" novalidate="" action="javascript:void(0)">
            <p class="pt-2 pl-3 font-weight-700 text-success"> Previous Payment : N {{ number_format($prev_pay,2)}} </p>

            <input type="hidden" name="ticketno" value="{{$payments['ticketno']}}" />

            <div class="form-row"><div class="form-group input-group">
                    <label class="col-md-5 font-weight-600">Discount </label>
                    <div class="col-md-7">
                    <input type="text" style="width:200px" class="form-control" value="{{$discount}}" />
                    </div>
                </div>
            </div>
            <div class="form-row mb-3"><div class="col-md-12 input-group">
                    <label class="col-md-5 font-weight-600">Balance Paying : </label>
                    <div class="col-md-7">
                        <input readonly="" type="text" style="width:200px; font-size: 20px" value="{{number_format($balance)}}" class="form-control bg-white" />
                    </div>
            </div></div>

            <div class="form-row mt-3 mb-3">
                <div class="font-weight-600 col-md-3 pl-3"> Pay With </div>
                <div class="font-weight-600 col-md-8">
                 <div class="custom-checkbox custom-control custom-control-inline  mb-1">
                      <input onchange="showPaymode('cash','cashmode')"  name="paymode[]" value="cash" type="checkbox"  id="cash" class="custom-control-input paymode">
                          <label class="custom-control-label font-weight-600" for="cash">Cash </label>
                  </div>
                 <div class="custom-checkbox custom-control custom-control-inline  mb-1">
                      <input onchange="showPaymode('pos','posmode')"  name="paymode[]" value="pos" type="checkbox"  id="pos" class="custom-control-input paymode">
                          <label class="custom-control-label font-weight-600" for="pos">POS </label>
                  </div>

                 <div class="custom-checkbox custom-control custom-control-inline  mb-1">
                     <input onchange="showPaymode('transfer','transfermode')" name="paymode[]" value="transfer" type="checkbox"  id="transfer" class="custom-control-input paymode">
                          <label class="custom-control-label font-weight-600" for="transfer">Transfer </label>
                  </div>

                 </div>
            </div>
            <hr/>
            <div class="form-row mb-3 mt-3" id="cashmode"><div class="col-md-12 input-group">
                    <label class="col-md-5 font-weight-600">Cash Amount : </label>
                    <div class="col-md-7">
                        <input onkeyup="recalc_amount('cash',$(this).val().replace(',','')), numberSeperator($(this))" type="text"  name="amounts[]" style="width:200px; font-size: 20px" value="" class="form-control bg-white cash" required="" />
                    </div>
            </div></div>
            <div class="form-row mb-3 mt-3" id="posmode"><div class="col-md-12 input-group">
                    <label class="col-md-5 font-weight-600">POS Amount : </label>
                    <div class="col-md-7">
                        <input onkeyup="recalc_amount('pos',$(this).val().replace(',','')), numberSeperator($(this))" type="text"  name="amounts[]" style="width:200px; font-size: 20px" value="" class="form-control bg-white pos" required="" />
                        <div class="invalid-feedback">Enter Amount</div>
                    </div>
            </div></div>
            <div class="form-row mb-3 mt-3" id="transfermode"><div class="col-md-12 input-group">
                    <label class="col-md-5 font-weight-600">Transfer Amount : </label>
                    <div class="col-md-7">
                        <input onkeyup="recalc_amount('transfer',$(this).val().replace(',','')), numberSeperator($(this))" type="text" name="amounts[]" style="width:200px; font-size: 20px" value="" class="form-control bg-white transfer" required="" />
                        <div class="invalid-feedback">Enter Amount</div>
                    </div>
            </div></div>

             <div class="form-row mb-3 mt-3" id=""><div class="col-md-12 input-group">
                    <label class="col-md-5 font-weight-600">&nbsp; </label>
                    <div class="col-md-7">
                        <button type="submit" class="btn btn-primary btn-lg w-100 font-weight-700 exec-payment-btn ladda-button" data-style="expand-right"> Pay : <span class="total-amount">0.00</span> </button>
                    </div>
            </div></div>
            </form>


            @endif


            @if($payments['payment_completed']=="yes")
            <!--printout receipt  -->
            <p class="card-title">final Receipt <span class="pull-right pe-7s-note2 pe-2x text-success font-weight-600"></span> </p>
            <a href="{{url('admin/print-receipt/'.base64_encode($payments['ticketno']))}}" target="_blank" title="Print Receipt" class="text-dark" style="text-decoration: none">
               <ul class="list-group list-group-flush">
                  <li class="list-group-item">
                     <div class="widget-content p-0">
                        <div class="widget-content-outer">
                           <div class="widget-content-wrapper">
                              <div class="widget-content-left">
                                 <div class="widget-heading">Total Orders</div>
                                 <div class="widget-subheading">Test Samples :  {{count($payments['specimen'])}} </div>
                              </div>
                              <div class="widget-content-right">
                                 <div class="widget-numbers text-dark" style="font-size: 20px">N
                                    <?php $price = 0; ?>
                                    @foreach($payments['specimen'] as $spec)
                                    <?php $price += $spec['bill_price']; ?>
                                    @endforeach
                                    {{number_format ($price)}}
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </li>
                  <li class="list-group-item">
                     <div class="widget-content p-0">
                        <div class="widget-content-outer">
                             <?php $paid = 0; $paymodes = []; ?>
                                    @foreach($payments['payment'] as $payment)
                                    <?php $paid += $payment['amount_paid'];
                                    $paymodes[] = $payment['paymode'];
                                    ?>
                                    @endforeach
                           <div class="widget-content-wrapper">
                              <div class="widget-content-left">
                                 <div class="widget-heading">Amount Paid </div>
                                 <div class="widget-subheading text-capitalize">by {{ Arr::join($paymodes, ', ', ' and ') }} </div>
                              </div>
                              <div class="widget-content-right">
                                 <div class="widget-numbers text-success" style="font-size: 20px">N {{number_format( ($paid - $payments['refund']))}}
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </li>
               </ul>
            </a>
            @endif
            <!--  end payment receipt -->
         </div>
      </div>


            <!-- if you've make part payment -->

            @if($payments['payment_completed']=="no" && !empty($payments['payment']))
            <!--printout receipt  -->
            <div class="card card-border mt-4"><div class="card-body">
            <p class="card-title">Previous Receipt <span class="pull-right pe-7s-note2 pe-2x text-warning font-weight-600"></span> </p>
            <a href="{{url('admin/print-receipt/'.base64_encode($payments['ticketno']))}}" target="_blank" title="Print Receipt" class="text-dark" style="text-decoration: none">
               <ul class="list-group list-group-flush">
                  <li class="list-group-item">
                     <div class="widget-content p-0">
                        <div class="widget-content-outer">
                           <div class="widget-content-wrapper">
                              <div class="widget-content-left">
                                 <div class="widget-heading">Total Orders</div>
                                 <div class="widget-subheading">Test Samples :  {{count($payments['specimen'])}} </div>
                              </div>
                              <div class="widget-content-right">
                                 <div class="widget-numbers text-dark" style="font-size: 20px">N
                                    <?php $price = 0; ?>
                                    @foreach($payments['specimen'] as $spec)
                                    <?php $price += $spec['bill_price']; ?>
                                    @endforeach
                                    {{number_format ($price)}}
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </li>
                  <li class="list-group-item">
                     <div class="widget-content p-0">
                        <div class="widget-content-outer">
                             <?php $paid = 0; $paymodes = []; ?>
                                    @foreach($payments['payment'] as $payment)
                                    <?php $paid += $payment['amount_paid'];
                                    $paymodes[] = $payment['paymode'];
                                    ?>
                                    @endforeach
                           <div class="widget-content-wrapper">
                              <div class="widget-content-left">
                                 <div class="widget-heading">Amount Paid </div>
                                 <div class="widget-subheading text-capitalize">by {{ Arr::join($paymodes, ', ', ' and ') }} </div>
                              </div>
                              <div class="widget-content-right">
                                 <div class="widget-numbers text-warning" style="font-size: 20px">N {{number_format( ($paid - $payments['refund']))}}</div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </li>
               </ul>
            </a>
            </div> </div>
            @endif
            <!--  end  part payment -->

   </div>
   <!-- comment -->
   <div class="col-md-6">
      <div class="card ">
         <div class="card-body" >
            <p class="card-title">Customer Info</p>
            <div class="table">
               <table class="table table-bordered text-capitalize">
                  <tr>
                     <th>Ticket No</th>
                     <td class="font-weight-600">{{$payments['ticketno']}}</td>
                  </tr>
                  <tr>
                     <td>Name</td>
                     <td class="font-weight-600">{{users_name($payments['patient_id'])}}</td>
                  </tr>
                  <tr>
                     <td>date requested</td>
                     <td class="font-weight-600">{{Carbon::parse($payments['request_date'])->toFormattedDateString()}}</td>
                  </tr>
                  <tr>
                     <td>date completed  </td>
                     <td class="font-weight-600">{{Carbon::parse($payments['date_finalized'])->toFormattedDateString()}}</td>
                  </tr>
                  <tr>
                     <th>Test(s)</th>
                     <td><?php $tests = []; $bills = []; ?>
                        @foreach($payments['specimen'] as $spec)
                        <?php $tests[] = $spec['bill_type_id']; ?>
                        @endforeach
                        <?php
                           $test = array_map(fn($id)=> App\Models\BillType::bill_name($id), $tests);
                           ?>
                        <ul class="pl-3">
                            @foreach ($test as $tt)
                                <li>{{ $tt }} </li>
                            @endforeach
                        </ul>
                     </td>
                  </tr>
               </table>
            </div>
         </div>
      </div>
   </div>
   <!-- comment -->



</div>
