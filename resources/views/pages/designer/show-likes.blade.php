{{--

Likes tab

--}}

<div class="row">
    @foreach ($likes as $like)
        <div class="col-sm-6 col-lg-4">
            <p><small class="text-muted">{{ $like->created_at }}</small></p>
            @include('components.cards.user-card', ['user' => $like->user])

        </div>
    @endforeach
</div>

{{ $likes->appends(app('request')->all())->links() }}
