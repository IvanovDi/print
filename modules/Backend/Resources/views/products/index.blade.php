@extends('backend::layouts.master')

@section('title')
    Products
@stop

@section('breadcrumb')
    <li class="active">Products</li>
@stop

@section('content')
     <div class="row">
         <div class="col-md-12">
             <h1>
                 Products
                 <a href="{!! route('products.create') !!}" class="btn btn-default pull-right">Create</a>
             </h1>
         </div>
     </div>
    <hr>
    {{ $products->links() }}
    <table class="table">
        <thead>
        <tr>
            <th>Name</th>
            <th width="150">Photo</th>
            <th>Category</th>
            <th>type</th>
            <th>*</th>
        </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td><a href="{!! route('products.edit', $product->id) !!}">{!! $product->name !!}</a></td>
                    <td><img src="{!! $product->image_full_path !!}" alt=""></td>
                    <td>
                        @foreach($product->categories as $category)
                            {!! $category->name !!}
                            @if (!$loop->last)
                                ,
                            @endif
                        @endforeach
                    </td>
                    <td>{!! $product->type !!}</td>
                    <td>
                        {!! Form::open([
                            'route' => ['products.destroy', $product->id],
                            'method' => 'delete',
                        ]) !!}
                            <button class="btn btn-danger" type="submit">Delete</button>
                        {!! Form::close() !!}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@stop