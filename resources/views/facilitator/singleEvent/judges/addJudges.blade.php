<!-- Button trigger modal -->

<button type="button" class="btn btn-white" data-bs-toggle="modal" data-bs-target="#addJudges">
    New judge
  </button>

  <!-- Modal -->
  <div class="modal fade" id="addJudges" tabindex="-1" aria-labelledby="addJudgesLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addJudgesLabel">Judge number {{ $judges->count() > 0 ? $judges->last()->judgeNum + 1:1}}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form method="post" action="{{ route('judges.create')}}">
            @csrf
            @method('post')
        <div class="modal-body">

                <div class="mb-3">
                    <label for="name" class="form-label">Judge name</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter name here" name="name" required>
                  </div>

                  <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <label class="input-group-text" for="inputGroupSelect01" style="min-width: 120px;">Options</label>
                    </div>
                    <select class="custom-select" id="inputGroupSelect01" style="flex: 1;" name="category">
                        <option selected>Choose...</option>
                        <option value="Preliminary">Preliminary</option>
                        <option value="Gown">Gown</option>
                        <option value="Final">Final</option>
                    </select>
                </div>


                  <input type="hidden" class="form-control"  name="judgeNum" value="{{ $judges->count() > 0 ? $judges->last()->judgeNum + 1:1}}">


                  <input type="hidden" class="form-control"  name="eventID" value="{{$event->id}}">

        </div>
        <div class="modal-footer">
            <input type="submit" class="btn btn-primary" value="Submit" >
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </form>
      </div>
    </div>
</div>
