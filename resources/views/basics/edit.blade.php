@extends('layouts.app')
@section('content')
   <br>
   <br>
   <br>
    <div class="card m-b-30">
            <!--Zodiac  -->
            @if($edit == 'zodiac')
                <div class="card-header">                    
                    <h5 class="card-title mb-0">Zodiac</h5>
                </div>
                <div class="card-body">
                <form action="{{route('zodiac.update', $editdata->id)}}" method="post" enctype="multipart/form-data">
            @endif
            <!-- education -->
            @if($edit == 'education')
                <div class="card-header">                    
                    <h5 class="card-title mb-0">Education</h5>
                </div>
                <div class="card-body">
                <form action="{{route('education.update', $editdata->id)}}" method="post" enctype="multipart/form-data">
            @endif
            <!-- personalty -->
            @if($edit == 'personality')
                <div class="card-header">                    
                    <h5 class="card-title mb-0">Personality Type</h5>
                </div>
                <div class="card-body">
                <form action="{{route('personality.update', $editdata->id)}}" method="post" enctype="multipart/form-data">
            @endif
            <!-- communication -->
            @if($edit == 'communication')
                <div class="card-header">                    
                    <h5 class="card-title mb-0">Communication Style</h5>
                </div>
                <div class="card-body">
                <form action="{{route('communication.update', $editdata->id)}}" method="post" enctype="multipart/form-data">
            @endif
            <!-- communication -->
            @if($edit == 'children')
                <div class="card-header">                    
                    <h5 class="card-title mb-0">Children</h5>
                </div>
                <div class="card-body">
                <form action="{{route('children.update', $editdata->id)}}" method="post" enctype="multipart/form-data">
            @endif

                @csrf 
                @method('put')
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="username">Name</label>
                        <input type="text" class="form-control" id="username" value="{{$editdata->name}}" name="name" >
                        @error('name')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group col-md-6">
                        <label for="status">Status</label>
                        <select type="text" class="form-control" id="status" name="status">
                            <option value="1" {{$editdata->status == 1 ? 'selected': ''}}>Enable</option>
                            <option value="0" {{$editdata->status == 0 ? 'selected': ''}}>Disable</option>
                        </select>
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