<div class="panel panel-default">
    <div class="row">
        <div class="col-md-12">
            <div class="panel-body">
                <label>Quantity</label>
                <div class="panel-group">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <a data-toggle="collapse" href="#js_addQuantity">
                                <h4 class="panel-title">
                                    Add +
                                </h4>
                            </a>
                        </div>
                        <div id="js_addQuantity" class="panel-collapse collapse @if($errors->has('add_quantity') || $errors->has('add_price')) in @endif">
                            <div class="panel-body">
                                {!! Form::open([
                                    'method' => 'post',
                                    'route' => ['product.price.store', $product->id],
                                ]) !!}
                                    <div class="form-group @if($errors->has('add_quantity')) has-error @endif">
                                        {!! Form::label('add_quantity', 'Quantity') !!}

                                        {!! Form::number('add_quantity', null, [
                                            'class' => 'form-control'
                                        ]) !!}

                                        @if ($errors->has('add_quantity'))
                                            <p class="alert-danger">{!! $errors->first('add_quantity') !!}</p>
                                        @endif
                                    </div>
                                    <div class="form-group @if($errors->has('add_price')) has-error @endif">
                                        {!! Form::label('add_price', 'Price') !!}

                                        {!! Form::number('add_price', null, [
                                            'class' => 'form-control',
                                            'step' => '0.01',
                                        ]) !!}

                                        @if ($errors->has('add_price'))
                                            <p class="alert-danger">{!! $errors->first('add_price') !!}</p>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary col-md-12">Save</button>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
                <table class="table">
                    <thead>
                    <tr>
                        <th>Quantity</th>
                        <th>Price</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($product->prices as $price)
                        {!! Form::open([
                            'method' => 'put',
                            'route' => ['product.price.update', $product->id, $price->id],
                        ]) !!}
                            <tr>
                                <td class="@if($errors->has('quantity['.$price->id.']')) has-error @endif">
                                    {!! Form::number('quantity['.$price->id.']', $price->quantity, [
                                        'class' => 'form-control'
                                    ]) !!}

                                    @if ($errors->has('quantity['.$price->id.']'))
                                        <p class="alert-danger">{!! $errors->first('quantity['.$price->id.']') !!}</p>
                                    @endif
                                </td>
                                <td class="@if($errors->has('price['.$price->id.']')) has-error @endif">
                                    {!! Form::number('price['.$price->id.']', $price->price, [
                                        'class' => 'form-control',
                                        'step' => '0.01',
                                    ]) !!}

                                    @if ($errors->has('price['.$price->id.']'))
                                        <p class="alert-danger">{!! $errors->first('price['.$price->id.']') !!}</p>
                                    @endif
                                </td>
                                <td>
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </td>
                                <td>
                                    <button type="submit" form="delete[{!! $price->id !!}]" class="btn btn-danger">Delete</button>
                                </td>
                            </tr>
                        {!! Form::close() !!}

                        {!! Form::open([
                            'method' => 'delete',
                            'route' => ['product.price.delete', $product->id, $price->id],
                            'id' => 'delete[' . $price->id . ']',
                        ]) !!}

                        {!! Form::close() !!}
                    @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>