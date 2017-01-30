<li class="js_categoryElement category
    @if ($select->id == $category->id) js_thisCategory @endif"
    @if ($select->id == $category->id) data-jstree='{"opened":true,"selected":true}' @endif
>
    <span class="categories" data-value="{!! $select->id !!}"
          data-name="{!! $select->name !!}"
          style="@if ($select->id == $category->id) color:blue;pointer-events: none; @endif">
    {!! $select->name !!}
        @if ($select->id == $category->id)
            (this category)
        @endif
    </span>
    @foreach($select->category as $select)
        <ul>
            @include('backend::category.blocks._select', [
                'select' => $select,
            ])
        </ul>
    @endforeach
</li>
