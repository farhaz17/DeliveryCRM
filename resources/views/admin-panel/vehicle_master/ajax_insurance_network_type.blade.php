<table>
    @if (count($network)=='0')
    <p style="color: red"> <strong>  No Network Type Found</strong></p>

    @else
    @foreach ($network as $item)
    <tr style="margin-top:10px: font-size:12px ">
        <td><strong> Network Type</strong></td><td>&nbsp &nbsp &nbsp &nbsp</td><td class="ml-3" style="font-size: 12px">{{isset($item->network_type)?$item->network_type:""}}</td>
    </tr>

    <tr>
        <td>&nbsp &nbsp &nbsp &nbsp</td>
    </tr>
    @endforeach
    @endif








</table>

