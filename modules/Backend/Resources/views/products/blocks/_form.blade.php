<div class="panel panel-default">
    <div class="row">
        <div class="col-md-12">
            <div class="panel-body">
                <div class="form-group @if($errors->has('name')) has-error @endif">
                    {!! Form::label('name', 'Name') !!}
                    {!! Form::text('name', $product->name, [
                        'class' => 'form-control'
                    ]) !!}
                    @if ($errors->has('name'))
                        <p class="alert-danger">{!! $errors->get('name')[0] !!}</p>
                    @endif
                </div>

                <div class="form-group @if($errors->has('type')) has-error @endif">
                    {!! Form::label('type', 'Product Type') !!}
                    {!! Form::select('type', $types ,$product->type, [
                        'class' => 'form-control'
                    ]) !!}
                    @if ($errors->has('type'))
                        <p class="alert-danger">{!! $errors->get('type')[0] !!}</p>
                    @endif
                </div>

                <div class="form-group">
                    @if($product->type === 'printed')
                        <a class="btn btn-primary" href="{!! route('master.templates') !!}" target="_blank">Create Master
                            Templates</a>
                    @endif
                </div>
                @if(!$categories->isEmpty())
                    <div class="form-group">
                        <label>Categories list</label>
                        <div id="categories">
                            @if (count($categories) > 0)
                                <table class="table table-hover" id="select_id">
                                    <thead>
                                    <tr>
                                        <th>Group</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($categories as $select)
                                        @include('backend::products.blocks._select', [
                                            'select' => $select,
                                        ])
                                    @endforeach
                                    </tbody>
                                </table>
                            @endif
                        </div>
                    </div>
                @endif

                <div class="form-group @if($product->categories->isEmpty()) hidden @endif">
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
                                @foreach($product->categories as $category)
                                    <tr>
                                        <td>
                                            <input hidden name='category_ids[]' value='{!! $category->id !!}'/>
                                            {!! $category->name !!}
                                        </td>
                                        <td>
                                            <button class="btn btn-danger js_deleteElement pull-right">Delete</button>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="form-group @if($errors->has('image')) has-error @endif">
                    <label>Image:</label>
                    <table class="table">
                        <tbody>
                            <tr>
                                <td>
                                    <input type="file" accept="image/*" name="image">
                                    @if ($errors->has('image'))
                                        <p class="alert-danger">{!! $errors->get('image')[0] !!}</p>
                                    @endif
                                </td>
                                <td>
                                    @if ($product->image)
                                        <img src="{!! $product->image_full_path !!}" alt="">
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="panel-footer">
                <button type="reset" class="btn btn-default" >Reset</button>
                <button type="submit" class="btn btn-primary" >Save</button>

                <input name="stay_here" type="checkbox" value="1" id="stay_here">
                <label for="stay_here">Stay here</label>
            </div>
        </div>
    </div>
</div>
@push('script')
<script>
    $("#select_id").treetable({expandable: true});
</script>
@endpush

@push('script')
<script>
    $('span.categories').on('click', function () {
        var element = $('input[name="category_ids[]"]');
        for (var i = 0; i < element.length; i++) {
            if(element[i].value == $(this).data('value')) {
                return;
            }
        }

        var html = "<tr><td>" +
                "<input hidden name='category_ids[]' value='" + $(this).data('value') + "' />" +
                $(this).data('name') + "" +
                "</td><td><button type='button' role='button' class='btn btn-danger js_deleteElement pull-right'>Delete</button type='button' role='button'>" +
                "</td></tr>";

        if($('#categoryId').parent().parent().parent().parent().hasClass('hidden')) {
            $('#categoryId').parent().parent().parent().parent().removeClass('hidden');
        }

        $('#categoryId').append(html);

        $('.js_deleteElement').on('click', function() {

            $(this).parent().parent().remove();

            if ($('#categoryId').children().length === 0) {
                $('#categoryId').parent().parent().parent().parent().addClass('hidden');
            }
        });
    });

    $('.js_deleteElement').on('click', function() {
        $(this).parent().parent().remove();
        if ($('#categoryId').children().length === 0) {
            $('#categoryId').parent().parent().parent().parent().addClass('hidden');
        }
    });


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
</script>
@endpush