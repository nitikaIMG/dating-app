@extends('layouts.app')
@section('content')
   <br>
   <br>
   <br>
    <div class="card m-b-30">
            <!--Zodiac -->
            @if($create == 'zodiac')
                <div class="card-header">                    
                    <h5 class="card-title mb-0">Zodiac</h5>
                </div>
                <div class="card-body">
                <form action="{{route('zodiac.store')}}" method="post" enctype="multipart/form-data">
            @endif
            <!-- education level-->
            @if($create == 'education')
                <div class="card-header">                    
                    <h5 class="card-title mb-0">Education Level</h5>
                </div>
                <div class="card-body">
                <form action="{{route('education.store')}}" method="post" enctype="multipart/form-data">
            @endif
            <!-- personality type -->
            @if($create == 'personality')
                <div class="card-header">                    
                    <h5 class="card-title mb-0">Personality Type</h5>
                </div>
                <div class="card-body">
                <form action="{{route('personality.store')}}" method="post" enctype="multipart/form-data">
            @endif
            <!-- comunincation style-->
            @if($create == 'communication')
                <div class="card-header">                    
                    <h5 class="card-title mb-0">Communication Style</h5>
                </div>
                <div class="card-body">
                <form action="{{route('communication.store')}}" method="post" enctype="multipart/form-data">
            @endif

            <!-- children style-->
            @if($create == 'children')
                <div class="card-header">                    
                    <h5 class="card-title mb-0">Children</h5>
                </div>
                <div class="card-body">
                <form action="{{route('children.store')}}" method="post" enctype="multipart/form-data">
            @endif

              <!-- receivelove style-->
            @if($create == 'receivelove')
                <div class="card-header">                    
                    <h5 class="card-title mb-0">Love</h5>
                </div>
                <div class="card-body">
                <form action="{{route('receivelove.store')}}" method="post" enctype="multipart/form-data">
            @endif

                <!-- vaccine -->
            @if($create == 'vaccine')
                <div class="card-header">                    
                    <h5 class="card-title mb-0">Vaccine</h5>
                </div>
                <div class="card-body">
                <form action="{{route('vaccine.store')}}" method="post" enctype="multipart/form-data">
            @endif

            <!-- pet -->
            @if($create == 'pet')
                <div class="card-header">                    
                    <h5 class="card-title mb-0">Pet</h5>
                </div>
                <div class="card-body">
                <form action="{{route('pet.store')}}" method="post" enctype="multipart/form-data">
            @endif

              <!-- drinking -->
            @if($create == 'drinking')
                <div class="card-header">                    
                    <h5 class="card-title mb-0">Drinking</h5>
                </div>
                <div class="card-body">
                <form action="{{route('drinking.store')}}" method="post" enctype="multipart/form-data">
            @endif

              <!-- sleepinghabit -->
            @if($create == 'sleepinghabit')
                <div class="card-header">                    
                    <h5 class="card-title mb-0">Sleeping Habits</h5>
                </div>
                <div class="card-body">
                <form action="{{route('sleepinghabit.store')}}" method="post" enctype="multipart/form-data">
            @endif

            <!-- Workout -->
            @if($create == 'workout')
            <div class="card-header">                    
                <h5 class="card-title mb-0">Workout</h5>
            </div>
            <div class="card-body">
                <form action="{{route('workout.store')}}" method="post" enctype="multipart/form-data">
            @endif

            <!-- dietary -->
            @if($create == 'dietary')
                <div class="card-header">                    
                    <h5 class="card-title mb-0">Dietary</h5>
                </div>
                <div class="card-body">
                <form action="{{route('dietary.store')}}" method="post" enctype="multipart/form-data">
            @endif

            <!-- smoke -->
            @if($create == 'smoke')
                <div class="card-header">                    
                    <h5 class="card-title mb-0">Smoke</h5>
                </div>
                <div class="card-body">
                <form action="{{route('smoke.store')}}" method="post" enctype="multipart/form-data">
            @endif

            <!-- sexualorientation -->
            @if($create == 'sexualorientation')
                <div class="card-header">                    
                    <h5 class="card-title mb-0">Sexual Orientation</h5>
                </div>
                <div class="card-body">
                <form action="{{route('sexualorientation.store')}}" method="post" enctype="multipart/form-data">
            @endif

                @csrf 
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="username">Name</label>
                        <input type="text" class="form-control" id="username" value="{{old('name')}}" name="name" >
                        @error('name')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                        <div class="form-group col-md-6">
                            <label for="status">Status</label>
                            <select type="text" class="form-control" id="status" name="status">
                                <option value="1" selected>Enable</option>
                                <option value="0" >Disable</option>
                            </select>
                        </div>
                </div>
                <button type="submit" class="btn btn-primary-rgba font-16"><i class="ri-save-line mr-2"></i>Create</button>
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