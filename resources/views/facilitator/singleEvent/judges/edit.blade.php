<button type="button" class="btn btn-primary float-end btn btn-sm" data-bs-toggle="modal" data-bs-target="#editEvent{{$judge->id}}">
    <i class="fa fa-edit"></i>
  </button>

  <!-- Modal -->
  <div class="modal fade" id="editEvent{{$judge->id}}" tabindex="-1" aria-labelledby="addJudgesLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addJudgesLabel">{{ $judge->accessCode }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form method="post" action="{{ route('judge.edit', [
            'event' => $event->id,
            'judge' => $judge->id
        ])}}">
            @csrf
            @method('put')
        <div class="modal-body">

                <div class="mb-3">
                    <label for="name" class="form-label">Judge name</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter name here" name="name" value="{{$judge->name}}" required>
                  </div>

                <div class="mb-3">
                    <label for="judgeNum" class="form-label">Judge number</label>
                    <input type="text" class="form-control" id="name" placeholder="Change judge number" name="judgeNum" value="{{$judge->judgeNum}}" required>
                </div>

                <input type="hidden" name="accessCode" value="{{$judge->accessCode}}">

        </div>
        <div class="modal-footer">
            <input type="submit" class="btn btn-primary" value="Submit" >
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </form>
      </div>
    </div>
</div>
