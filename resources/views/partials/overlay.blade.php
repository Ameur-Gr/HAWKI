
<div id="overlay"

@if($activeOverlay)
    style =" visibility: visible; opacity: 1;"
@else
    style ="visibility: hidden; opacity: 0;"
@endif
>
    <div id="overlay-wrapper">
        <div id="overlay-logo">
            <img src="{{ asset('img/blablador-logo.svg') }}" alt="<?php echo $website_name; ?> - Logo">
        </div>  
    </div>
</div>

