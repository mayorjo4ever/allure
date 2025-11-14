@extends('admin.arch_layouts.layout')
@section('content')

   @include('admin.arch_widgets.widget')
  
   
   
<script>
    document.getElementById('checkAll').onclick = function() {
        let checkboxes = document.querySelectorAll('input[name="user_ids[]"]');
        for (let checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    };
</script>

@endsection 
