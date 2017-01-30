@if(\Message::hasError())
    <div class="alert alert-danger alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <ul>
            {!! \Message::displayError() !!}
        </ul>
    </div>
@endif

@if(\Message::hasSuccess())
    <div class="alert alert-success alert-dismissible fade in">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <ul>
            {!! \Message::displaySuccess() !!}
        </ul>
    </div>
@endif

@if(\Message::hasWarning())
    <div class="alert alert-warning alert-dismissible fade in">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        <ul>
            {!! \Message::displayWarning() !!}
        </ul>
    </div>
@endif
