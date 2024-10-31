@extends("backend.template.layout")

@section('per_page_css')
<link href="{{ asset('backend/css/datatable/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('backend/css/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<style>
</style>
@endsection

@section('body-content')
<div class="br-mainpanel">
     <div class="br-pageheader">
          <nav class="breadcrumb pd-0 mg-0 tx-12">
               <a class="breadcrumb-item" href="{{ route('dashboard') }}">Dashboard</a>
               <a class="breadcrumb-item active" href="#">All Notification</a>
          </nav>
     </div>


     <div class="br-pagebody">
          <div class="card card-primary">
               <div class="card-body table-responsive">
                    <div class="row">
                         <div class="col-md-12 ">
                              <table class="table display responsive nowrap no-footer dtr-inline collapsed custom-datatable" id="datatable">
                                   <thead>
                                        <tr>
                                             <th>ID</th>
                                             <th>Message</th>
                                             <th>Viewed</th>
                                             <th>Action</th>
                                        </tr>
                                   </thead>
                              </table>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>


@endsection

@section('per_page_js')

<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<script src="{{ asset('backend/js/custom-script.min.js') }}"></script>
<script src="{{ asset('backend/js/datatable/jquery.validate.js') }}"></script>
<script src="{{ asset('backend/js/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('backend/js/datatable/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{  asset('backend/js/ajax_form_submit.js') }}"></script>

<script>
     $(function() {
          $('.custom-datatable').DataTable({
               processing: true,
               serverSide: true,
               pageLength: 10,
               ajax: {
                    url: "{{ route('notification.data') }}",
                    type: 'GET',
               },
               order: [
                    [0, 'ASC']
               ],
               columns: [{
                         data: 'DT_RowIndex',
                         name: 'DT_RowIndex',
                         orderable: false,
                         searchable: false
                    },
                    {
                         data: 'message',
                         name: 'message',
                         orderable: false,
                         searchable: false
                    },
                    {
                         data: 'is_viewed',
                         name: 'is_viewed',
                         orderable: false,
                         searchable: false
                    },
                    {
                         data: 'action',
                         name: 'action',
                         orderable: false,
                         searchable: false
                    },
               ]
          });
     });
</script>

@endsection