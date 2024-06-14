@if (session()->has('out'))
<h1>{{ $out }}</h1>
@else
<h1>Thank you!</h1>
@endif

<script>
    history.pushState(null, null, document.URL);
    window.addEventListener('popstate', function () {
        history.pushState(null, null, document.URL);
    });
</script>