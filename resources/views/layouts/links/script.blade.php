<script src="{{asset('public/assets/js/jquery.min.js')}}"></script>
<script src="{{asset('public/assets/js/popper.min.js')}}"></script>
<script src="{{asset('public/assets/js/bootstrap.min.js')}}"></script>
<script src="{{asset('public/assets/js/modernizr.min.js')}}"></script>
<script src="{{asset('public/assets/js/detect.js')}}"></script>
<script src="{{asset('public/assets/js/jquery.slimscroll.js')}}"></script>
<script src="{{asset('public/assets/js/vertical-menu.js')}}"></script>
<!-- Switchery js -->
<script src="{{asset('public/assets/plugins/switchery/switchery.min.js')}}"></script>
<script src="{{asset('public/assets/js/custom/custom-switchery.js')}}"></script>
<!-- Apex js -->
<script src="{{asset('public/assets/plugins/apexcharts/apexcharts.min.js')}}"></script>
<script src="{{asset('public/assets/plugins/apexcharts/irregular-data-series.js')}}"></script>
<!-- Slick js -->
<script src="{{asset('public/assets/plugins/slick/slick.min.js')}}"></script>
<!-- Custom Dashboard js -->
<script src="{{asset('public/assets/js/custom/custom-dashboard.js')}}"></script>
<!-- Core js -->
<script src="{{asset('public/assets/js/core.js')}}"></script>
<!-- End js -->
<!-- yajra datatabels-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
{{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script> --}}
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>


<!-- Tabledit js -->
<script src="{{asset('public/assets/plugins/tabledit/jquery.tabledit.js')}}"></script>     
<script src="{{asset('public/assets/js/custom/custom-table-editable.js')}}"></script>    

<!-- Pnotify js -->
<script src="{{asset('public/assets/plugins/pnotify/js/pnotify.custom.min.js')}}"></script>
<script src="{{asset('public/assets/js/custom/custom-pnotify.js')}}"></script>

  <!-- Datepicker JS -->
  <script src="{{asset('public/assets/plugins/datepicker/datepicker.min.js')}}"></script>
  <script src="{{asset('public/assets/plugins/datepicker/i18n/datepicker.en.js')}}"></script>
  <script src="{{asset('public/assets/js/custom/custom-form-datepicker.js')}}"></script>

  <script src="{{asset('public/assets/plugins/dropzone/dist/dropzone.js')}}"></script>
<script>
/* -- Switchery - Small Switches -- */
var primary_small = document.querySelector('.js-switch-primary-small');
var switchery = new Switchery(primary_small, { color: '#1ba4fd', size: 'small' });
var secondary_small = document.querySelector('.js-switch-secondary-small');
var switchery = new Switchery(secondary_small, { color: '#b8d1e1', size: 'small' });
var success_small = document.querySelector('.js-switch-success-small');
var switchery = new Switchery(success_small, { color: '#3dcd8b', size: 'small' });
var danger_small = document.querySelector('.js-switch-danger-small');
var switchery = new Switchery(danger_small, { color: '#e75c62', size: 'small' });
var warning_small = document.querySelector('.js-switch-warning-small');
var switchery = new Switchery(warning_small, { color: '#ffb129', size: 'small' });      
var info_small = document.querySelector('.js-switch-info-small');
var switchery = new Switchery(info_small, { color: '#67d1e1', size: 'small' });
var light_small = document.querySelector('.js-switch-light-small');
var switchery = new Switchery(light_small, { color: '#ebebf6', size: 'small' });
var dark_small = document.querySelector('.js-switch-dark-small');
var switchery = new Switchery(dark_small, { color: '#181a39', size: 'small' });
</script>
<!-- Alert PNOtify -->
<script>
@if (Session::has('success'))
    new PNotify({
        title: 'Success',
        text: '{{ session('success') }}',
        type: 'success'
    });
@endif
@if (Session::has('warning'))
    new PNotify({
        title: 'Warning',
        text: '{{ session('warning') }}',
        type: 'warning'
    });
@endif
@if (Session::has('error'))
    new PNotify({
        title: 'Error',
        text: '{{ session('error') }}',
        type: 'error'
    });
@endif
</script>

<!-- Ck Editor 5-->
<script src="https://cdn.ckbox.io/ckbox/latest/ckbox.js"></script>
<script src="{{asset('public/assets/ckeditor/build/ckeditor.js')}}"></script>