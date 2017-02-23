{{--

Usage:
    @include('components.cards.user-card', ['user' => $user])
or
    @each('components.cards.user-card', $users, 'user')

Style:
    components/_card.scss

Parameter:
    \App\User   $user   (required)
    string      $class  (optional)

--}}

<article id="user-{{ $user->id }}" class="user-card card clearfix {{ $class or '' }}">
    <a class="card-cover-wrap" href="{{ $user->url }}">
        <img class="card-cover" src="{{ $user->avatar('medium') }}" srcset="{{ $user->avatar('large') }} x2" width="150" height="150">
    </a>

    <div class="card-body">
        <h3 class="card-title">
            <a class="link-unstyled" href="{{ $user->url }}">
                {{ $user->name }}
            </a>
        </h3>
        <div class="card-description">
            {{ $user->description }}
        </div>
    </div>
</article>
