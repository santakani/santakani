<li class="dropdown">
    <a href="#" data-toggle="dropdown">
        <img class="icon" src="/img/icon/language.svg"/>
        <span class="text hidden-xs">{{ trans('common.language') }}</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-right">
        @foreach (App\Localization\Languages::names() as $locale => $name)
            <li class="{{ $locale === App::getLocale()?'active':'' }}">
                <a href="{{ url()->current() }}?lang={{ $locale }}">
                    {{ $name['localized'] }} ({{ $name['native'] }})
                </a>
            </li>
        @endforeach
    </ul>
</li>
