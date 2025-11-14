<div class="container mt-4">
     @include('admin.arch_widgets.alert_messanger')
     
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="main-card mt-0 pt-0 mb-4 pb-4 card">
                <div class="card-header mb-4 mt-3 pt-3">
                    <h2 class="mb-4">📨 Today's Birthday Celebrants </h2>
                </div>
                <div class"card-body p-5 m-5">
                @if($todays_celeb->isEmpty())
                        <p>No birthdays today.</p>
                    @else
                        <form action="{{ url('admin/send-birthday-sms') }}" method="POST">
                            @csrf
                            <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>  
                                        <th>S/N</th>
                                        <th colspan="2">Name</th>
                                        <th>Phone</th>
                                        <th>Birth date</th>
                                        <th>Message Sent</th>                                        
                                        <th><div class="custom-checkbox custom-control custom-control-inline  mb-1">
                                            <input type="checkbox" id="checkAll" class="custom-control-input">
                                            <label class="custom-control-label" for="checkAll">&nbsp; Select All </label>
                                        </div></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($todays_celeb as $k=>$user)
                                        <tr>            
                                            <td>{{$k+1}}</td>
                                            <td><img src="{{asset('template/arch/assets/images/default-user.png')}}" height="90" width="90" class="img img-thumbnail border-1 "/> </td>
                                            <td>{{ $user->surname." ".$user->firstname." ".$user->othername }}</td>                                           
                                            <td>{{ $user->phone }}</td>                                            
                                            <td>{{ \Carbon\Carbon::parse($user->birthdate)->format('F d') }}</td>
                                            <td>Yes</td>
                                            <td>
                                                <div class="custom-checkbox custom-control custom-control-inline  mb-1">
                                                <input type="checkbox" name="user_ids[]" value="{{ $user->id }}"  class="custom-control-input">
                                                <label class="custom-control-label" for="user_ids"> </label></div>
                                             </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <button type="submit" class="btn btn-primary btn-lg m-3 p-3 font-weight-bold ladda-button pull-right" data-style="expand-right"><span class="pe pe-7s-bell font-weight-bold font-1-5rem"></span> <br/> Send Birthday SMS </button>
                        </form>
                    @endif
                    
                </div><!-- ./ card-body -->                     
            </div> <!-- ./ card -->           
        </div>   <!-- col-md-12 -->     
    </div><!-- ./ row -->
    

  <div class="row">
        <div class="col-md-8 col-sm-12">
            <div class="main-card mt-0 pt-0 mb-4 pb-4 card">
                <div class="card-header mb-4 mt-3 pt-3">
                <p class="mb-4 h4">🎉 Upcoming Birthdays (Next 7 Days) </p>
                </div>
                <div class"card-body">
                @if($birthday_users->isEmpty())
                    <p>No upcoming birthdays in the next 7 days.</p>
                @else
                    <table class="table table-rounded jambo-table table-md">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th colspan="2">Name</th>                                                                       
                                <th>Phone</th>
                                <th>Birthdate</th>
                                <th>In Days</th>
                            </tr>
                        </thead>
                        <tbody>
                @foreach($birthday_users as $index => $user)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><img src="{{asset('template/arch/assets/images/default-user.png')}}" height="90" width="90" class="img img-thumbnail border-1 "/> </td>
                    <td>{{ $user->surname ." ".$user->firstname }}</td>                   
                    <td>{{ $user->phone }}</td>
                    <td>{{ \Carbon\Carbon::parse($user->dob)->format('F d') }}</td>
                    <td>
                        {{
                            \Carbon\Carbon::parse($user->dob)->setYear(now()->year)
                                ->diffInDays(now(), false) < 0
                                ? now()->subDay()->diffInDays(\Carbon\Carbon::parse($user->dob)->setYear(now()->year))
                                : now()->subDay()->diffInDays(\Carbon\Carbon::parse($user->dob)->addYear()->setYear(now()->year))
                        }} days
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
    </div><!-- ./ card-body -->                     
            </div> <!-- ./ card -->           
        </div>   <!-- col-md-9  -->     
        
        <div class="col-md-4">
            <div class="card">
                  <div class="main-card mt-0 pt-0 mb-4 pb-4 card">
                    <div class="card-header mb-4 mt-3 pt-3">
                     <p class="h4">🎉 Statistics </p>
                    </div>
                    <div class"card-body">
                       <canvas id="conversionBarChart" height="150"></canvas>
                    </div>
            </div> <!-- ./ card -->
        </div>
        
    </div><!-- ./ row -->
    
</div>
</div>