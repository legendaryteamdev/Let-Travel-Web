@if(count($data)>0)
<table id="pop-table" class="table pop">
	<thead>
		<th>Name</th><th>E-mail</th><th>Phone</th><th></th>
	</thead>
	<tbody>
		@foreach($data as $row)
			
			<tr>
				<td>{{ $row->en_name }}</td><td>{{ $row->email }} <td>{{$row->phone}}</td></td><td width=8%><i onclick="window.location.href='{{route('user.user.user.edit', $row->id)}}'" class="fa fa-eye"></i></td>
			</tr>
		@endforeach
		
	</tbody>
</table>
@else
	No Data Avaiable
@endif
