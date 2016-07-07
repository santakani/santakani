@extends('layouts.app', [
    'title' => trans('common.privacy'),
    'body_id' => 'home-page',
    'body_classes' => ['privacy-page', 'site-page'],
])

@section('main')
    <div class="container">
        <h1 class="page-header">{{ trans('common.privacy') }}</h1>

        <h2>1. {{ trans('privacy.s_1') }}</h2>
        <blockquote>
            <p>{{ trans('privacy.s_1_p_1') }}</p>
        </blockquote>

        <h3>1.1. {{ trans('privacy.s_1_1') }}</h3>
        <p>{{ trans('privacy.s_1_1_p_1') }}</p>

        <h3>1.2. {{ trans('privacy.s_1_2') }}</h3>
        <p>{{ trans('privacy.s_1_2_p_1') }}</p>
        <ol>
            <li>{{ trans('privacy.s_1_2_l_1_1') }}</li>
            <li>{{ trans('privacy.s_1_2_l_1_2') }}</li>
            <li>{{ trans('privacy.s_1_2_l_1_3') }}</li>
            <li>{{ trans('privacy.s_1_2_l_1_4') }}</li>
            <li>{{ trans('privacy.s_1_2_l_1_5') }}</li>
            <li>{{ trans('privacy.s_1_2_l_1_6') }}</li>
            <li>{{ trans('privacy.s_1_2_l_1_7') }}</li>
            <li>{{ trans('privacy.s_1_2_l_1_8') }}</li>
            <li>{{ trans('privacy.s_1_2_l_1_9') }}</li>
            <li>{{ trans('privacy.s_1_2_l_1_10') }}</li>
            <li>{{ trans('privacy.s_1_2_l_1_11') }}</li>
            <li>{{ trans('privacy.s_1_2_l_1_12') }}</li>
            <li>{{ trans('privacy.s_1_2_l_1_13') }}</li>
            <li>{{ trans('privacy.s_1_2_l_1_14') }}</li>
            <li>{{ trans('privacy.s_1_2_l_1_15') }}</li>
            <li>{{ trans('privacy.s_1_2_l_1_16') }}</li>
            <li>{{ trans('privacy.s_1_2_l_1_17') }}</li>
            <li>{{ trans('privacy.s_1_2_l_1_18') }}</li>
        </ol>

        <h3>1.3. {{ trans('privacy.s_1_3') }}</h3>
        <p>{{ trans('privacy.s_1_3_p_1') }}</p>

        <h3>1.4. {{ trans('privacy.s_1_4') }}</h3>
        <p>{{ trans('privacy.s_1_4_p_1') }}</p>

        <h3>1.5. {{ trans('privacy.s_1_5') }}</h3>
        <p>{{ trans('privacy.s_1_5_p_1') }}</p>

        <h3>1.6. {{ trans('privacy.s_1_6') }}</h3>
        <p>{{ trans('privacy.s_1_6_p_1') }}</p>

        <h3>1.7. {{ trans('privacy.s_1_7') }}</h3>
        <p>{{ trans('privacy.s_1_7_p_1') }}</p>

        <h3>1.8. {{ trans('privacy.s_1_8') }}</h3>
        <p>{{ trans('privacy.s_1_8_p_1') }}</p>

        <h2>2. {{ trans('privacy.s_2') }}</h2>
        <p>{{ trans('privacy.s_2_p_1') }}</p>
        <p>{{ trans('privacy.s_2_p_2') }}</p>

        <h2>3. {{ trans('privacy.s_3') }}</h2>
        <p>{{ trans('privacy.s_3_p_1') }}</p>
        <p>{{ trans('privacy.s_3_p_2') }}</p>
        <p>{{ trans('privacy.s_3_p_3') }}</p>

        <h2>4. {{ trans('privacy.s_4') }}</h2>
        <p>{{ trans('privacy.s_4_p_1') }}</p>

        <h2>5. {{ trans('privacy.s_5') }}</h2>
        <p>{{ trans('privacy.s_5_p_1') }}</p>
        <ol>
            <li>{{ trans('privacy.s_5_l_1_1') }}</li>
            <li>{{ trans('privacy.s_5_l_1_2') }}</li>
            <li>{{ trans('privacy.s_5_l_1_3') }}</li>
        </ol>
        <p>{{ trans('privacy.s_5_p_2') }}</p>
        <hr>
        <p>{{ trans('privacy.end_p_1') }}</p>
        <p>{!! trans('privacy.end_p_2') !!}</p>
    </div>
@endsection
