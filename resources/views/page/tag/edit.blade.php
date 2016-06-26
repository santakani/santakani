@extends('layout.app', [
    'title' => 'Edit: ' . $tag->text('name'),
    'body_id' => 'tag-edit-page',
    'body_classes' => ['tag-edit-page', 'tag-page', 'edit-page'],
    'active_nav' => 'tag',
])

@section('header')
<div class="container">
    <div class="row">
        <div class="col-sm-offset-2 sol-sm-10 col-md-8">
            <h1 class="page-header">Edit: {{ $tag->text('name') }}</h1>
        </div>
    </div>
</div>
@endsection

@section('main')
<div class="container">
    <form id="tag-edit-form" class="form-horizontal" action="/tag/{{ $tag->id }}"
        data-id="{{ $tag->id }}">

        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10 col-md-8">
                <div class="alert alert-warning" style="display:none;" role="alert"></div>
            </div>
        </div>

        <!-- Nav tabs -->
        <div class="form-group">
            <div class="col-sm-offset-2 sol-sm-10 col-md-8">
                <ul id="translation-tabs" class="nav nav-tabs">
                    @foreach (App\Localization\Languages::getLanguageList() as $locale => $names)
                        <li class="{{ $locale==='en'?'active':'' }}">
                            <a href="#translation-{{ $locale }}" data-toggle="tab" title="{{ $names['native'] }}">
                                {{ $names['localized'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Tab panes -->
        <div class="tab-content">
            @foreach (App\Localization\Languages::getLanguageCodeList() as $locale)
                <?php $translation = $tag->translations()->where('locale', $locale)->first(); ?>
                <div id="translation-{{ $locale }}" class="tab-pane {{ $locale==='en'?'active':'' }}">
                    <div class="form-group">
                        <label for="name-input-{{ $locale }}" class="col-sm-2 control-label">
                            Name
                        </label>

                        <div class="col-sm-10 col-md-8">
                            <input name="translations[{{ $locale }}][name]" value="{{ $translation->name or '' }}"
                                id="name-input-{{ $locale }}" class="form-control" type="text" maxlength="255">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="alias-input-{{ $locale }}" class="col-sm-2 control-label">
                            Alias
                        </label>

                        <div class="col-sm-10 col-md-8">
                            <input name="translations[{{ $locale }}][alias]" value="{{ $translation->alias or '' }}"
                                id="alias-input-{{ $locale }}" class="form-control" type="text" maxlength="255">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description-input-{{ $locale }}" class="col-sm-2 control-label">
                            Description
                        </label>

                        <div class="col-sm-10 col-md-8">
                            <textarea id="description-input-{{ $locale }}" name="translations[{{ $locale }}][description]"
                                class="form-control">{{ $translation->description or '' }}</textarea>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div id="image-form-group" class="form-group">
            <label class="col-sm-2 control-label">
                Cover image
            </label>

            <div class="col-sm-10 col-md-8">
                <div id="cover-editor" class="cover-editor">
                    <button type="button" class="btn btn-default"><i class="fa fa-picture-o"></i> Choose</button><br><br>
                    @if ($tag->image_id)
                        @include('components.image-preview', ['image' => $tag->image])
                    @else
                        @include('components.image-preview')
                    @endif
                </div>
            </div>
        </div>

        <div class="form-group">
            <label for="level-input" class="col-sm-2 control-label">
                Level
            </label>

            <div class="col-sm-4 col-md-2">
                <input name="level" value="{{ $tag->level or '' }}"
                    id="level-input" class="form-control" type="number" min="0" max="255">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">Save</button>
            </div>
        </div>

    </form>
</div><!-- .container -->
@endsection

@push('templates')
    @include('template.image-preview')
@endpush

@push('modals')
    @include('components.image-manager')
@endpush
