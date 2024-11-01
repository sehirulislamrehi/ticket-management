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
    <nav class="mb-3">
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-general-tab" data-toggle="tab" href="#nav-general" role="tab" aria-controls="nav-general" aria-selected="true">General</a>
            <a class="nav-item nav-link" id="nav-comments-tab" data-toggle="tab" href="#nav-comments" role="tab" aria-controls="nav-comments" aria-selected="false">Comments</a>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane fade show active" id="nav-general" role="tabpanel" aria-labelledby="nav-general-tab">
            <div class="row">

                <!-- left part start -->
                <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 col-12 mb-3 shadow-xl">
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
                <!-- left part end -->

                <!-- right part start -->
                <div class="col-xl-9 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="card mb-4 p-3 shadow-md bg-gradient-lightblue">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5 class="mb-3">Attachment</h5>
                                    <div class="problem-list">
                                        @if($image_link)
                                        <img src="{{$image_link}}" class="img-fluid" alt="">
                                        @else
                                        <p class="badge badge-warning">No image uploaded</p>
                                        @endif
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
                <!-- right part end -->

            </div>
        </div>
        <div class="tab-pane fade" id="nav-comments" role="tabpanel" aria-labelledby="nav-comments-tab">
            <div class="row">
                <div class="col-xl-3 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="event-modal">
                        <div class="comments-section">
                            <textarea id="new-comment" placeholder="Write comment..."></textarea>
                            <button id="add-comment-btn" onclick="addComment(this)">➤</button>
                        </div>
                    </div>
                </div>
                <div class="col-xl-9 col-lg-12 col-md-12 col-sm-12 col-12">
                    <div class="event-modal right">
                        <div class="comments-section">
                            <div id="comments">
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

<script>
    'use strict';

    var id = "{{ $complaint->id }}";
    var commentsSection = document.getElementById('comments');
    var newCommentInput = document.getElementById('new-comment');
    var addCommentBtn = document.getElementById('add-comment-btn');
    var completeBtn = document.getElementById('complete-btn');
    var deleteBtn = document.getElementById('delete-btn');
    var auth = @json($auth);

    function addComment(e) {
        const commentText = newCommentInput.value.trim();
        if (commentText) {
            id = "{{ $complaint->id }}";
            let url = "{{ route('complaint.comment.add',':id') }}";
            url = url.replace(':id',id)
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            let formData = new FormData();
            formData.append('comment',commentText)

            fetch(url,{
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            })
            .then( response => response.json() )
            .then( response => {
                if(response.status == "success"){
                    createCommentDom(response.data, auth)
                }
            })
            .catch( response => {
                console.log(response)
            })

        }
    }

    // fetch comments
    function fetch_comments(id){
        let url = "{{ route('complaint.comments',':id') }}";
        url = url.replace(':id',id)
        fetch(url,{
            method: 'GET',
        })
        .then( response => response.json() )
        .then( response => {

            response.data.map((value, key) => {
                createCommentDom(value, auth)
            })

        })
        .catch( response => {
            console.log(response)
        })
    }
    fetch_comments(id);

    function createCommentDom(data, auth){
        let commentDiv = document.createElement('div');
        commentDiv.classList.add('comment');
        commentDiv.innerHTML = `
            <div class="comment-content">
                <p><string>${data.user.name}</strong></p>
                <p id="comment-box-${data.id}">${data.comment}</p>
                <div class="comment-actions">
                    ${(auth.id == data.user.id) ? `
                    <button type="button" onclick="editComment(this, ${data.id})">Edit</button>
                    <button type="button" onclick="deleteComment(this, ${data.id})">Delete</button>
                    ` : ``}
                </div>
            </div>
        `;
        commentsSection.prepend(commentDiv);
        newCommentInput.value = '';
    }

    // Delete event
    function deleteComment(e, id){
        if (confirm('Are you sure you want to delete this event?')) {
            let url = "{{ route('complaint.comment.delete',':id') }}";
            url = url.replace(':id',id)

            fetch(url,{
                method: 'GET',
            })
            .then( response => response.json() )
            .then( response => {
                if(response.status == "success"){
                    e.parentElement.parentElement.parentElement.remove()
                }
            })
            .catch( response => {
                console.log(response)
            })
        }
    }

    function editComment(e, id) {
        let commentBox = document.getElementById(`comment-box-${id}`);
        const commentText = commentBox.innerHTML;
        const newCommentText = prompt('Edit your comment:', commentText);
        if (newCommentText !== null) {
            let url = "{{ route('complaint.comment.edit',':id') }}";
            url = url.replace(':id',id)
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            let formData = new FormData();
            formData.append('comment',newCommentText)

            fetch(url,{
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                body: formData
            })
            .then( response => response.json() )
            .then( response => {
                if(response.status == "success"){
                    commentBox.innerHTML = newCommentText
                }
            })
            .catch( response => {
                console.log(response)
            })
        }
    }
</script>