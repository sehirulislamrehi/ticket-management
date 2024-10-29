<div class="modal-header pd-y-20 pd-x-25">
    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Edit "{{ $complaint->title }}"</h6>
</div>
<div class="modal-body pd-25">
    <form action="{{ route('complaint.edit', encrypt($complaint->id)) }}" method="post" class="ajax-form">
        @csrf
        <div class="row">

            @if($image_link)
            <div class="col-md-12 form-group">
                <img src="{{$image_link}}" class="img-fluid" alt="">
            </div>
            @endif

            <!-- Title -->
            <div class="col-md-12 form-group">
                <label>Title</label><label class="required">*</label>
                <input class="form-control" type="text" name="title" value="{{ $complaint->title }}">
            </div>

            <!-- Description -->
            <div class="col-md-12 form-group">
                <label>Description</label><label class="required">*</label>
                <textarea name="description" rows="3" class="form-control">{{ $complaint->description }}</textarea>
            </div>

            <!-- Category -->
            <div class="col-md-6 col-12 form-group">
                <label>Category</label><label class="required">*</label>
                <select class="form-control" name="category">
                    @foreach( $complaint_category as $category )
                    <option value="{{ $category['key'] }}" @if( $complaint->category == $category["key"] ) selected @endif >{{ $category['label'] }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Priority -->
            <div class="col-md-6 col-12 form-group">
                <label>Priority</label><label class="required">*</label>
                <select class="form-control" name="priority">
                    @foreach( $complaint_priority as $priority )
                    <option value="{{ $priority['key'] }}" @if( $complaint->priority == $priority["key"] ) selected @endif>{{ $priority['label'] }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Status -->
            <div class="col-md-6 col-12 form-group">
                <label>Status</label><label class="required">*</label>
                <select class="form-control" name="status">
                    @foreach( $complaint_status as $status )
                    <option value="{{ $status['key'] }}" @if( $complaint->status == $status["key"] ) selected @endif>{{ $status['label'] }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Submission Date -->
            <div class="col-md-6 col-12 form-group">
                <label>Submission Date</label><label class="required">*</label>
                <input class="form-control" type="date" name="submission_date" id="submission_date" onfocus="disablePastDates()" value="{{ $complaint->submission_date }}">
            </div>

            <!-- Image -->
            <div class="col-md-12 form-group">
                <label>Image <small>(Max file size: 1mb. Allowed type: .jpg, .jpeg, .png, .webp)</small></label>
                <input class="form-control-file" type="file" name="image">
            </div>
            <div class="col-md-12 form-group">
                <label><small>Please check if you want to remove the attachment</small></label>
                <input class="form-control-check" type="checkbox" value="1" name="is_attachment_remove">
            </div>

        </div>
        <div class="row">
            <div class="col-md-12 form-layout-footer">
                <button type="submit" class="btn btn-info">Update</button>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">Close</button>
</div>


<script>
    function disablePastDates() {
        var today = new Date();
        var dd = String(today.getDate()).padStart(2, '0');
        var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
        var yyyy = today.getFullYear();

        today = yyyy + '-' + mm + '-' + dd;
        document.getElementById("submission_date").setAttribute("min", today);
    }
</script>
<link href="{{ asset('backend/css/chosen/choosen.min.css') }}" rel="stylesheet">
<script src="{{ asset('backend/js/chosen/choosen.min.js') }}"></script>
<script>
    $(document).ready(function domReady() {
        $(".chosen").chosen();
    });
</script>