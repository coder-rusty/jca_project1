<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>
    @vite(['resources/css/app.css'])

</head>

<body>
    <div class="d-flex">
        <div class="sideBar bg-dark text-white p-4">
            <div class="text-center mb-4">
                <div class="img mb-3 bg-light mx-auto"></div>
                <h6>ADMINISTRATOR <i class="fas fa-th-large"></i></h6>

            </div>
            <hr class="bg-secondary">
            <nav class="nav flex-column">
                <a href="{{ route('event.index') }}" class="nav-link text-white">
                    <i class="fa fa-calendar" aria-hidden="true"></i> Events
                </a>
                <a href="{{ route('eventShow.show', ['event' => $event->id]) }}" class="nav-link text-white">
                    <i class="fa fa-user-plus" aria-hidden="true"></i> Create Judge
                </a>
                <a href="{{ route('contestant.index', ['event' => $event->id]) }}" class="nav-link text-white">
                    <i class="fa fa-users" aria-hidden="true"></i> Create Contestant
                </a>

                <a href="{{ route('admin.logout')}}" class="nav-link text-white">
                    <i class="fa fa-unlock" aria-hidden="true"></i> Logout
                </a>


            </nav>
        </div>





        <div class="eventContent flex-grow-1 overflow-auto"> <!-- Added overflow-auto -->
            <div class="customHeader w-100 p-4 bg-primary text-white d-flex justify-content-between align-items-center">
                <div>
                    <h1 class="mb-0">{{ $event->title }}</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a
                                    href="{{ route('preliminaryRatings.index', ['event' => $event->id]) }}"
                                    class="text-white">Pre-interview</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('swimwearRatings.index', ['event' => $event->id]) }}"
                                    class="text-white">Swimwear</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('gownRatings.index', ['event' => $event->id]) }}"
                                    class="text-white">Gown</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('ranking.index', ['event' => $event->id]) }}"
                                    class="text-white">Ranking</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('semifinalAdmin.index', ['event' => $event->id]) }}"
                                    class="text-white">Semifinal</a></li>
                            <li class="breadcrumb-item"><a
                                    href="{{ route('finalRatings.index', ['event' => $event->id]) }}"
                                    class="text-white">Final</a></li>
                        </ol>
                    </nav>
                </div>
                <p class="float-end" id="dateTime"></p>
            </div>
            <div class="p-3" id="show">
                @yield('eventContent')
            </div>

        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>

    @vite(['resources/js/app.js'])
    @yield('script')
</body>

</html>

<style>
    #unshow {
        background-color: red;
        width: 100%;
        height: 100vh;
    }

    body {
        font-family: 'Arial', sans-serif;
        background-color: #f8f9fa;
    }

    .sideBar {
        width: 250px;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
    }

    .eventContent {
        flex-grow: 1;
        min-height: 100vh;
        height: calc(100vh - 50px);
        /* Adjust the height as needed */
    }

    .customHeader {
        background: #007bff;
        color: white;
    }

    .breadcrumb {
        background: transparent;
        padding: 0;
        margin: 0;
    }

    .breadcrumb-item a {
        color: #ffffff;
        text-decoration: none;
    }

    .breadcrumb-item a:hover {
        text-decoration: underline;
    }

    .nav-link {
        display: flex;
        align-items: center;
        padding: 10px 15px;
        color: white;
        font-weight: 500;
        transition: background-color 0.3s, color 0.3s;
    }

    .nav-link:hover {
        background-color: #495057;
    }

    .nav-link i {
        margin-right: 10px;
    }

    .img {
        width: 90px;
        height: 90px;
        border-radius: 50%;
    }

    .btn-light {
        color: #007bff;
        border: 1px solid #fff;
        transition: background-color 0.3s, color 0.3s;
    }

    .btn-light:hover {
        background-color: #fff;
        color: #007bff;
    }

    .subHeader {
        border-bottom: 2px solid #2F2F2F;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 51px;
        background-color: #f1f1f1;
        padding: 10px;
    }
</style>

<script>
    setInterval(() => {
        document.getElementById('dateTime').textContent = new Date().toLocaleString('en-US', {
            timeZone: 'Asia/Manila'
        })
    }, 1000);

    function cover() {
        const coverBtn = document.getElementById('coverBtn');
        const show = document.getElementById('show');
        const unshow = document.getElementById('unshow');

        if (coverBtn.textContent === "Cover") {
            coverBtn.textContent = "Uncover";
            show.style.display = "none";
            unshow.style.display = "block";
        } else {
            coverBtn.textContent = "Cover";
            show.style.display = "block";
            unshow.style.display = "none";
        }
    }
</script>
