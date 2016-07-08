<script id="global-variables">
    window.app = {
        user: {!! Auth::check()?Auth::user()->id:'false' !!},
        token: "{!! csrf_token() !!}",
        locale: "{{ App::getLocale() }}",
    };
</script>
