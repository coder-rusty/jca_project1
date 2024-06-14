@extends('layout.judgesLayout')

@section('judgesNavs')
    <div class="d-flex ml-5 gap-5">
        <a href="{{ route('final.index') }}">Gown</a>
        <a href="{{ route('semifinal.index') }}">Semifinal</a>
        <a href="{{ route('finalJudge.index') }}">Final</a>
    </div>
@endsection

@section('judgesCont')
    <form action="{{ url('/semiScore') }}" method="POST" id="addSemi">
        @csrf
        <div class="p-5">
            @if ($ranks > 1)
                <h5 class="text-center">Respond recorded succesfully. Thank you for your participation!</h5>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Semifinal competition rating sheet</h3>
                </div>

                <div class="card-body p-0">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th scope="col">Contestants</th>
                                <th scope="col">Beauty (50%)</th>
                                <th scope="col">Poise and projection (35%)</th>
                                <th scope="col">Projection (15%)</th>
                                <th scope="col">Total</th>
                                @if ($ranks > 1)
                                    <th scope="col">Rank</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($semiContestant as $contestant)
                                <tr>
                                    <th>
                                        <span
                                            style="visibility: hidden">{{ $contestant->id }}</span>{{ $contestant->contestantNum }}.
                                        {{ $contestant->name }}
                                    </th>
                                    <td>
                                        @if ($contestant->beauty > 0)
                                            {{ $contestant->beauty }}
                                        @else
                                            <input type="number" class="form-control w-75 beauty" placeholder="Beauty ...."
                                                min="1" max="50" name="beauty[{{ $contestant->id }}]">
                                        @endif
                                    </td>
                                    <td>
                                        @if ($contestant->poise > 0)
                                            {{ $contestant->poise }}
                                        @else
                                            <input type="number" class="form-control w-75 semiPoise"
                                                placeholder="Poise grace ...." min="1" max="50"
                                                name="semiPoise[{{ $contestant->id }}]">
                                        @endif
                                    </td>
                                    <td>
                                        @if ($contestant->projection > 0)
                                            {{ $contestant->projection }}
                                        @else
                                            <input type="number" class="form-control w-75 semiProjection"
                                                placeholder="Projection ...." min="1" max="50"
                                                name="semiProjection[{{ $contestant->id }}]">
                                        @endif

                                    </td>
                                    <td class="semiTotal">
                                        @if ($contestant->total > 0)
                                            {{ $contestant->total }}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    @if ($ranks > 1)
                                        <td>
                                            {{ $contestant->rank }}
                                        </td>
                                    @endif

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <button type="submit" id="finalSubmitButton" class="btn btn-primary mt-3" disabled>Submit</button>
        </div>
    </form>
@endsection

@section('judgingScript')
    <script type="module">
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.beauty').on('input', function() {
                const row = $(this).closest('tr');
                const beauty = parseInt(row.find('.beauty').val()) || 0;
                if (beauty < 1) {
                    $(this).val('');
                } else if (beauty > 50) {
                    $(this).val(50);
                }
            });
            $('.semiPoise').on('input', function() {
                const row = $(this).closest('tr');
                const beauty = parseInt(row.find('.semiPoise').val()) || 0;
                if (beauty < 1) {
                    $(this).val('');
                } else if (beauty > 35) {
                    $(this).val(35);
                }
            });
            $('.semiProjection').on('input', function() {
                const row = $(this).closest('tr');
                const beauty = parseInt(row.find('.semiProjection').val()) || 0;
                if (beauty < 1) {
                    $(this).val('');
                } else if (beauty > 15) {
                    $(this).val(15);
                }
            });

            $('.beauty, .semiPoise, .semiProjection').on('input', function() {
                const row = $(this).closest('tr');
                const beauty = parseInt(row.find('.beauty').val()) || 0;
                const semiPoise = parseInt(row.find('.semiPoise').val()) || 0;
                const semiProjection = parseInt(row.find('.semiProjection').val()) || 0;
                const total = beauty + semiPoise + semiProjection;
                row.find('.semiTotal').text(total);

                let totalRate = [];

                const rows = $('tbody tr');
                rows.each(function() {
                    const row = $(this);
                    const initTotal = row.find('.semiTotal').text();
                    let total = 0;

                    if (!isNaN(initTotal)) {
                        total = Number(initTotal);
                    }

                    totalRate.push(total);
                });
                const isMoreThan75 = totalRate.every(rate => rate > 75);
                if (isMoreThan75) {
                    $('#finalSubmitButton').prop('disabled', false);
                } else {
                    $('#finalSubmitButton').prop('disabled', true);
                }
            });


            $('#addSemi').submit(function() {
                event.preventDefault();
                $('#semiSubmitButton').prop('disabled', true);
                const rows = $('tbody tr');
                const rowData = [];
                var url = $(this).attr("action");

                rows.each(function() {
                    const row = $(this);
                    const beauty = row.find('.beauty');
                    const poise = row.find('.semiPoise');
                    const projection = row.find('.semiProjection');
                    const initTotal = row.find('.semiTotal').text();
                    let total = 0;

                    if (!isNaN(initTotal)) {
                        total = Number(initTotal);
                    }

                    const rowObj = {
                        contestantID: row.find('span').text().trim(),
                        beauty: beauty.val(),
                        poise: poise.val(),
                        projection: projection.val(),
                        total
                    };

                    rowData.push(rowObj);
                });

                sendData(rowData, url)
            });
        });

        function sendData(data, url) {
            let completedRequests = 0;
            const totalRequests = data.length;

            for (let x = 0; x < totalRequests; x++) {
                const formData = data[x];
                $.post(url, formData)
                    .done(function(response) {
                        completedRequests++;

                        if (completedRequests === totalRequests) {
                            location.reload();
                        }
                    })
                    .fail(function(error) {
                        console.error('Error:', error);
                        completedRequests++;
                        // if (completedRequests === totalRequests) {
                        //     location.reload();
                        // }
                    });
            }
        }
    </script>
@endsection
