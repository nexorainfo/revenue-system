@foreach($taxPayerTypes as $taxPayerType)
    <tr>
        <td>{{$loop->iteration}}</td>
        <td>{{$taxPayerType['title']}}</td>
        <td>{{$taxPayerType['total']}}</td>
    </tr>

@endforeach
