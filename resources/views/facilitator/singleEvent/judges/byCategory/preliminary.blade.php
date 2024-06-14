    <div class="tableContJudges p-5 rounded-3">

        <div class="d-flex justify-content-between">

            <h5>Preliminary judges</h5>

            <button type="button" class="btn btn-primary float-end mb-3" data-bs-toggle="modal"
                data-bs-target="#addJudges">
                +
            </button>

            <div class="modal fade" id="addJudges" tabindex="-1" aria-labelledby="addJudgesLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="addJudgesLabel">Judge number
                                {{ $preliminaryJudges->count() > 0 ? $preliminaryJudges->last()->judgeNum + 1 : 1 }}
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>

                        <form method="post" action="{{ route('judges.create') }}">
                            @csrf
                            @method('post')
                            <div class="modal-body">

                                <div class="mb-3">
                                    <label for="name" class="form-label">Judge name</label>
                                    <input type="text" class="form-control" id="name"
                                        placeholder="Enter name here" name="name">
                                </div>

                                <input type="hidden" class="form-control" name="category" value="Preliminary">


                                <input type="hidden" class="form-control" name="judgeNum"
                                    value="{{ $preliminaryJudges->count() > 0 ? $preliminaryJudges->last()->judgeNum + 1 : 1 }}">


                                <input type="hidden" class="form-control" name="eventID" value="{{ $event->id }}">

                            </div>
                            <div class="modal-footer">
                                <input type="submit" class="btn btn-primary" value="Submit">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>

        @if ($preliminaryJudges->count() > 0)
            <table class="table table-sm">
                <thead class="thead-dark">
                    <tr>
                        <th>Judge number</th>
                        <th>Name</th>
                        <th>Access code</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($preliminaryJudges as $judge)
                        <tr id="judgeRow{{ $judge->id }}">
                            <th>{{ $judge->judgeNum }}</th>
                            <td>{{ $judge->name }}</td>
                            <td>{{ $judge->accessCode }}</td>

                            <td class="d-flex gap-2">
                                <div>
                                    @include('facilitator.singleEvent.judges.edit')
                                </div>

                                <form
                                    action="{{ route('judge.delete', [
                                        'event' => $event->id,
                                        'judge' => $judge->id,
                                    ]) }}"
                                    method="POST">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-danger btn btn-sm"><i
                                            class="fa fa-trash"></i></button>
                                </form>

                                <div>
                                    <button class="btn btn-secondary btn btn-sm eventJudges"
                                        code={{ $judge->accessCode }}
                                        category="Preliminary"
                                        eventId={{ $event->id }}><i
                                            class="fa fa-clipboard"></i></button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <label class="text-center">No judges assigned!</label>
        @endif

    </div>

    @section('script')
        <script type="module">
            $(document).ready(function() {

                $('.eventJudges').click(function() {
                    const accessCode = $(this).attr('code');
                    const eventId = $(this).attr('eventId');
                    const category = $(this).attr('category');

                    const baseURL = `${window.location.protocol}//${window.location.host}`;
                    const accessLink =
                        `${baseURL}/jcaPro/jca/judges/event=${eventId}/category=${category}/accessCode=${accessCode}`;

                    navigator.clipboard.writeText(accessLink)
                        .then(() => {
                            console.log('Link copied to clipboard:', accessLink);
                        })
                        .catch(err => {
                            console.error('Failed to copy link to clipboard:', err);
                        });

                })
            });
        </script>
    @endsection


    <style>
        .tableContJudges {
            border: 1px solid lightgray;
        }
    </style>
