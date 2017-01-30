<div class="panel panel-default">
    <div class="row">
        <div class="panel-body">
            <div class="col-md-6">
                <table class="table">
                    <thead>
                    <tr>
                        <td>Product in category</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($category->products as $product)
                        <tr>
                            <td>
                                Product:
                                <a href="{!! route('products.edit', $product->id) !!}">{!! $product->name !!}</a>
                            </td>
                            <td>
                                {!! Form::open([
                                    'route' => ['category.detachProducts', $product->id],
                                    'method' => 'POST',
                                    'style' => 'display:inline-block',
                                ]) !!}
                                    {!! Form::hidden('category_id', $category->id) !!}
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                {!! Form::close() !!}
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table">
                    <thead>
                    <tr>
                        <td>Added to the category</td>
                        <td>*</td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        @if (!array_key_exists($product->id, $productFromCategory))
                            <tr>
                                <td>
                                    Product:
                                    <a href="{!! route('products.edit', $product->id) !!}">{!! $product->name !!}</a>
                                </td>
                                <td>
                                    {!! Form::open([
                                        'route' => ['category.attachProducts', $product->id],
                                        'method' => 'POST',
                                        'style' => 'display:inline-block',
                                    ]) !!}
                                        {!! Form::hidden('category_id', $category->id) !!}
                                        <button type="submit" class="btn btn-primary">Add</button>
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>