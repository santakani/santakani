@extends('layout.app', ['body_class' => 'edit-layout '.$body_class])

@section('content')
<div id="back-link">
    <div class="container">
        <a href="{{ $back_link or url('/') }}">
            <i class="fa fa-arrow-left"></i> Back
        </a>
    </div><!-- .container -->
</div><!-- #back-link -->
<div id="edit-content">
    <div class="container">
        @yield('edit_content')
    </div>
</div>
@endsection
