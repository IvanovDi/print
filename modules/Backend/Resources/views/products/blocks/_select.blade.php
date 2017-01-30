<tr data-tt-id="{!! $select->id !!}" data-tt-parent-id="{!! $parentId ?? null !!}">
    <td>
        <span class="categories" data-value="{!! $select->id !!}"
              data-name="{!! $select->name !!}"
        >
            {!! $select->name !!}
        </span>
    </td>
</tr>
<?php $count = $select->id ?>

@foreach($select->category as $select)
    @include('backend::products.blocks._select', [
        'select' => $select,
        'parentId' => $count,
    ])
@endforeach
