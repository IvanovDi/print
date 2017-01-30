<tr data-tt-id="{!! $category->id !!}" data-tt-parent-id="{!! $parentId ?? null !!}">
    <td>
        <a href="{!! route('category.edit', $category->id) !!}">{!! $category->name !!}</a>
    </td>
    <td>
        @if ($category->active)
            Active
        @else
            Inactive
        @endif
    </td>
    <td>
        @if ($category->active)
            {!! Form::open([
                'route' => ['category.inactive', $category->id],
                'method' => 'PUT',
                'style' => 'display:inline-block'
            ]) !!}
                <button type="submit"class="btn-warning btn">Deactivate</button>
            {!! Form::close() !!}
        @else
            {!! Form::open([
                'route' => ['category.active', $category->id],
                'method' => 'PUT',
                'style' => 'display:inline-block'
            ]) !!}
                <button type="submit"  class="btn-primary btn">Activate</button>
            {!! Form::close() !!}
        @endif
    </td>
    <td>
        {!! Form::open([
            'route' => ['category.destroy', $category->id],
            'method' => 'DELETE',
            'style' => 'display:inline-block'
        ]) !!}
        <button type="submit" class=" btn-danger btn">Delete</button>
        {!! Form::close() !!}
    </td>
</tr>
<?php $count = $category->id?>
@if (empty($category->category) || count($category->category) > 0)
        @foreach($category->category as $category)
            @include('backend::category.blocks._category', [
                'category' => $category,
                'parentId' => $count,
            ])
        @endforeach
@endif


