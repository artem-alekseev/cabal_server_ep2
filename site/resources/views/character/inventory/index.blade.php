<h2>Inventory - Page {{ $page }}</h2>
<table class="table">
    <thead>
    <tr>
        <th class="border-dark border-2"> - </th>
        @for($i = 0; $i < 8 ;$i++)
            <th class="border-dark border-2">Row {{ $i + 1 }}</th>
        @endfor
    </tr>
    </thead>
    <tbody>
    @for($i = ($page - 1) * 8 - ($page - 1); $i < $page * 8 - ($page - 1) ;$i++)
        <tr>
            <td class="fw-bold border-dark border-2">Line {{ ($i + $page) - ($page - 1) * 8 }} </td>
            @for($j = ($page - 1) * 8; $j < $page * 8 ;$j++)
                @php
                    $slot = $i * 8 + $j;
                    $item = $character->inventory->Data->firstWhere('dec_position', '=', $slot);
                    $isClosed = array_key_exists($slot, $closedClots) === false ? false : true;
                    $backgroundColor = $isClosed ? $closedClots[$slot] : null;
                @endphp
                <td class="border-2" @if ($backgroundColor) style="background-color: {!! $backgroundColor !!};" @endif>
                    @if ($slot == ($item ? $item->dec_position : null))
                        Item : {{ $item ? $item->dec_id : '-' }}<br>
                        <a href="{{ route('item.edit', [$character, $slot]) }}"
                           class="btn btn-success">
                            Edit
                        </a>
                    @elseif (!$backgroundColor)
                        - None -
                    @endif
                </td>
            @endfor
        </tr>
    @endfor
    </tbody>
</table>
