@extends('layout.judgesLayout')

@section('judgesNavs')
<div class="d-flex ml-5 gap-5">
    <a href="{{ route('preliminary.index')}}">Preliminary</a>
    <a href="{{ route('swimwear.index')}}">Swimwear</a>
</div>
@endsection

@section('judgesCont')
    <form action="{{ url('/preliminaryScore') }}" method="POST" id="addPreliminary">

        <div class="p-5">
            @if ($isRecorded)
                <h5 class="text-center">Respond recorded succesfully. Thank you for your participation!</h5>
            @endif
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Preliminaries/interview rating sheet</h3>
                </div>

                <div class="card-body p-0">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th scope="col">Contestants</th>
                                <th scope="col">Composure (50%)</th>
                                <th scope="col">Projection (50%)</th>
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

                                        @section('contestant')
                                            <h2>{{$contestant->name}}</h2>
                                        @endsection
                                    </th>
                                    <td>
                                        @if ($contestant->poise)
                                            {{ $contestant->poise }}
                                        @else
                                            <input type="number" class="form-control w-75 composure"
                                                placeholder="Composure" min="1" max="50" name="composure"
                                                required>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($contestant->projection)
                                            {{ $contestant->projection }}
                                        @else
                                            <input type="number" class="form-control w-75 projection"
                                                placeholder="Projection" min="1" max="50" name="projection"
                                                required>
                                        @endif
                                    </td>
                                    <td class="total">
                                        @if ($contestant->projection && $contestant->poise)
                                            {{ $contestant->projection + $contestant->poise }}
                                        @else
                                            0
                                        @endif
                                    </td>
                                    @if ($isRecorded)
                                        <td>
                                            {{$contestant->rank}}
                                        </td>
                                    @endif

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

            </div>
                <button type="submit" id="submitButton" class="btn btn-primary mt-3" disabled>Submit</button>
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
                const composure = parseInt(row.find('.composure').val()) || 0;
                const projection = parseInt(row.find('.projection').val()) || 0;
                const total = composure + projection;
                row.find('.total').text(total);

                totalRate = [];

                const rows = $('tbody tr');
                rows.each(function() {
                    const row = $(this);
                    const initTotal = row.find('.total').text();
                    let total = 0;

                    if (!isNaN(initTotal)) {
                        total = Number(initTotal);
                    }

                    totalRate.push(total);
                });

                const isMoreThan75 = totalRate.every(rate => rate > 75);
                if (isMoreThan75) {
                    $('#submitButton').prop('disabled', false);
                } else {
                    $('#submitButton').prop('disabled', true);
                }

            });

            $('#addPreliminary').submit(function() {
                event.preventDefault();
                $('#submitButton').prop('disabled', true);
                const rows = $('tbody tr');
                const rowData = [];
                var url = $(this).attr("action");

                rows.each(function() {
                    const row = $(this);
                    const composureInput = row.find('.composure');
                    const projectionInput = row.find('.projection');
                    const initTotal = row.find('.total').text();
                    let total = 0;

                    if (!isNaN(initTotal)) {
                        total = Number(initTotal);
                    }

                    const rowObj = {
                        contestantID: row.find('span').text().trim(),
                        poise: composureInput.val(),
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
                        if (completedRequests === totalRequests) {
                            location.reload();
                        }
                    });
            }
        }
    </script>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const submitButton = document.getElementById('submitPreRate');

        submitButton.addEventListener('click', () => {
            const rows = document.querySelectorAll('tbody tr');
            const rowData = [];

            rows.forEach(row => {
                const composureInput = row.querySelector('.composure');
                const projectionInput = row.querySelector('.projection');
                const initTotal = row.querySelector('.total').textContent;
                let total = 0;

                if (!isNaN(initTotal)) {
                    total = Number(initTotal);
                }

                const rowObj = {
                    contestantNum: row.querySelector('span').textContent[0],
                    composureValue: composureInput.value,
                    projectionValue: projectionInput.value,
                    total
                };

                rowData.push(rowObj);
            });

            console.log(rowData);
        });

        document.addEventListener('input', function(event) {
            if (event.target.classList.contains('composure') || event.target.classList.contains(
                    'projection')) {
                const row = event.target.closest('tr');
                const composure = parseInt(row.querySelector('.composure').value) || 0;
                const projection = parseInt(row.querySelector('.projection').value) || 0;
                const total = composure + projection;
                row.querySelector('.total').textContent = total;
            }

        });
    });
</script>
