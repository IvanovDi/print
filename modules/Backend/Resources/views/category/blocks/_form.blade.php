<div class="panel panel-default">
    <div class="row">
        <div class="col-md-6">
            <div class="panel-heading">
                <h4>Base Info</h4>
            </div>
            <div class="panel-body">
                <div class="form-group @if($errors->has('name')) has-error @endif">
                    {!! Form::label('name', 'Name') !!}
                    {!! Form::text('name', $category->name, [
                        'class' => 'form-control'
                    ]) !!}
                    @if ($errors->has('name'))
                        <p class="alert-danger">{!! $errors->first('name') !!}</p>
                    @endif
                </div>

                @if(!$categories->isEmpty())
                    <div class="form-group">
                        <label>Categories list</label>
                        <div id="categories">
                            <ul>
                                @foreach ($categories as $select)
                                    @include('backend::category.blocks._select', [
                                        'select' => $select,
                                    ])
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                <div class="form-group @if($category->parentCategory === null) hidden @endif">
                    <label>Selected category</label>
                    <div class="panel-group">
                        <div class="panel panel-default">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>*</th>
                                    </tr>
                                </thead>
                                <tbody id="categoryId">
                                    @if (!empty($category->parentCategory))
                                        <tr>
                                            <td>
                                                <input hidden name='category_id' value='{!! $category->parentCategory->id !!}'/>
                                                {!! $category->parentCategory->name !!}
                                            </td>
                                            <td>
                                                <button type="button" role="button" class="btn btn-danger pull-right js_deleteElement">Delete</button>
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    {!! Form::label('theme', 'Theme') !!}
                    {!! Form::select('theme_id', $themes, $category->theme_id, [
                        'class' => 'form-control'
                    ]) !!}
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="panel-body">
                <ul class="nav nav-tabs">
                    <li style="width: 40%" class="active">
                        <a data-toggle="tab" href="#base">
                            Page Info
                        </a>
                    </li>
                    <li style="width: 60%">
                        <a data-toggle="tab" href="#og">
                            Meta Tags
                        </a>
                    </li>
                </ul>
                <br>
                <div class="tab-content">
                    <div id="base" class="tab-pane fade in active">
                        <div class="form-group @if($errors->has('slug')) has-error @endif">
                            {!! Form::label('slug', 'Slug') !!}
                            {!! Form::text('slug', $category->slug, [
                                'class' => 'form-control',
                            ]) !!}
                            @if ($errors->has('slug'))
                                <p class="alert-danger">{!! $errors->first('slug') !!}</p>
                            @endif
                        </div>

                        <div class="form-group @if($errors->has('title')) has-error @endif">
                            {!! Form::label('title', 'Title') !!}
                            {!! Form::text('title', $category->title, [
                                'class' => 'form-control',
                            ]) !!}
                            @if ($errors->has('title'))
                                <p class="alert-danger">{!! $errors->first('title') !!}</p>
                            @endif
                        </div>
                        <div class="form-group @if($errors->has('description')) has-error @endif">
                            {!! Form::label('description', 'Description') !!}
                            {!! Form::textarea('description', $category->description, [
                                'class' => 'form-control',
                                'rows' => '5',
                            ]) !!}
                            @if ($errors->has('description'))
                                <p class="alert-danger">{!! $errors->first('description') !!}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            <label class="checkbox-inline">
                                <input type="checkbox" value=1 @if ($category->active) checked="checked" @endif name="active">
                                Active
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" value=1 @if ($category->is_page) checked="checked" @endif name="is_page">
                                Page
                            </label>
                            <label class="checkbox-inline">
                                <input type="checkbox" value=1 @if ($category->show_in_navigation) checked="checked" @endif name="show_in_navigation">
                                Include in Navigation Menu
                            </label>
                        </div>
                    </div>

                    <div id="og" class="tab-pane fade">
                        <div class="form-group">
                            {!! Form::label('og_title', 'Og-Title') !!}
                            {!! Form::text('og_title', $category->og_title, [
                                'class' => 'form-control',
                            ]) !!}
                            @if ($errors->has('og_title'))
                                <p class="alert-danger">{!! $errors->first('og_title') !!}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            {!! Form::label('og_description', 'Og-Description') !!}
                            {!! Form::textarea('og_description', $category->og_description, [
                                'class' => 'form-control',
                                'rows' => '5',
                            ]) !!}
                            @if ($errors->has('og_description'))
                                <p class="alert-danger">{!! $errors->first('og_description') !!}</p>
                            @endif
                        </div>
                        <div class="form-group">
                            {!! Form::label('keywords', 'Keywords') !!}
                            {!! Form::text('keywords', $category->keywords, [
                                'class' => 'form-control',
                            ]) !!}
                            @if ($errors->has('keywords'))
                                <p class="alert-danger">{!! $errors->first('keywords') !!}</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="panel-body">
            <div class="col-md-6">
                <div class="form-group @if($errors->has('image')) has-error @endif">
                    <label>Image:</label>
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>
                                <input type="file" accept="image/*" name="image">
                                @if ($errors->has('image'))
                                    <p class="alert-danger">{!! $errors->first('image') !!}</p>
                                @endif
                            </td>
                            <td>
                                @if ($category->image)
                                    <img src="{!! $category->image_full_path !!}" alt="">
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group @if($errors->has('thumbnail')) has-error @endif">
                    <label>Thumbnail:</label>
                    <table class="table">
                        <tbody>
                        <tr>
                            <td>
                                <input type="file" accept="image/*" name="thumbnail">
                                @if ($errors->has('thumbnail'))
                                    <p class="alert-danger">{!! $errors->first('thumbnail') !!}</p>
                                @endif
                            </td>
                            <td>
                                @if ($category->thumbnail)
                                    <img src="{!! $category->thumbnail_full_path !!}" alt="">
                                @endif
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="panel-footer">
        <button type="reset" class="btn btn-default">Reset</button>
        {!! Form::submit('Save', [
            'class' => 'btn-primary btn',
        ]) !!}

        <input name="stay_here" type="checkbox" value="1" id="stay_here">
        <label for="stay_here">Stay here</label>
    </div>
</div>

@push('script')
<script>
    $('#categories').jstree();

    function deleteElement() {
        $(this).closest('tr').remove();
        if ($('#categoryId').children().length === 0) {
            $('#categoryId').closest('div.form-group').addClass('hidden');
        }
    }

    $('#categories').on('changed.jstree', function (e, data) {
        if (data.event != undefined) {
            var _this = data.event.target;
            console.log()
            if (_this.tagName != 'SPAN' && $(_this).next()[0].tagName == 'SPAN') {
                _this = $(_this).next();
            }

            if ($('input[name="category_id"]').length != 0) {
                var element = $('input[name="category_id"]');
                for (var i = 0; i < element.length; i++) {
                    if(element[i].value == $(_this).data('value')) {
                        return;
                    }
                }
            }

            if($('li.category').hasClass('js_thisCategory')) {
                var thisCategory = $('.js_thisCategory');
                var elementParent = $(_this).parent();

                if ($.contains(thisCategory[0], elementParent[0]) ||
                        thisCategory.is(elementParent[0])
                ) {
                    alert('Dont select! This is child category');
                    return;
                } else {
                    var html = "<tr><td>" +
                            "<input hidden name='category_id' value='" + $(_this).data('value') + "' />" +
                            $(_this).data('name') + "" +
                            "</td><td><button type='button' role='button' class='btn btn-danger js_deleteElement pull-right'>Delete</button>" +
                            "</td></tr>";

                    if($('#categoryId').closest('div.form-group').hasClass('hidden')) {
                        $('#categoryId').closest('div.form-group').removeClass('hidden');
                    }

                    $('#categoryId').html(html);

                    $('.js_deleteElement').on('click', deleteElement);
                }
            } else {
                var html = "<tr><td>" +
                        "<input hidden name='category_id' value='" + $(_this).data('value') + "' />" +
                        $(_this).data('name') + "" +
                        "</td><td><button type='button' role='button' class='btn btn-danger js_deleteElement pull-right'>Delete</button>" +
                        "</td></tr>";

                if($('#categoryId').closest('div.form-group').hasClass('hidden')) {
                    $('#categoryId').closest('div.form-group').removeClass('hidden');
                }

                $('#categoryId').html(html);

                $('.js_deleteElement').on('click', deleteElement);
            }

        }
    }).jstree();

    $('.js_deleteElement').on('click', deleteElement);

    $('input[type=file]').on('change', function() {
        if (window.File && window.FileReader && window.FileList && window.Blob) {
        var fsize = $(this)[0].files[0].size;

            if(fsize>2097152) { //TODO 2mb
               alert("File size \nToo big!");
               $(this).val('');
            }
        } else {
            alert("Please upgrade your browser, because your current browser lacks some new features we need!");
        }
    });

    $('input[name=name]').keyup(function(){
        var Value = $('input[name=name]').val();
            Value = Value.replace(/\s/ig, '_').toLowerCase();
        $('input[name=slug]').val(Value);
    });

</script>
@endpush