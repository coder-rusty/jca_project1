<!-- Button trigger modal -->

<button type="button" class="btn btn-primary float-end mb-3" data-bs-toggle="modal"  data-bs-target="#editContestant{{$contestant->id}}">
    <i class="fa fa-edit"></i>
  </button>

  <!-- Modal -->
  <div class="modal fade" id="editContestant{{$contestant->id}}" tabindex="-1" aria-labelledby="editContestantLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editContestantLabel"> Edit contestant</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form method="post" action="{{ route('contestant.update', [
            'contestantID' => $contestant->id
        ])}}" enctype="multipart/form-data">
            @csrf
            @method('put')
        <div class="modal-body">

                <div class="mb-3">
                    <label for="name" class="form-label">Contestant name</label>
                    <input type="text" class="form-control" id="name" placeholder="Enter name here" name="name" value="{{$contestant->name}}">
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" placeholder="Enter address here" name="address" value="{{$contestant->address}}">
                </div>

                <div class="mb-3">
                    <label for="photo" class="form-label">Choose new photo</label>
                    <input type="file" class="form-control" id="photo" name="photo" required>
                </div>

                <div class="mb-3">
                    <label for="contestantNum" class="form-label">Number</label>
                    <input type="number" class="form-control" id="contestantNum" placeholder="Enter contestantNum here" name="contestantNum" value="{{$contestant->contestantNum}}">
                </div>

                <div class="mb-3">
                  <label for="age" class="form-label">Age</label>
                  <input type="number" class="form-control" id="age" placeholder="Enter contestantNum here" name="age" value="{{$contestant->age}}">
              </div>

              <div class="mb-3">
                  <label for="chest" class="form-label">Chest</label>
                  <input type="number" class="form-control" id="chest" placeholder="Enter contestantNum here" name="chest"  value="{{$contestant->chest}}">
              </div>

              <div class="mb-3">
                  <label for="waist" class="form-label">Waist</label>
                  <input type="number" class="form-control" id="waist" placeholder="Enter contestantNum here" name="waist" value="{{$contestant->waist}}">
              </div>

              <div class="mb-3">
                  <label for="height" class="form-label">Height</label>
                  <input type="number" class="form-control" id="height" placeholder="Enter contestantNum here" name="height" value="{{$contestant->height}}">
              </div>

              <div class="mb-3">
                  <label for="weight" class="form-label">Weight</label>
                  <input type="number" class="form-control" id="weight" placeholder="Enter contestantNum here" name="weight" value="{{$contestant->weight}}">
              </div>
              <div class="mb-3">
                  <label for="hips" class="form-label">Hips</label>
                  <input type="number" class="form-control" id="hips" placeholder="Enter contestantNum here" name="hips" value="{{$contestant->hips}}">
              </div>

                  <input type="hidden" name="eventID" value="{{$event->id}}">

        </div>
        <div class="modal-footer">
            <input type="submit" class="btn btn-primary" value="Submit" >
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </form>


      </div>
    </div>

</div>
