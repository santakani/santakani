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

    <section id="service-section">
        <div class="feature-group">
            <div class="image" style="background-image: url(/img/about/service-design.jpg)"></div>
            <div class="text">
                <h3>Designers + Design Lovers</h3>
                <p>Designers can share their designs and biography with design lovers.</p>
            </div>
        </div>
        <div class="feature-group">
            <div class="image right" style="background-image: url(/img/about/service-place.jpg)"></div>
            <div class="text">
                <h3>Design Shops &amp; Studios</h3>
                <p>Help natives and tourists find best design shops, showrooms, museums and more.</p>
            </div>
        </div>
        <div class="feature-group">
            <div class="image" style="background-image: url(/img/about/service-story.jpg)"></div>
            <div class="text">
                <h3>Design Stories</h3>
                <p>Everything of design that worths sharing.</p>
            </div>
        </div>
    </section>

    <section id="community-section">
        <div class="container">
            <div class="text">
                Designers, artisits, craftsmen and craftswomen, design students, and design lovers consist of this unique community. People from different cultures, using different languages, meet each other for the same reason: passion of design.
            </div>
        </div>
        <div class="background"></div>
    </section>

    <section id="team-section">
        <div class="container">
            <h2>Our Lovely Team</h2>

            <div class="row">
                <div class="col-sm-4">
                    <div class="team-member">
                        <img src="/img/team/duyuexin.jpg">
                        <h3>Du Yuexin</h3>
                        <p>co-founder, designer, business development</p>
                        <p>Aalto University, School of Arts</p>
                        <a href="mailto:yuexin.du@santakani.com">yuexin.du@santakani.com</a>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="team-member">
                        <img src="/img/team/guoyunhe.jpg">
                        <h3>Guo Yunhe</h3>
                        <p>co-founder, programmer, technical support</p>
                        <p>Aalto University, School of Arts</p>
                        <a href="mailto:yunhe.guo@santakani.com">yunhe.guo@santakani.com</a>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="team-member">
                        <img src="/img/team/yunxiaotong.jpg">
                        <h3>Yun Xiaotong</h3>
                        <p>co-founder, editor, marketing, customer service</p>
                        <p>Aalto University, School of Business</p>
                        <a href="mailto:xiaotong.yun@santakani.com">xiaotong.yun@santakani.com</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
