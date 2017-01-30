<div class="panel panel-default">
    <div class="row">
        <div class="col-md-12">
            <div class="panel-body">

                <div class="form-group @if($errors->has('name')) has-error @endif">
                    {!! Form::label('name', 'Name') !!}
                    {!! Form::text('name', $addon->name, [
                        'class' => 'form-control'
                    ]) !!}
                    @if ($errors->has('name'))
                        <p class="alert-danger">{!! $errors->get('name')[0] !!}</p>
                    @endif
                </div>

                <div class="form-group @if($errors->has('type_views')) has-error @endif">
                    {!! Form::label('type_views', 'Type views') !!}
                    {!! Form::select('type_views', $types, $addon->type_views, [
                        'class' => 'form-control'
                    ]) !!}
                    @if ($errors->has('type_views'))
                        <p class="alert-danger">{!! $errors->get('type_views')[0] !!}</p>
                    @endif
                </div>
            </div>
            <div class="panel-footer">
                <button type="reset" class="btn btn-default">Reset</button>
                <button type="submit" class="btn btn-primary">Save</button>

                <input name="stay_here" type="checkbox" value="1" id="stay_here">
                <label for="stay_here">Stay here</label>
            </div>
        </div>
    </div>
</div>