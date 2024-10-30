<!-- Title -->
<div class="col-md-2 form-group">
    <label>Title</label>
    <input type="text" class="form-control" id="search-title">
</div>

<!-- Category -->
<div class="col-md-2 form-group">
    <label>Category</label>
    <select class="form-control" id="search-category">
        <option value="">All</option>
        @foreach( $complaint_category as $category )
        <option value="{{ $category['key'] }}">{{ $category['label'] }}</option>
        @endforeach
    </select>
</div>

<!-- Priority -->
<div class="col-md-2 form-group">
    <label>Priority</label>
    <select class="form-control" id="search-priority">
        <option value="">All</option>
        @foreach( $complaint_priority as $priority )
        <option value="{{ $priority['key'] }}">{{ $priority['label'] }}</option>
        @endforeach
    </select>
</div>

<!-- Status -->
<div class="col-md-2 form-group">
    <label>Status</label>
    <select class="form-control" id="search-status">
        <option value="">All</option>
        @foreach( $complaint_status as $status )
        <option value="{{ $status['key'] }}">{{ $status['label'] }}</option>
        @endforeach
    </select>
</div>

<!-- Submission Date -->
<div class="col-md-2 form-group">
    <label>Submission Date</label>
    <input type="date" class="form-control" id="search-submission_date">
</div>

<!-- Created Date -->
<div class="col-md-2 form-group">
    <label>Created Date</label>
    <input type="date" class="form-control" id="search-created_date">
</div>

<div class="col-md-12 text-right">
    <button type="button" onclick="doSearch(this)" class="btn btn-sm btn-success">
        <i class="fas fa-search"></i>
        Search
    </button>
    <button type="button" onclick="clearSearch(this)" class="btn btn-sm btn-danger">
        <i class="fas fa-sync"></i>
        Clear
    </button>
</div>
