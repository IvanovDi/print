@extends('backend::layouts.master')

@section('title')
    Categories
@stop

@section('breadcrumb')
    <li class="active">Categories</li>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>
                Categories
                <a href="{!! route('category.create') !!}" class="btn btn-default pull-right">Create</a>
            </h1>
        </div>
    </div>
    <hr>
    @if (count($categories) > 0)
        <table class="table table-hover" id="table_id">
            <thead>
                <tr>
                    <th>Group</th>
                    <th width="100">Status</th>
                    <th width="150">Change status</th>
                    <th width="100">Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    @include('backend::category.blocks._category', [
                        'category' => $category,
                    ])
                @endforeach
            </tbody>
        </table>
    @endif

@stop

@push('script')
<script>
    $("#table_id").treetable({ expandable: true });
</script>
@endpush