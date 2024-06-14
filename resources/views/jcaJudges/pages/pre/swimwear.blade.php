@extends('layout.judgesLayout')
@section('judgesNavs')
<div class="d-flex ml-5 gap-5">
    <a href="{{ route('preliminary.index')}}">Preliminary</a>
    <a href="{{ route('swimwear.index')}}">Swimwear</a>
</div>
@endsection

@section('judgesCont')
    <form action="{{ url('/swimwearScore') }}" method="POST" id="addSwimwear">

        <div class="p-5">
            @if ($isRecorded)
                <h5 class="text-center">Respond recorded succesfully. Thank you for your participation!</h5>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Swimwear rating sheet</h3>
                </div>

                <div class="card-body p-0">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th scope="col">Contestants</th>
                                <th scope="col">Suitability (50%)</th>
                                <th scope="col">Poise and Projection (50%)</th>
                                <th scope="col">Total</th>
                                @if ($isRecorded)
                                    <th scope="col">Rank</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($contestants as $contestant)
                                <tr>
                                    <th>
                                        <span
                                            style="visibility: hidden">{{ $contestant->id }}</span>{{ $contestant->contestantNum }}.
                                        {{ $contestant->name }}
                                    </th>
                                    <td>
                                        @if ($contestant->suitability)
                                            {{ $contestant->suitability }}
                                        @else
                                            <input type="number" class="form-control w-75 suitability"
                                                placeholder="Composure" min="1" max="50" name="suitability">
                                        @endif
                                    </td>
                                    <td>
                                        @if ($contestant->projection)
                                            {{ $contestant->projection }}
                                        @else
                                            <input type="number" class="form-control w-75 swimwearProjection"
                                                placeholder="Projection" min="1" max="50"
                                                name="swimwearProjection">
                                        @endif
                                    </td>
                                    <td class="swimwearTotal">
                                        @if ($contestant->projection && $contestant->suitability)
                                            {{ $contestant->projection + $contestant->suitability }}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    @if ($isRecorded)
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
                <button type="submit" id="swimwearSubmitButton" class="btn btn-primary mt-3" disabled>Submit</button>

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

            let totalRate = [];

            $('input[type="number"]').on('input', function() {
                var value = parseInt($(this).val(), 10);
                if (value < 1) {
                    $(this).val(1);
                } else if (value > 50) {
                    $(this).val(50);
                }

                const row = $(this).closest('tr');
                const composure = parseInt(row.find('.suitability').val()) || 0;
                const projection = parseInt(row.find('.swimwearProjection').val()) || 0;
                const total = composure + projection;
                row.find('.swimwearTotal').text(total);

                totalRate = [];

                const rows = $('tbody tr');
                rows.each(function() {
                    const row = $(this);
                    const initTotal = row.find('.swimwearTotal').text();
                    let total = 0;

                    if (!isNaN(initTotal)) {
                        total = Number(initTotal);
                    }

                    totalRate.push(total);
                });

                const isMoreThan75 = totalRate.every(rate => rate > 75);
                if (isMoreThan75) {
                    $('#swimwearSubmitButton').prop('disabled', false);
                } else {
                    $('#swimwearSubmitButton').prop('disabled', true);
                }

            });

            $('#addSwimwear').submit(function() {
                event.preventDefault();
                $('#swimwearSubmitButton').prop('disabled', true);
                const rows = $('tbody tr');
                const rowData = [];
                var url = $(this).attr("action");

                rows.each(function() {
                    const row = $(this);
                    const suitability = row.find('.suitability');
                    const projectionInput = row.find('.swimwearProjection');
                    const initTotal = row.find('.swimwearTotal').text();
                    let total = 0;

                    if (!isNaN(initTotal)) {
                        total = Number(initTotal);
                    }

                    const rowObj = {
                        contestantID: row.find('span').text().trim(),
                        suitability: suitability.val(),
                        projection: projectionInput.val(),
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
            console.log(url)

            for (let x = 0; x < totalRequests; x++) {
                const formData = data[x];
                console.log(formData)
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
                        if (completedRequests === totalRequests) {
                            location.reload();
                        }
                    });
            }
        }
    </script>
@endsection
