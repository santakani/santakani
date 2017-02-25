{{--

Overview tab

--}}

<div class="row">
    <div class="col-sm-9 col-md-8 col-lg-7">
        {!! $designer->html('content') !!}
    </div>
    <div class="col-sm-3 col-md-4 col-lg-5">
        @include('components.social-links', ['model' => $designer])

        @include('components.tags.tags-hash', ['tags' => $designer->tags, 'linked' => true])
    </div>
</div><!-- /.row -->
