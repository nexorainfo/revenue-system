@foreach($data as $ward)
   <tr>
       <td>{{$ward['ward']}}</td>
       <td>{{$ward['land_invoice']}}</td>
       <td>{{$ward['invoice']}}</td>
       <td>{{$ward['total']}}</td>
   </tr>

@endforeach
<tr>
    <td>जम्मा</td>
    <td>{{$data->sum('land_invoice')}}</td>
    <td>{{$data->sum('invoice')}}</td>
    <td>{{$data->sum('total')}}</td>
</tr>
