<div class="modal-header pd-y-20 pd-x-25">
     <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Delete Notification '{{$title}}'</h6>
</div>

<div class="modal-footer">
     <form action="{{ route('notification.delete', $notification->id) }}" method="post" class="ajax-form">
          @csrf
          <button type="submit" class="btn btn-danger tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium">Yes</button>
     </form>
     <button type="button" class="btn btn-success tx-11 tx-uppercase pd-y-12 pd-x-25 tx-mont tx-medium" data-dismiss="modal">No</button>
</div>