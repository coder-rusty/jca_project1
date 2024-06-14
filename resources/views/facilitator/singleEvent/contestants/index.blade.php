


@extends('layout.eventLayout')

@section('eventContent')
<div class="d-flex w-100 subHeader">
    <h4>Contestant List</h4>
</div>


@if ($contestants->count() > 0)

<div class="tableContJudges p-3 rounded-3 mt-5">

<div class="indexCont rounded-3 px-2">
   <div class="float-end mb-2">
    <a href="{{ route('contestant.add-new-form', [
        'event' => $event->id
    ])}}" class="btn btn-primary">+</a>
   </div>
    <table class="table">
        <thead>
            <tr>
                <th>Number</th>
                <th>Name</th>
                <th>Address</th>
                <th>Photo</th>
                <th>Age</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
           @foreach ($contestants as $contestant)
           <tr>
                <td>{{$contestant->contestantNum}}</td>
                <td>{{$contestant->name}}</td>
                <td>{{$contestant->address}}</td>
                <td >
                    {{$contestant->photo}}
                    {{-- <img src="{{ url('public/Image/'.$contestant->photo) }}"
                    style="height: 100px; width: 150px;"> --}}
                </td>
                <td >{{$contestant->age}}</td>
                <td class="d-flex gap-2">

                    @include('facilitator.singleEvent.contestants.editContestant')

                    <form method="POST" action="{{ route('contestant.delete', [
                        'contestant' => $contestant->id,
                        'event' => $event->id,
                    ])}}">
                    @csrf
                    @method('delete')
                        <button type="submit" class="btn btn-danger"><i class="fa fa-trash"></i></button>
                    </form>
                </td>
            </tr>
           @endforeach

        </tbody>
    </table>
</div>

</div>
@else
   <div class="container d-flex justify-content-center mt-5">
    @include('facilitator.singleEvent.contestants.addContestant')
   </div>
@endif

@endsection

<style>
    .subHeader{
        border-bottom: 2px solid #2F2F2F;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 51px;
    }
    .tableContJudges{
    border: 1px solid lightgray;
    width: 90%;
    margin: auto;
    }
</style>
