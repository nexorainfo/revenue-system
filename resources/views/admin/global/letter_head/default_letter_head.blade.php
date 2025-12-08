<table style="width: 100%;border-collapse: collapse;border: none">
    <tbody>
    <tr>
        <td style="width: 25%">
            <img alt="Office Logo" src="{{asset('assets/backend/images/np.png')}}" style="height:80px; width:90px" />
        </td>
        <td style="width: 50%; text-align: center">
            @foreach(get_office_header() as $officeHeader)
                <span
                    style="font-size:{{$loop->first ? 16 : 14}}px"><strong>{{$officeHeader->title}}</strong></span>
                @if(!$loop->last)
                    <br/>
                @endif
            @endforeach
        </td>
        <td style="width: 25%">&nbsp;</td>
    </tr>
    </tbody>
</table>
