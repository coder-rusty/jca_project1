@extends('layout.judgesLayout')

@section('judgesContent')
@if(session('judge_name'))
    <div class="container">
        <h4>List of contestants</h4>

        <table class="table">
            <thead>
              <tr>
                <th scope="col">Number</th>
                <th scope="col">Photo</th>
                <th scope="col">Name</th>
                <th scope="col">Address</th>
              </tr>
            </thead>
            <tbody>

                @foreach ($contestants as $contestant)
                <tr>
                    <th>{{ $contestant->contestantNum }}</th>
                    <th>{{ $contestant->photo }}</th>
                    <th>{{ $contestant->name }}</th>
                    <th>{{ $contestant->address }}</th>
                  </tr>
                @endforeach

            </tbody>
          </table>

    </div>
@endif

@if(session('error'))
    <div class="container mt-2">
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    </div>
@endif
@endsection
