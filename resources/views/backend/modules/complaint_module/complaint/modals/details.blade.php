<style>
    .problem-item {
        background-color: mediumpurple;
        padding: 2px 15px;
        border-radius: 10px;
        font-size: 14px;
    }
</style>
<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">{{ $complaint->title }}</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">

    <div class="row">

        <!-- Created By -->
        <div class="col-12 col-md-12 mb-3 shadow-xl">
            <div class="card h-100">
                <div class="card-header p-3">
                    <h5 class="mb-0">Created By</h5>
                </div>
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-3">
                                <label class="form-label">Name:</label>
                                <p>{{$complaint->created_user->name}}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email:</label>
                                <p>{{$complaint->created_user->email}}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Phone:</label>
                                <p>{{$complaint->created_user->phone}}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-12">
            <div class="card mb-4 p-3 shadow-md bg-gradient-lightblue">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-md-6">
                            <h5 class="mb-3">Attachment</h5>
                            <div class="problem-list">
                                <img src="{{$image_link}}" class="img-fluid" alt="">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2"><strong>Category:</strong> {{$category['label']}}</p>
                            <p class="mb-2"><strong>Priority:</strong> {{$priority['label']}}</p>
                            <p class="mb-2"><strong>Status:</strong> {{$status['label']}}</p>
                            <p class="mb-2"><strong>Created Date:</strong> {{$complaint->created_at->format("Y-m-d H:i:s")}}</p>
                            <p class="mb-2"><strong>Submission Date:</strong> {{$complaint->submission_date}}</p>
                            <p class="mb-2"><strong>Time Taken (H:M):</strong> {{$time_taken}}</p>
                            <p class="mb-2"><strong>Day Taken :</strong> {{$complaint->day_taken}}</p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <p class="mb-2"><strong>Description:</strong></p>
                            <div class="alert alert-dark" role="alert">
                            {{$complaint->description}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>