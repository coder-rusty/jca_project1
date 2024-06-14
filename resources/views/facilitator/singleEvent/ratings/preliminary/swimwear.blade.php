@extends('layout.eventLayout')

@section('eventContent')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Swimwear score result</h3>
        </div>

        <div class="card-body p-0">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th></th>
                        @foreach ($judges as $judge)
                            <th>{{ $judge->name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th style="width: 240px">Contestant</th>
                        @foreach ($judges as $judge)
                            <th>Total</th>
                        @endforeach
                        <th>Total</th>
                        <th>Rank</th>
                    </tr>
                    @foreach ($contestants as $contestant)
                        <tr>
                            <th>{{ $contestant->contestantNum }}.{{ $contestant->name }}</th>
                            @foreach ($contestant->ratings as $rating)
                                <td>{{ $rating->suitability + $rating->projection }}</td>
                            @endforeach
                            
                            <td>
                                {{$contestant->total}}
                            </td>
                            <td>{{$contestant->rank}}</td> 
                        </tr>
                    @endforeach
                </tbody>
                
            </table>
        </div>

    </div>
@endsection
