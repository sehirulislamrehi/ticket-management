@extends("backend.template.layout")

@section('per_page_css')
<link href="{{ asset('backend/css/datatable/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ asset('backend/css/datatable/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
<style>
    #datatable_filter {
        display: none;
    }
</style>
@endsection

@section('body-content')
<div class="br-mainpanel">
    <div class="br-pageheader">
        <nav class="breadcrumb pd-0 mg-0 tx-12">
            <a class="breadcrumb-item" href="{{ route('dashboard') }}">Dashboard</a>
            <a class="breadcrumb-item active" href="#">All Complaint</a>
        </nav>
    </div>

    <div class="br-pagebody">
        <div class="card card-primary mb-3">
            <div class="card-body">
                <div class="row">
                    @include("backend.modules.complaint_module.complaint.widgets.search")
                </div>
            </div>
        </div>
        <div class="card card-primary">
            <div class="card-header">
                @if( can("add_complaint") )
                <div class="row">
                    <div class="col-md-12 text-right">
                        <button type="button" data-content="{{ route('complaint.add.modal') }}" data-target="#myModal" class="btn btn-outline-dark" data-toggle="modal">
                            Add
                        </button>
                    </div>
                </div>
                @endif
            </div>
            <div class="card-body table-responsive">
                <div class="row">
                    <div class="col-md-12 ">
                        <table class="table display responsive nowrap no-footer dtr-inline collapsed custom-datatable" id="datatable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Created By</th>
                                    <th>Submission Date</th>
                                    <th>Resolved At</th>
                                    <th>Time Taken</th>
                                    <th>Created At</th>
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
                url: "{{ route('complaint.data') }}",
                type: 'GET',
                data: function(data) {
                    data.title = $('#search-title').val();
                    data.category = $('#search-category').val();
                    data.priority = $('#search-priority').val();
                    data.status = $('#search-status').val();
                    data.submission_date = $('#search-submission_date').val();
                    data.created_at = $('#search-created_date').val();
                }
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
                    data: 'title',
                    name: 'title',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'category',
                    name: 'category',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'priority',
                    name: 'priority',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'status',
                    name: 'status',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'created_by',
                    name: 'created_by',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'submission_date',
                    name: 'submission_date',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'resolved_at',
                    name: 'resolved_at',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'time_taken',
                    name: 'time_taken',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'created_at',
                    name: 'created_at',
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
<script>
    function doSearch() {
        $(".custom-datatable").DataTable().ajax.reload();
    }
</script>
<script>
    function clearSearch() {
        $('input').val('');
        $('select').val('').trigger('update');
        doSearch();
    }
</script>
@endsection