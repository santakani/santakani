<div class="image-preview" style="background-image:url({{ $url or '' }})">
    <div class="progress" style="display:none;">
        <div class="progress-bar progress-bar-striped active" style="width: 0%"></div>
    </div>
    @if (isset($remove) && $remove)
        <span class="remove">×</span>
    @endif
</div>
