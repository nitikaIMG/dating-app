@extends('layouts.app')
@section('content')


   {{-- <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab"> --}}
   <br>
   <br>
   <br>
    <div class="card m-b-30">
        <div class="card-header">                    
            <h5 class="card-title mb-0">View Profile</h5>
            {{-- <input type="checkbox" class="js-switch-primary-small" checked /> --}}
         
        </div>
        <div class="card-body">
            <form action="{{route('users.update',$user->id)}}" method="post">
                @csrf 
                @method('put')
                <input type="hidden" id="user_id" value="{{$user->id}}">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="username">First Name</label>
                        <input type="text" class="form-control" id="username" value="{{$user->first_name??''}}" name="first_name">
                        @error('first_name')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="username">Last Name</label>
                        <input type="text" class="form-control" value="{{$user->last_name??''}}" name="last_name">
                        @error('last_name')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- <div class="form-group col-md-6">
                        <label for="useremail">Email</label>
                        <input type="email" class="form-control" id="useremail" value="{{$user->email??'null'}}" readonly >
                    </div> --}}
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="usermobile">Mobile Number</label>
                        <input type="text" class="form-control" id="usermobile" value="{{$user->phone??''}}" name="usermobile" maxlength="10" readonly>
                        @error('usermobile')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="default-date">Date of Birth</label>
                        {{-- <input type="text" class="form-control" id="userbirthdate" value="{{$user->UserInfo->dob??''}}" readonly> --}}

                        <input type="text" id="default-date" class="datepicker-here form-control" placeholder="{{$user->UserInfo->dob??''}}" aria-describedby="basic-addon2" value="{{$user->UserInfo->dob??''}}" name="userbirthdate"/>
                                  {{-- <div class="input-group-append">
                                    <span class="input-group-text" id="basic-addon2"><i class="ri-calendar-line"></i></span>
                                  </div> --}}
                        @error('userbirthdate')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="form-row">
                    @if(!empty($user->age))
                    {{-- <div class="form-group col-md-6">
                        <label for="userpassword">Age</label>
                        <input type="text" class="form-control" id="userpassword" value="{{$user->age??''}}" readonly>
                    </div> --}}
                    @endif
                </div> 
                <div class="form-row">
                    <div class="form-group col-md-6">
                        @if(!empty($user->UserInfo))
                        <label for="userconfirmedpassword">Interest</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="male_interest" name="userinterest" class="custom-control-input" value="0" {{$user->UserInfo->interests == '0'? 'checked':''}}>
                            <label class="custom-control-label" for="male_interest" >Male</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="female_interest" name="userinterest" class="custom-control-input" value="1" {{$user->UserInfo->interests == '1'? 'checked':''}}> 
                            <label class="custom-control-label" for="female_interest" >Female</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="other_interest" name="userinterest" class="custom-control-input" value="2"  {{$user->UserInfo->interests  == '2'? 'checked':''}}>
                            <label class="custom-control-label" for="other_interest">Other</label>
                        </div>
                        @endif
                    </div>
                    <div class="form-group">
                        <label for="userconfirmedpassword">Gender</label>
                        <br>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="usermale" name="usergender" class="custom-control-input" value="0" {{$user->gender == '0'? 'checked':''}}>
                            <label class="custom-control-label" for="usermale" >Male</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="userfemale" name="usergender" class="custom-control-input" value="1" {{$user->gender == '1'? 'checked':''}}> 
                            <label class="custom-control-label" for="userfemale" >Female</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" id="userother" name="usergender" class="custom-control-input" value="2" {{$user->gender == '2'? 'checked':''}}>
                            <label class="custom-control-label" for="userother">Other</label>
                        </div>
                        @error('usergender')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="userbirthdate">Relationship Goal</label>
                        <input type="text" class="form-control" id="userbirthdate" value="{{$user->UserInfo->relationship_goals??''}}" name="relationship_goals">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="userbirthdate">Life Style</label>
                        <input type="text" class="form-control" id="userbirthdate" value="{{$user->UserInfo->life_style??''}}" name="life_style">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="company_name">Company</label>
                        <input type="text" class="form-control" id="company_name" value="{{$user->UserInfo->company??''}}" name="company">
                    </div>
                    <div class="form-group col-md-6">
                        <label for="school">School</label>
                        <input type="text" class="form-control" id="school" value="{{$user->UserInfo->school??''}}" name="school">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="refer_code">Refer Code</label>
                        <input type="text" class="form-control" id="refer_code" value="{{$user->refer_code??''}}" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="refer_by">Refer By</label>
                        <input type="email" class="form-control" id="refer_by" value="{{$user->refer_by !== 0 ?'Name':''}}" readonly>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="status">Status</label>
                        <select type="text" class="form-control" id="status" >
                            <option value="1" {{$user->status == 1 ? 'selected': ''}}>Active</option>
                            <option value="0" {{$user->status == 0 ? 'selected': ''}}>Block</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary-rgba font-16"><i class="ri-save-line mr-2"></i>Update</button>
            </form>
        </div>
    </div>

    <div class="card m-b-30">
        <div class="card-header">                                
            <h5 class="card-title mb-0">Media</h5>
        </div>
        <div class="card-body">
            <div class="profilebox pt-4 text-center">
                <ul class="list-inline">
                    @if(!empty($user->profile_image))
                        <li class="list-inline-item">
                            {{-- <a href="#" class="btn btn-success-rgba font-18"><i class="ri-edit-circle-line"></i></a> --}}
                        </li>
                        <li class="list-inline-item">
                            <img src="{{asset($user->profile_image)??asset('public/assets/images/users/profile.svg')}}" class="img-fluid" alt="profile">
                        </li>
                    @else
                        <li class="list-inline-item">
                            <a href="#" class="btn btn-danger-rgba font-18">User have no profile images!<!--<i class="ri-delete-bin-3-line"></i>--></a>
                     @endif
                    </li>
                </ul>
            </div>
        </div>
    </div>
{{-- </div> --}}
<!-- My Profile End -->
@endsection

@push('custom-scripts')

<script>
$(document).ready(function() {
    $(document).on('change', '#status', function() {
        var value = $('#status').val();
        var user_id = $('#user_id').val();
        // alert('Selected value: ' + value);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('active.deactive')}}",
            type: "POST",
            data: {
                value:value,
                user_id:user_id
            },
            success: function(data) {
                if(data.status == 'success'){
                    new PNotify({
                        title: 'Success',
                        text: 'Account Update',
                        type: 'success'
                    });
                }
                else{
                    new PNotify({
                        title: 'Warning',
                        text: 'Something Went Wrong',
                        type: 'Warning'
                    });
                }
            }
        })
    });
});

</script>

@endpush