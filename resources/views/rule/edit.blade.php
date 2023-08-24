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
            <form action="{{route('rule.update',$rule->id)}}" method="post" enctype="multipart/form-data">
                @csrf 
                @method('put')
                <input type="hidden" name="rule_id" id="rule_id" value="{{$rule->id}}">
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label for="username">Name</label>
                        <input type="text" class="form-control" id="username" value="{{$rule->name}}" name="name">
                        @error('name')
                            <div class="error text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    {{-- <div class="form-row"> --}}
                        <div class="form-group col-md-6">
                            <label for="status">Status</label>
                            <select type="text" class="form-control" id="status" name="status">
                                <option value="1" {{$rule->status == 1 ? 'selected':'' }}>Enable</option>
                                <option value="0" {{$rule->status == 0 ? 'selected':'' }}>Disable</option>
                            </select>
                        </div>
                    {{-- </div> --}}
                </div>
                    <div class="mb-4">
                        <label for="rule">Rule Page Design</label>
                        <textarea class="form-control" id="rule" name="rule" value="{{$rule->terms_conditions}}">{{$rule->terms_conditions}}</textarea>
                    </div>
                    @error('rule')
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
        .create( document.querySelector(  '#rule' ), {
        ckfinder : {
            uploadUrl: "{{ route('rule.upload',['_token'=>csrf_token()]) }}",
        },
        } )
        .then( newEditor => {
        editor = newEditor;
        } )
        .catch( error => {
            console.error( error );
        } );
  </script>
    <script>
        $(document).ready(function() {
            $(document).on('change', '#status', function() {
                var value = $('#status').val();
                var rule_id = $('#rule_id').val();
                // alert('Selected value: ' + value);
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: "{{route('rule.activedeactive')}}",
                    type: "POST",
                    data: {
                        value:value,
                        rule_id:rule_id
                    },
                    success: function(data) {
                        if(data.status == 'success'){
                            new PNotify({
                                title: 'Success',
                                text: 'Status Update',
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