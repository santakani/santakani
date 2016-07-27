@extends('layouts.app', [
    'title' => trans('common.about_us'),
    'body_id' => 'about-page',
    'body_classes' => ['about-page', 'site-page'],
])

@section('header')
    <div class="container">
        <h1>Our mission: connect independent designers and design lovers, bring creative designs and ideas to more places.</h1>
    </div>
@endsection

@section('main')
    <section id="data-section">
        <div class="container">
            <div class="row">
                <div class="data-entry col-xs-4">
                    <div class="number">{{ $designer_number }}</div>
                    <div class="text">{{ trans('designer.designers') }}</div>
                </div>
                <div class="data-entry col-xs-4">
                    <div class="number">{{ $story_number }}</div>
                    <div class="text">{{ trans('story.stories') }}</div>
                </div>
                <div class="data-entry col-xs-4">
                    <div class="number">{{ $user_number }}</div>
                    <div class="text">{{ trans('common.users') }}</div>
                </div>
                <div class="data-entry col-xs-4">
                    <div class="number">{{ $place_number }}</div>
                    <div class="text">{{ trans('place.places') }}</div>
                </div>
                <div class="data-entry col-xs-4">
                    <div class="number">{{ $city_number }}</div>
                    <div class="text">{{ trans('geo.cities') }}</div>
                </div>
                <div class="data-entry col-xs-4">
                    <div class="number">{{ $tag_number }}</div>
                    <div class="text">{{ trans('common.tags') }}</div>
                </div>
            </div>
        </div>
    </section>

    <section id="community-section">
        <div class="container">
            <h2>{{ trans('common.service') }}</h2>
            <p>Santakani is a design platform.</p>
            <p>Designer profile - designers can share their designs and biography with design lovers.</p>
            <p>Place map - help natives and tourists find best design shops, showrooms, museums and more.</p>
            <p>Design story - everything of design that worths sharing.</p>
        </div>
    </section>

    <section id="community-section">
        <div class="container">
            <h2>{{ trans('common.community') }}</h2>
            <p>Designers, artisits, craftsmen and craftswomen, design students, and design lovers consist of this unique community. People from different cultures, using different languages, meet each other for the same reason: passion of design.</p>
            <p>Here, design lovers can share their thoughts and interact with designers. Without boundary of cultures and languages, the world of design is broader.</p>
            <p>Here, designers spread their knowledge, techniques and ideas inside design with people. Design students can also learn a lot from stories of experienced designers.</p>
            <p>Here, creativity and diversity are honored. Designers are praised by their design rather than business success.</p>
        </div>
    </section>

    <section id="team-section">
        <div class="container">
            <h2>{{ trans('common.team') }}</h2>

            <div class="row">
                <div class="col-xs-6 col-sm-4">
                    <div class="team-member">
                        <img class="img-rounded" src="/img/team/duyuexin.jpg">
                        <h3>Du Yuexin</h3>
                        <p>co-founder, designer, business development</p>
                        <a href="mailto:yuexin.du@santakani.com">yuexin.du@santakani.com</a>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-4">
                    <div class="team-member">
                        <img class="img-rounded" src="/img/team/guoyunhe.jpg">
                        <h3>Guo Yunhe</h3>
                        <p>co-founder, programmer, technical support</p>
                        <a href="mailto:yunhe.guo@santakani.com">yunhe.guo@santakani.com</a>
                    </div>
                </div>
                <div class="col-xs-6 col-xs-offset-3 col-sm-4 col-sm-offset-0">
                    <div class="team-member">
                        <img class="img-rounded" src="/img/team/yunxiaotong.jpg">
                        <h3>Yun Xiaotong</h3>
                        <p>co-founder, editor, marketing, customer service</p>
                        <a href="mailto:xiaotong.yun@santakani.com">xiaotong.yun@santakani.com</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
