<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    @vite(['resources/css/app.css'])

</head>

<body>

    @if (session('judge_name'))
        <div class="container-fluid bg-secondary">
            <div class="d-flex justify-content-between align-items-center bg-secondary p-3 rounded shadow-sm">

                <div class="d-flex gap-2 align-items-center">
                    <div>
                        <p class="mb-0">Hello <strong>{{ session('judge_name') }}</strong>, Welcome to <strong>Macho
                                Gay</strong>!</p>
                    </div>
                    @yield('judgesNavs')
                </div>


                <div>
                    <form action="{{ route('judge.logout') }}" method="get" class="mb-0">
                        @csrf
                        <button type="submit" class="btn btn-danger btn btn-sm">Logout</i>
                        </button>
                    </form>
                </div>


            </div>
        </div>


        @yield('judgesCont')


    @else
        <h1>You are not logged in</h1>
    @endif


    @vite(['resources/js/app.js'])
    @yield('judgingScript')


    <div class="contestantInfoAll">
        @yield('contestant')
    </div>


</body>

</html>

<style>
    .contestantInfoAll{
        width: 100%;
        height: 100vh;
        background-color: rgba(51, 51, 51, 0.8);
        position: fixed;
        top: 0;
        display: none;
    }
    </style>

<script type="module">
    document.addEventListener("DOMContentLoaded", function() {
        document.querySelectorAll('.contestantInfoAll').forEach(function(element) {
            element.addEventListener('click', function() {
                this.style.display = 'none';
                this.style.justify-content = 'center';
                this.style. align-items = 'center';
            });
        });
    });
</script>

