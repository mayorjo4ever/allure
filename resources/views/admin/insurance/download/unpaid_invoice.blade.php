@extends('admin.arch_layouts.download_layout')
@section('content')
<style>    
/* Apply to every table in the system */
table {
    width: 100%;
    border-collapse: collapse !important;
    font-size: 14px !important;
}

table th,
table td {
    padding: 6px 8px !important;    /* Force tiny padding */
    border: 1px solid #333 !important;  /* Dark border */
}

.no-border th,
.no-border td {
    padding: 6px 8px !important;    /* Force tiny padding */
    border: none; border-collapse: collapse;  /* Dark border */
}

 /*Optional: Header background*/ 
table th {
    background: #f2f2f2 !important;
    font-weight: 600 !important;
}

/* Optional: striped rows */
table tr:nth-child(even) {
    background: #fafafa;
}
table td p,
table th p {
    margin: 0 !important;
    padding: 0 !important;
}
</style>
<div class="row mt-0 pt-0">
   <div class="col-md-12 col-sm-12">

      <div class="col-md-12 bg-white">
           
          @include('admin.insurance.download.header')
          @include('admin.insurance.download.unpaid_invoice_body')
          @include('admin.insurance.download.comment_footer')
             
      </div>
      <!-- col-md-12 -->

   </div>
   <!-- col-lg-12 -->
</div>
<!-- row -->
@endsection
