@extends('layouts.app')
@section('content')


   {{-- <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab"> --}}
   <br>
   <br>
   <br>
    <div class="card m-b-30">
        <div class="card-header">                    
            <h5 class="card-title mb-0">View & Edit</h5>
            {{-- <input type="checkbox" class="js-switch-primary-small" checked /> --}}
        </div>
        <div class="card-body">
            <form action="{{route('aboutus.update',$aboutus->id)}}" method="post" enctype="multipart/form-data">
                @csrf 
                @method('put')
                {{-- <input type="hidden" name="explore_id" id="explore_id" value="{{$contactus->id}}"> --}}
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="username">Name</label>
                        <input type="text" class="form-control" id="username" value="{{$aboutus->name}}" name="name">
                        @error('name')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- <div class="form-row"> --}}
                        <div class="form-group col-md-6">
                            <label for="status">Status</label>
                            <select type="text" class="form-control" id="status" name="status">
                                <option value="1" {{$aboutus->status == 1 ? 'selected':'' }}>Enable</option>
                                <option value="0" {{$aboutus->status == 0 ? 'selected':'' }}>Disable</option>
                            </select>
                        </div>
                    {{-- </div> --}}
                </div>
                    <div class="mb-4">
                        <label for="about_page">About Page Design</label>
                        <textarea class="form-control" id="about_page" name="about_page" value="{{$aboutus->about_page}}">{{$aboutus->about_page}}</textarea>
                    </div>
                    @error('about_page')
                            <div class="error text-danger">{{ $message }}</div>
                    @enderror
                    <button type="submit" class="btn btn-primary-rgba font-16"><i class="ri-save-line mr-2"></i>Update</button>
            </form>
        </div>
    </div>
    <br>
    <br>
    <br>


{{-- </div> --}}
<!-- My Profile End -->
@endsection

@push('custom-scripts')

<script>
    let editor;
    ClassicEditor
    .create( document.querySelector(  '#about_page' ), {
      // Configure image upload
      ckfinder : {
        // Replace 'your-server-url' with the actual server endpoint for image upload
        uploadUrl: "{{ route('ckeditor.upload',['_token'=>csrf_token()]) }}",
      },
      // ...
      // Other configuration options
    } )
      .then( newEditor => {
      editor = newEditor;
      } )
      .catch( error => {
          console.error( error );
      } );
  </script>

{{-- <script>
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
</script> --}}

@endpush