<table>
    <tr>
        <th>id</th>
        <th>Name</th>
        <th>Phone No</th>
        <th>email id</th>
        <th>Gender</th>
    </tr>
@foreach($product as $data)
<tr>
   <td>{{$data['id']}}</td>
   <td>{{$data['name']}}</td>
   <td>{{$data['phone no']}}</td>
   <td>{{$data['email id']}}</td>
   <td>{{$data['gender']}}</td>
</tr>
@endforeach
</table>        