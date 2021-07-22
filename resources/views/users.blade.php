@extends('app')
@section('content')
<div id="page-content-wrapper">
    <div class="container-fluid">
        <h1 class="page-title"><i class="fas fa-info-circle"></i> List of System Users</h1>
        <table>
            <thead>
                <tr>
                    <th>Office</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th style="text-align:center">Status</th>
                    <th style="text-align:center">Action</th>
                </tr>
            </thead>
            <tbody>
                @if (sizeof($users) != 0)
                    @foreach ($users as $key) 
                        <tr>
                            <td>{{ $key->office }}</td>
                            <td>{{ $key->full_name }}</td>
                            <td>{{ $key->email }}</td>
                            <td style="text-align:center">{!! ($key->is_active == 0) ? '<span style="color:#fff; background-color:orange; padding:3px 5px; border-radius:3px; font-weight:bold; font-size:10px; text-transform:uppercase">Inactive</span>' : '<span style="color:#fff; background-color:green; padding:3px 5px; border-radius:3px; font-weight:bold; font-size:10px; text-transform:uppercase">Active</span>' !!}</td>
                            <td style="text-align:center; font-weight:bold; font-size:11px; text-transform:uppercase">
                                <a href="{{ url('user/edit?id=' . $key->id) }}" style="color:green; margin-right:4px; padding-right:5px; border-right:1px solid #ddd">Edit</a>
                                
                                @if ($key->is_active == 0)
                                    <a href="{{ url('user/access?action=1&id=' . $key->id) }}" style="color:orange; margin-right:4px; padding-right:5px; border-right:1px solid #ddd">Activate</a>
                                @else
                                    <a href="{{ url('user/access?action=0&id=' . $key->id) }}" style="color:orange; margin-right:4px; padding-right:5px; border-right:1px solid #ddd">Deactivate</a>
                                @endif

                                <a href="{{ url('user/delete?id=' . $key->id) }}" class="delete-record" style="color:red">Delete</a>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
@stop
