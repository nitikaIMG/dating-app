@extends('layouts.app')
@section('content')
    @push('custom-styles')
        <style>
            
            /* Styles for the toggle switch */
            .switch {
            position: relative;
            display: inline-block;
            width: 40px;
            height: 20px;
            }

            .switch input {
            display: none;
            }

            .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: 0.4s;
            }

            .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            transition: 0.4s;
            }

            input:checked + .slider {
            background-color: #4caf50;
            }

            input:checked + .slider:before {
            transform: translateX(20px);
            }

            /* Rounded sliders */
            .slider.round {
            border-radius: 34px;
            }

            .slider.round:before {
            border-radius: 50%;
            }

        </style>
    @endpush

     <!-- Start Breadcrumbbar -->                    
     <div class="breadcrumbbar">
        <div class="row align-items-center">
            <div class="col-md-8 col-lg-8">
                <h4 class="page-title">Personality Type</h4>
                <div class="breadcrumb-list">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Basics</a></li>
                        <li class="breadcrumb-item active" aria-current="page">personality</li>
                    </ol>
                </div>
            </div>
            <div class="col-md-4 col-lg-4">
                <div class="widgetbar">
                    <a href="{{route('personality.create')}}">
                        <button class="btn btn-primary"><i class="ri-add-line align-middle mr-2"></i>ADD</button>
                    </a>
                </div>                        
            </div>
        </div>          
    </div>
    <!-- End Breadcrumbbar -->
    <!-- Start Contentbar -->    
    <div class="contentbar">                
        <!-- Start row -->
        <div class="row">
            <!-- Start col -->
            <div class="col-lg-12">
                <div class="card m-b-30">
                    <div class="card-header">
                        {{-- <h5 class="card-title">Edit with button</h5> --}}
                    </div>
                    <div class="card-body">
                        {{-- <h6 class="card-subtitle">Export data to Copy, CSV, Excel & Note.</h6> --}}
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered datatable" id="edit-btn">
                                <thead>
                                  <tr>
                                    <th>No</th>
                                    <th>Name</th>
                                    {{-- <th>Gender</th>
                                    <th>Age</th>
                                    <th>Phone</th>--}}
                                    <th>Status</th>
                                  </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!-- End row -->
    </div>
    <!-- End Contentbar -->
@endsection
@push('custom-scripts')
<script type="text/javascript">
    $(function () {
      
      var table = $('.datatable').DataTable({
          processing: true,
          serverSide: true,
          ajax: "{{ route('personality.index') }}",
          columns: [
              {data: 'DT_RowIndex', name: 'DT_RowIndex'},
              {data: 'name', name: 'name'},
            //   {data: 'gender', name: 'gender'},
            //   {data: 'age', name: 'age'},
            //   {data: 'phone', name: 'phone'},
              {data: 'status', name: 'status'},
            //   {data: 'dob', name: 'dob'},
              {
                  data: 'action', 
                  name: 'action', 
                  orderable: true, 
                  searchable: true
              },
          ]
      });
      
    });
  </script>

<script>
    function  updatestatus(id){
        (new PNotify({
            title: 'Confirmation Needed',
            text: 'Are you sure?',
            icon: 'glyphicon glyphicon-question-sign',
            hide: false,
            confirm: {
                confirm: true
            },
            buttons: {
                closer: false,
                sticker: false
            },
            history: {
                history: false
            },
            addclass: 'stack-modal',
            stack: {
                'dir1': 'down',
                'dir2': 'right',
                'modal': true
            }
        })).get().on('pnotify.confirm', function() {
           
            $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{route('personalitystatus')}}',
            method: 'POST',
            data: { id: id },
            success: function (response) {
                if(response.status == 'success')
                {
                    new PNotify({
                        title: 'Success',
                        text: 'Account Update',
                        type: 'success'
                    });
                }
            },
            error: function (error) {
                // Handle error if needed
            }
        });

        }).on('pnotify.cancel', function() {
        });      
    }
</script>

<script>
    function  deleterecord(id){
        (new PNotify({
            title: 'Confirmation Needed',
            text: 'Are you sure for delete ?',
            icon: 'glyphicon glyphicon-question-sign',
            hide: false,
            confirm: {
                confirm: true
            },
            buttons: {
                closer: false,
                sticker: false
            },
            history: {
                history: false
            },
            addclass: 'stack-modal',
            stack: {
                'dir1': 'down',
                'dir2': 'right',
                'modal': true
            }
        })).get().on('pnotify.confirm', function() {
           
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                url: '{{route("personality.deleterecord")}}',
                data: {id:id},
                method: 'DELETE',
                success: function (response) {
                    if(response.status == 'success')
                    {
                        new PNotify({
                            title: 'Success',
                            text: 'Account Delete',
                            type: 'success'
                        });
                        setTimeout(function(){// wait for 5 secs(2)
                            location.reload(); // then reload the page.(3)
                        }, 1000);
                    }
                },
                error: function (error) {
                    // Handle error if needed
                }
            });

        }).on('pnotify.cancel', function() {
        });      
    }
</script>
@endpush