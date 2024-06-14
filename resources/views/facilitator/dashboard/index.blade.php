@extends('layout.layout')

@section('content')

   @if ($events->count() > 0)
   <div class="indexCont rounded-3 px-4 pt-4">

    @if (session('loggedIn'))
    <div class="alert alert-success" role="alert">
        {{ session('loggedIn') }}
      </div>
    @endif

    @if (session('eventDeleted'))
    <div class="alert alert-success" role="alert">
        {{ session('eventDeleted') }}
      </div>
    @endif
    @if (session('eventUpdated'))
    <div class="alert alert-success" role="alert">
        {{ session('eventUpdated') }}
      </div>
    @endif

    @include('facilitator.dashboard.addEvent')
    <table class="table">
        <thead>
            <tr>
                <th>Event</th>
                <th>Location</th>
                <th>Preliminary (Date)</th>
                <th>Preliminary (Time)</th>
                <th>Semi/final (Date)</th>
                <th>Semi/final (Time)</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
           @foreach ($events as $event)
           <tr>
            <td>{{$event->title}}</td>
            <td>{{$event->location}}</td>
            <td>{{$event->preliminaryDate}}</td>
            <td>{{$event->preliminaryStartTime}}</td>
            <td>{{$event->finalDate}}</td>
            <td>{{$event->finalStartTime}}</td>
            <td class="d-flex gap-2">



                @include('facilitator.dashboard.editEvent')

                    <div>
                        <a href="{{ route('eventShow.show', [
                        'event' => $event->id
                    ])}}" class="btn btn-success"><i class="fa fa-eye"></i></a>
                    </div>




                    <!-- Button trigger modal -->


                    <div>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#event{{ $event->id }}"><i class="fa fa-trash"></i></button>
                    </div>


  <form action="{{route('event.delete', [
    'event' => $event->id
])}}" method="POST">
    @csrf
    @method('delete')


    <div class="modal fade" id="event{{ $event->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Event</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
              <p>Are you sure to delete event <span class="text-bold">{{ $event->title}}</span> ?</p>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-danger">Yes</button>
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
            </div>
          </div>
        </div>
      </div>
</form>




                    




               

            </td>
           
        </tr>
           @endforeach
          
        </tbody>
      </table>
</div>
   @else
       
   @include('facilitator.dashboard.addEvent')
   
   @endif

    
@endsection


<style>
.indexCont{
    width: 100%;
}
    </style>