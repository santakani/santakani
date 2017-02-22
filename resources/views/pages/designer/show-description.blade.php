{{--

Overview tab

--}}

<div class="row">
    <div class="col-sm-9 col-md-8 col-lg-7">
        {!! $designer->html('content') !!}
    </div>
    <div class="col-sm-3 col-md-4 col-lg-5">
        <ul id="social-links" class="social-links list-unstyled">
            @if ($designer->facebook)
                <li>
                    <a class="link-unstyled text-nowrap" href="{{ $designer->facebook }}" target="_blank">
                        <span class="icon ion-social-facebook"></span>
                        Facebook
                    </a>
                </li>
            @endif
            @if ($designer->twitter)
                <li>
                    <a class="link-unstyled text-nowrap" href="{{ $designer->twitter }}" target="_blank">
                        <span class="icon ion-social-twitter"></span>
                        Twitter
                    </a>
                </li>
            @endif
            @if ($designer->instagram)
                <li>
                    <a class="link-unstyled text-nowrap" href="{{ $designer->instagram }}" target="_blank">
                        <span class="icon ion-social-instagram"></span>
                        Instagram
                    </a>
                </li>
            @endif
            @if ($designer->pinterest)
                <li>
                    <a class="link-unstyled text-nowrap" href="{{ $designer->pinterest }}" target="_blank">
                        <span class="icon ion-social-pinterest"></span>
                        Pinterest
                    </a>
                </li>
            @endif
            @if ($designer->vimeo)
                <li>
                    <a class="link-unstyled text-nowrap" href="{{ $designer->vimeo }}" target="_blank">
                        <span class="icon ion-social-vimeo"></span>
                        Vimeo
                    </a>
                </li>
            @endif
            @if ($designer->youtube)
                <li>
                    <a class="link-unstyled text-nowrap" href="{{ $designer->youtube }}" target="_blank">
                        <span class="icon ion-social-youtube"></span>
                        YouTube
                    </a>
                </li>
            @endif
            @if ($designer->website)
                <li>
                    <a class="link-unstyled text-nowrap" href="{{ $designer->website }}" target="_blank">
                        <span class="icon ion-earth"></span>
                        Website
                    </a>
                </li>
            @endif
            @if ($designer->email)
                <li>
                    <a class="link-unstyled text-nowrap" href="mailto:{{ $designer->email }}">
                        <span class="icon ion-at"></span>
                        Email
                    </a>
                </li>
            @endif
        </ul>

        @include('components.tags.tags-hash', ['tags' => $designer->tags, 'linked' => true])
    </div>
</div><!-- /.row -->
