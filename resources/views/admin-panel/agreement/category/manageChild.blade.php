<ul>
    @foreach($childs as $child)
        <li>
            {{  $child->get_parent_name->name }}
            @if(count($child->childs))
                @include('admin-panel.agreement.category.manageChild',['childs' => $child->childs])
            @endif
        </li>
    @endforeach
</ul>
