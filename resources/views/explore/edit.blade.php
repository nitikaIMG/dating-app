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
            <form action="{{route('explore.update',$explore->id)}}" method="post" enctype="multipart/form-data">
                @csrf 
                @method('put')
                <input type="hidden" name="explore_id" id="explore_id" value="{{$explore->id}}">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="username">First Name</label>
                        <input type="text" class="form-control" id="username" value="{{$explore->name}}" name="name" >
                        @error('name')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- <div class="form-row"> --}}
                        <div class="form-group col-md-6">
                            <label for="status">Status</label>
                            <select type="text" class="form-control" id="status" name="status">
                                <option value="1" {{$explore->status == 1 ? 'selected':'' }}>Enable</option>
                                <option value="0" {{$explore->status == 0 ? 'selected':'' }}>Disable</option>
                            </select>
                        </div>
                    {{-- </div> --}}
                </div>
                <div class="card m-b-30" >
                    <div class="card-header">                                
                        <h5 class="card-title mb-0">Media</h5>
                    </div>
                    <div class="card-body">
                        <div class="profilebox pt-4 text-center">
                            <ul class="list-inline">
                                @if(!empty($explore->thumbnail))
                                    <li class="list-inline-item">
                                        {{-- <a href="#" class="btn btn-success-rgba font-18"><i class="ri-edit-circle-line"></i></a> --}}
                                    </li>
                                    <li class="list-inline-item">
                                        <img src="{{asset($explore->thumbnail)??asset('public/assets/images/users/profile.svg')}}" class="img-fluid" alt="profile">
                                    </li>
                                    <li class="list-inline-item">
                                        {{-- <a href="#" class="btn btn-danger-rgba font-18"><i class="ri-delete-bin-3-line"></i></a> --}}
                                    </li>
                                @else
                                    <li class="list-inline-item">
                                        <a href="#" class="btn btn-danger-rgba font-18">No Thumbanil Image!<i class="ri-delete-bin-3-line"></i></a>
                                    </li>
                                @endif
                                <div class="fallback">
                                    <input name="file" type="file" title="Change Image">
                                    @error('file')
                                    <div class="error text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </ul>
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary-rgba font-16"><i class="ri-save-line mr-2"></i>Update</button>
            </form>
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
        var explore_id = $('#explore_id').val();
        // alert('Selected value: ' + value);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: "{{route('active.deactive')}}",
            type: "POST",
            data: {
                value:value,
                explore_id:explore_id
            },
            success: function(data) {
                if(data.status == 'success'){
                    new PNotify({
                        title: 'Success',
                        text: 'Explore Update',
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