<h2>Inventory - Page {{ $page }}</h2>
<table class="table">
    <thead>
    <tr>
        <th> - </th>
        @for($i = 0; $i < 8 ;$i++)
            <th>Row {{ $i + 1 }}</th>
        @endfor
    </tr>
    </thead>
    <tbody>
    @for($i = ($page - 1) * 8 - ($page - 1); $i < $page * 8 - ($page - 1) ;$i++)
        <tr>
            <td class="fw-bold">Line {{ ($i + $page) - ($page - 1) * 8 }} </td>
            @for($j = ($page - 1) * 8; $j < $page * 8 ;$j++)
                <td>
                    @php
                        $slot = $i * 8 + $j;
                        $item = $character->inventory->Data->firstWhere('dec_position', '=', $slot);
                        $isClosed = array_search($slot, $closedClots) === false ? false : true;
                    @endphp
                    @if (!$isClosed)
                        Item : {{ $item ? $item->dec_id : '-' }}<br>
                        <a href="{{ route('item.edit', [$character, $slot]) }}"
                           class="btn btn-success">
                            Edit
                        </a>
                    @else
                        <i class="bi bi-arrow-left-square-fill"></i>
                    @endif
                </td>
            @endfor
        </tr>
    @endfor
    </tbody>
</table>
