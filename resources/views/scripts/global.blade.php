<script id="global-variables">
    window.app = {
        user: {!! Auth::check()?Auth::user()->toJSON():'false' !!},
        token: "{!! csrf_token() !!}",
    };

    window.csrfToken = window.app.token; // Legacy
</script>
