{{--

Show a list of social media links, like Facebook, Instagram, website, email, etc.

Usage:
    @include('components.social-links', ['model' => $designer])

--}}

<ul id="social-links" class="social-links list-unstyled">
    @if ($model->facebook)
        <li>
            <a class="link-unstyled text-nowrap" href="{{ $model->facebook }}" target="_blank">
                <span class="icon ion-social-facebook"></span>
                Facebook
            </a>
        </li>
    @endif
    @if ($model->twitter)
        <li>
            <a class="link-unstyled text-nowrap" href="{{ $model->twitter }}" target="_blank">
                <span class="icon ion-social-twitter"></span>
                Twitter
            </a>
        </li>
    @endif
    @if ($model->instagram)
        <li>
            <a class="link-unstyled text-nowrap" href="{{ $model->instagram }}" target="_blank">
                <span class="icon ion-social-instagram"></span>
                Instagram
            </a>
        </li>
    @endif
    @if ($model->pinterest)
        <li>
            <a class="link-unstyled text-nowrap" href="{{ $model->pinterest }}" target="_blank">
                <span class="icon ion-social-pinterest"></span>
                Pinterest
            </a>
        </li>
    @endif
    @if ($model->vimeo)
        <li>
            <a class="link-unstyled text-nowrap" href="{{ $model->vimeo }}" target="_blank">
                <span class="icon ion-social-vimeo"></span>
                Vimeo
            </a>
        </li>
    @endif
    @if ($model->youtube)
        <li>
            <a class="link-unstyled text-nowrap" href="{{ $model->youtube }}" target="_blank">
                <span class="icon ion-social-youtube"></span>
                YouTube
            </a>
        </li>
    @endif
    @if ($model->website)
        <li>
            <a class="link-unstyled text-nowrap" href="{{ $model->website }}" target="_blank">
                <span class="icon ion-earth"></span>
                {{ parse_url($model->website)['host'] }}
            </a>
        </li>
    @endif
    @if ($model->email)
        <li>
            <a class="link-unstyled text-nowrap" href="mailto:{{ $model->email }}">
                <span class="icon ion-at"></span>
                {{ $model->email }}
            </a>
        </li>
    @endif
    @if ($model->phone)
        <li>
            <a class="link-unstyled text-nowrap" href="tel:{{ $model->phone }}">
                <span class="icon ion-android-call"></span>
                {{ $model->phone }}
            </a>
        </li>
    @endif
</ul>
