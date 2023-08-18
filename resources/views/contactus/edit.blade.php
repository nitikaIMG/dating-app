@extends('layouts.app')
@section('content')


   {{-- <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab"> --}}
   <br>
   <br>
   <br>
    <div class="card m-b-30">
        <div class="card-header">                    
            <h5 class="card-title mb-0">View Message & Reply</h5>
            {{-- <input type="checkbox" class="js-switch-primary-small" checked /> --}}
        </div>
        <div class="card-body">
            <form action="{{route('contactus.update',$contactus->id)}}" method="post" enctype="multipart/form-data">
                @csrf 
                @method('put')
                <input type="hidden" name="explore_id" id="explore_id" value="{{$contactus->id}}">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="username">Name</label>
                        <input type="text" class="form-control" id="username" value="{{$contactus->user->name}}" name="name" readonly>
                        @error('name')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- <div class="form-row"> --}}
                        <div class="form-group col-md-6">
                            <label for="status">Status</label>
                            <select type="text" class="form-control" id="status" name="status">
                                <option value="1" {{$contactus->status == 1 ? 'selected':'' }}>Enable</option>
                                <option value="0" {{$contactus->status == 0 ? 'selected':'' }}>Disable</option>
                            </select>
                        </div>
                    {{-- </div> --}}
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="msg_for_admin">Message</label>
                        <input type="text" class="form-control" id="msg_for_admin" name="msg_for_admin" value="{{$contactus->msg_for_admin}}" readonly />
                    </div>
                    @error('msg_for_admin')
                            <div class="error text-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">

                        <label for="reply">Reply To User</label>
                        @if(!empty($contactus->reply_from_admin))
                            <input type="text" class="form-control" id="reply" name="reply" value="{{$contactus->reply_from_admin}}" />
                        @else
                            <input type="text" class="form-control" id="reply" name="reply" value="{{old('reply')}}" />
                        @endif
                    </div>
                    @error('reply')
                        <div class="error text-danger">{{ $message }}</div>
                    @enderror
                </div>

                @if(!empty($contactus->reply_from_admin))
                    <a href="{{route('contactus.index')}}" class="btn btn-primary-rgba font-16">GO Back</a>
                @else
                    {{-- <input type="text" class="form-control" id="reply" name="reply" value="{{old('reply')}}" /> --}}
                    <button type="submit" class="btn btn-primary-rgba font-16"><i class="ri-save-line mr-2"></i>Sent</button>
                @endif
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
                url: "{{route('contactus.activedeactive')}}",
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