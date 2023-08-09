@extends('layouts.app')
@section('content')


   {{-- <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab"> --}}
   <br>
   <br>
   <br>
    <div class="card m-b-30">
        <div class="card-header">                    
            <h5 class="card-title mb-0">Subscription</h5>
        </div>
        <div class="card-body">
            <form action="{{route('subscription.update',$subcription->id)}}" method="post" enctype="multipart/form-data">
                @csrf 
                @method('put')
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="plan_name">Name</label>
                        <input type="text" class="form-control" id="plan_name" value="{{$subcription->plan_name}}" name="plan_name" >
                        @error('plan_name')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="price">Price</label>
                        <input type="text" class="form-control" id="price" value="{{$subcription->price}}" name="price" >
                        @error('price')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group col-md-6">
                        <label for="unlimited_likes">Unlimited Likes</label>
                        <select type="text" class="form-control" id="unlimited_likes" name="unlimited_likes">
                            <option value="1" {{$subcription->unlimited_likes == '1'? 'selected':''}}>Active </option>
                            <option value="0" {{$subcription->unlimited_likes == '0'? 'selected':''}}>Deactive</option>
                        </select>
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label for="see_who_likes_you">See Who Likes You</label>
                        <select type="text" class="form-control" id="see_who_likes_you" name="see_who_likes_you">
                            <option value="1" {{$subcription->see_who_likes_you == '1'? 'selected':''}}>Active </option>
                            <option value="0" {{$subcription->see_who_likes_you == '0'? 'selected':''}}>Deactive</option>
                        </select>
                    </div>
                    

                    <div class="form-group col-md-6">
                        <label for="priority_likes">Priority Likes</label>
                        <select type="text" class="form-control" id="priority_likes" name="priority_likes">
                            <option value="1" {{$subcription->priority_likes == '1'? 'selected':''}}>Active </option>
                            <option value="0" {{$subcription->priority_likes == '0'? 'selected':''}}>Deactive</option>
                        </select>
                    </div>
                    

                    <div class="form-group col-md-6">
                        <label for="unlimited_rewinds">Unlimited Rewinds</label>
                        <select type="text" class="form-control" id="unlimited_rewinds" name="unlimited_rewinds">
                            <option value="1" {{$subcription->unlimited_rewinds == '1'? 'selected':''}}>Active </option>
                            <option value="0" {{$subcription->unlimited_rewinds == '0'? 'selected':''}}>Deactive</option>
                        </select>
                    </div>
                    

                    <div class="form-group col-md-6">
                        <label for="free_boost_per_month">1 Free Boost Per Month</label>
                        <select type="text" class="form-control" id="free_boost_per_month" name="free_boost_per_month">
                            <option value="1" {{$subcription->free_boost_per_month_1 == '1'? 'selected':''}}>Active </option>
                            <option value="0" {{$subcription->free_boost_per_month_1 == '0'? 'selected':''}}>Deactive</option>
                        </select>
                    </div>
                    

                    <div class="form-group col-md-6">
                        <label for="free_super_likes_per_week">5 Free Super Likes Per Week</label>
                        <select type="text" class="form-control" id="free_super_likes_per_week" name="free_super_likes_per_week">
                            <option value="1" {{$subcription->free_super_likes_per_week_5 == '1'? 'selected':''}}>Active </option>
                            <option value="0" {{$subcription->free_super_likes_per_week_5 == '0'? 'selected':''}}>Deactive</option>
                        </select>
                    </div>
                    

                    <div class="form-group col-md-6">
                        <label for="message_before_matching">Message Before Matching</label>
                        <select type="text" class="form-control" id="message_before_matching" name="message_before_matching">
                            <option value="1" {{$subcription->message_before_matching == '1'? 'selected':''}}>Active </option>
                            <option value="0" {{$subcription->message_before_matching == '0'? 'selected':''}}>Deactive</option>
                        </select>
                    </div>
                    

                    <div class="form-group col-md-6">
                        <label for="passport">Passport</label>
                        <select type="text" class="form-control" id="passport" name="passport">
                            <option value="1" {{$subcription->passport == '1'? 'selected':''}}>Active </option>
                            <option value="0" {{$subcription->passport == '0'? 'selected':''}}>Deactive</option>
                        </select>
                    </div>
                    

                    <div class="form-group col-md-6">
                        <label for="top_pics">Top Pics</label>
                        <select type="text" class="form-control" id="top_pics" name="top_pics">
                            <option value="1" {{$subcription->top_pics == '1'? 'selected':''}}>Active </option>
                            <option value="0" {{$subcription->top_pics == '0'? 'selected':''}}>Deactive</option>
                        </select>
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label for="control_your_profile">Control Your Profile</label>
                        <select type="text" class="form-control" id="control_your_profile" name="control_your_profile">
                            <option value="1" {{$subcription->control_your_profile == '1'? 'selected':''}}>Active </option>
                            <option value="0" {{$subcription->control_your_profile == '0'? 'selected':''}}>Deactive</option>
                        </select>
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label for="control_who_sees_you">Control Who Sees You</label>
                        <select type="text" class="form-control" id="control_who_sees_you" name="control_who_sees_you">
                            <option value="1" {{$subcription->control_who_sees_you == '1'? 'selected':''}}>Active </option>
                            <option value="0" {{$subcription->control_who_sees_you == '0'? 'selected':''}}>Deactive</option>
                        </select>
                    </div>

                    <div class="form-group col-md-6">
                        <label for="control_who_you_see">Control Who You See</label>
                        <select type="text" class="form-control" id="control_who_you_see" name="control_who_you_see">
                            <option value="1" {{$subcription->control_who_you_see == '1'? 'selected':''}}>Active </option>
                            <option value="0" {{$subcription->control_who_you_see == '0'? 'selected':''}}>Deactive</option>
                        </select>
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label for="hide_ads">Hide Ads</label>
                        <select type="text" class="form-control" id="hide_ads" name="hide_ads">
                            <option value="1" {{$subcription->hide_ads == '1'? 'selected':''}}>Active </option>
                            <option value="0" {{$subcription->hide_ads == '0'? 'selected':''}}>Deactive</option>
                        </select>
                    </div>
                    
                    <div class="form-group col-md-6">
                        <label for="status">Status</label>
                        <select type="text" class="form-control" id="status" name="status">
                            <option value="1"   {{$subcription->status == '1'? 'selected':''}}>Active </option>
                            <option value="0"   {{$subcription->status == '0'? 'selected':''}}>Deactive</option>
                        </select>
                    </div>
                    

                </div>
                {{-- <div class="card m-b-30" >
                    <div class="card-header">                                
                        <h5 class="card-title mb-0">Media</h5>
                    </div>
                    <div class="card-body">
                        <div class="profilebox pt-4 text-center">
                            <ul class="list-inline">
                                    <li class="list-inline-item">
                                    </li>
                                    <li class="list-inline-item">
                                        
                                    </li>
                                    <div class="fallback">
                                        <input name="file" type="file">
                                        @error('file')
                                        <div class="error text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <li class="list-inline-item">
                                </li>
                            </ul>
                        </div>
                    </div>
                </div> --}}
                <button type="submit" class="btn btn-primary-rgba font-16"><i class="ri-save-line mr-2"></i>Update</button>
            </form>
        </div>
    </div>
    <br>
    <br>


{{-- </div> --}}
<!-- My Profile End -->
@endsection

@push('custom-scripts')

{{-- <script>
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

</script> --}}

@endpush