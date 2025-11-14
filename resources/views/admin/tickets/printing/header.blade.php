<div class="row"><div class="col-md-12">
    <table class="table table-sm table-borderless">
        <tr  align="center">
            <td rowspan="2">
                <img style="height:100px" src="{{asset('template/arch/assets/images/logo.jpg')}}" />
            </td>
            <td class="text-uppercase font-weight-600">
                <span class="h3 font-weight-700" style="font-size:28px">{{str_replace('_',' ',env('APP_NAME'))}} </span>
            </td>
             <td rowspan="2">
                <img style="height:100px" src="{{asset('template/arch/assets/images/logo.jpg')}}" />
            </td>
        </tr>
        <tr align="center" class="mt-0 pt-0">
            <td class="text-capitalize font-weight-600"> <!-- Mailing Address -->
                <span class="card-title"> {{ str_replace("_", " ",env('SUB_APP_NAME')) }} </span>  <br/>
             <!--    <span class="">Beside Unilorin Health Service Clinic </span>  <br/> -->
               <!--  <span class="">P.M.B 1515, Ilorin </span>  <br/> -->
                <span class="">Telephone :  {{str_replace("_"," ",env('APP_PHONE'))}}  </span>  <br/>
                <span class="text-lowercase">e-Mail : {{env('APP_EMAIL')}} </span>
            </td>

        </tr>
    </table>
   </div>
</div>