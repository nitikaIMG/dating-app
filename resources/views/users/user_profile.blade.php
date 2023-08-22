@extends('layouts.app')
@section('content')

@push('custom-styles')
    <style>
        .plan_detail{
            margin-left: 340px !important;
        }
    </style>
@endpush


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
           
                
                <!--user basic info-->
                <br>
                <b><span>User Basic Information:</span></b>
                <br>
                <br>


                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="education">Education</label>
                        <select type="text" class="form-control" id="education" name="education">
                            @forelse($all_education as $education)
                                <option value="{{$education->id}}" {{$user->UserInfo->education == $education->id?'selected':''}}>{{$education->name}}</option>
                            @empty
                                <option>NO Education</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="zodiac">Zodiac</label>
                        <select type="text" class="form-control" id="zodiac" name="zodiac">
                            @forelse($all_zodiac as $zodiac)
                                <option value="{{$zodiac->id}}" {{$user->UserInfo->zodiac == $zodiac->id?'selected':''}}>{{$zodiac->name}}</option>
                            @empty
                                <option>No Zodiac</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="relationship_goal">Relationship Goal</label>
                        <select type="text" class="form-control" id="relationship_goal" name="relationship_goal">
                            @forelse($all_relationship_goal as $relationship_goal)
                                <option value="{{$relationship_goal->id}}" {{$user->UserInfo->relationship_goal == $relationship_goal->id?'selected':''}}>{{$relationship_goal->name}}</option>
                            @empty
                                <option>No relationship_goal</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="relationship_type">Relationship Type</label>
                        <select type="text" class="form-control" id="relationship_type" name="relationship_types">
                            @forelse($all_relationship_type as $relationship_type)
                                <option value="{{$relationship_type->id}}" {{$user->UserInfo->relationship_type == $relationship_type->id?'selected':''}}>{{$relationship_type->name}}</option>
                            @empty
                                <option>No relationship_type</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="receive_love">receive_love</label>
                        <select type="text" class="form-control" id="receive_love" name="receive_love">
                            @forelse($all_receive_love as $receive_love)
                                <option value="{{$receive_love->id}}" {{$user->UserInfo->receive_love == $receive_love->id?'selected':''}}>{{$receive_love->name}}</option>
                            @empty
                                <option>No receive_love</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="personality_type">personality_type</label>
                        <select type="text" class="form-control" id="personality_type" name="personality_type">
                            @forelse($all_personality_type as $personality_type)
                                <option value="{{$personality_type->id}}" {{$user->UserInfo->personality_type == $personality_type->id?'selected':''}}>{{$personality_type->name}}</option>
                            @empty
                                <option>No personality_type</option>
                            @endforelse
                        </select>
                    </div>


                    <div class="form-group col-md-6">
                        <label for="passion">passion</label>
                        <select type="text" class="form-control" id="passion" name="passion">
                            @forelse($all_passion as $passion)
                                <option value="{{$passion->id}}" {{$user->UserInfo->passion == $passion->id?'selected':''}}>{{$passion->name}}</option>
                            @empty
                                <option>No passion</option>
                            @endforelse
                        </select>
                    </div>


                    <div class="form-group col-md-6">
                        <label for="sexual_orientation">sexual_orientation</label>
                        <select type="text" class="form-control" id="sexual_orientation" name="sexualorientation">
                            @forelse($all_sexual_orientation as $sexual_orientation)
                                <option value="{{$sexual_orientation->id}}" {{$user->UserInfo->sexual_orientation == $sexual_orientation->id?'selected':''}}>{{$sexual_orientation->name}}</option>
                            @empty
                                <option>No sexual_orientation</option>
                            @endforelse
                        </select>
                    </div>

                    
                    <div class="form-group col-md-6">
                        <label for="pet">pet</label>
                        <select type="text" class="form-control" id="pet" name="pet">
                            @forelse($all_pet as $pet)
                                <option value="{{$pet->id}}" {{$user->UserInfo->pet == $pet->id?'selected':''}}>{{$pet->name}}</option>
                                @empty
                                <option>No pet</option>
                                @endforelse
                            </select>
                    </div>
                        
                    <div class="form-group col-md-6">
                        <label for="drink">Drink</label>
                        <select type="text" class="form-control" id="drink" name="drink">
                            @forelse($all_drinks as $drink)
                                <option value="{{$drink->id}}" {{$user->UserInfo->drink == $drink->id?'selected':''}}>{{$drink->name}}</option>
                            @empty
                                <option>No drink</option>
                            @endforelse
                        </select>
                    </div>
                        
                    <div class="form-group col-md-6">
                        <label for="smoke">smoke</label>
                        <select type="text" class="form-control" id="smoke" name="smoke">
                            @forelse($all_smoke as $smoke)
                                <option value="{{$smoke->id}}" {{$user->UserInfo->smoke == $smoke->id?'selected':''}}>{{$smoke->name}}</option>
                            @empty
                                <option>No smoke</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="vaccine">vaccine</label>
                        <select type="text" class="form-control" id="vaccine" name="vaccine">
                            @forelse($all_vaccine as $vaccine)
                                <option value="{{$vaccine->id}}" {{$user->UserInfo->vaccine == $vaccine->id?'selected':''}}>{{$vaccine->name}}</option>
                            @empty
                                <option>No vaccine</option>
                            @endforelse
                        </select>
                    </div>

                  
                    <div class="form-group col-md-6">
                        <label for="workout">workout</label>
                        <select type="text" class="form-control" id="workout" name="workout">
                            @forelse($all_workout as $workout)
                                <option value="{{$workout->id}}" {{$user->UserInfo->workout == $workout->id?'selected':''}}>{{$workout->name}}</option>
                            @empty
                                <option>No workout</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="children">children</label>
                        <select type="text" class="form-control" id="children" name="children">
                            @forelse($all_children as $children)
                                <option value="{{$children->id}}" {{$user->UserInfo->children == $children->id?'selected':''}}>{{$children->name}}</option>
                            @empty
                                <option>No children</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="dietry">dietry</label>
                        <select type="text" class="form-control" id="dietry" name="dietary">
                            @forelse($all_dietry as $dietry)
                                <option value="{{$dietry->id}}" {{$user->UserInfo->dietry == $dietry->id?'selected':''}}>{{$dietry->name}}</option>
                            @empty
                                <option>No dietry</option>
                            @endforelse
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="language">language</label>
                        <select type="text" class="form-control" id="language" name="language">
                            @forelse($all_language as $language)
                                <option value="{{$language->id}}" {{$user->UserInfo->language == $language->id?'selected':''}}>{{$language->name}}</option>
                            @empty
                                <option>No language</option>
                            @endforelse
                        </select>
                    </div>
                </div>
                <br>
                <br>
                {{-- <hr> --}}
                <!-- Subscription Details-->
                @if(!empty($user->subscriptionusers))
                <b><span>User Plan Information:</span></b>
                <br>
                <br>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="subscription_name">Subscription Name</label>
                        <a href="{{route('subscription.edit',$user->subscriptionusers->subscription_id)}}"  class="btn btn-sm btn-link plan_detail">Full Detail</a>
                        <input type="text" class="form-control" id="subscription_name" value="{{$subscription_details->plan_name??''}}" readonly>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="refer_code">Price</label>
                        <input type="text" class="form-control" id="refer_code" value="{{$subscription_details->price??''}}" readonly>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="refer_by">Boost Use Or Not</label>
                        <input type="email" class="form-control" id="refer_by" value="{{$user->subscriptionusers->free_boost_per_month !== 0 ?'Use':'Not Use'}}" readonly>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="refer_by">Super Like Use</label>
                        <input type="email" class="form-control" id="refer_by" value="{{$user->subscriptionusers->free_super_like}}" readonly>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="default-date">Expire Date</label>
                        <input type="text" id="default-date" class="form-control" placeholder="{{$user->subscriptionusers->expire_date??''}}" aria-describedby="basic-addon2" value="{{$user->subscriptionusers->expire_date??''}}" name="expire_date" readonly/>
                  
                    </div>

                    <div class="form-group col-md-6">
                        <label for="sub_status">Subscription Status</label>
                        <select type="text" class="form-control" id="sub_status" readonly>
                            <option value="1" {{$user->subscriptionusers->status == 1 ? 'selected': ''}}>Active</option>
                            <option value="0" {{$user->subscriptionusers->status == 0 ? 'selected': ''}}>Disabled</option>
                        </select>
                    </div>
                </div>
                @endif

                <br>
                <b><span>Refer & User Status:</span></b>
                <br>
                <br>
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