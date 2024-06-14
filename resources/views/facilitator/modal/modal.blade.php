

<button type="button" class="btn btn-primary float-end mb-3" data-bs-toggle="modal" data-bs-target="#addEvent">
    Create new event
  </button>
  
  <div class="modal fade" id="addEvent" tabindex="-1" aria-labelledby="addEventLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addEventLabel">Add a new event</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <form method="post" action="{{ route('event.create')}}">
            @csrf
            @method('post')
        <div class="modal-body">
           
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" placeholder="Enter title here" name="title">
                  </div>
                <div class="mb-3">
                    <label for="Location" class="form-label">Location</label>
                    <input type="text" class="form-control" id="Location" placeholder="Enter location here" name="location">
                  </div>
                 
                <div class="mb-3">
                    <label for="date" class="form-label">Date</label>
                    <input type="date" class="form-control" id="date" name="date">
                  </div>

                <div class="mb-3">
                    <label for="startTime" class="form-label">Start time</label>
                    <input type="time" class="form-control" id="startTime" name="startTime">
                  </div>
                 
          
        </div>
        <div class="modal-footer">
            <input type="submit" class="btn btn-primary" value="Submit" >
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
    </form>


      </div>
    </div>

</div>