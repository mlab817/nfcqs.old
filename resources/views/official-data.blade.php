@extends('layouts.app')

@section('content')
    <div id="page-content-wrapper">
        <div class="container-fluid">
            <h1 class="page-title"><i class="fa fa-leaf" style="color:green"></i> Official Production Data for {{ $data->commodity }}</h1>

            {!! Form::open(['url' => route('official_data.index'), 'method' => 'get', 'accept-charset' => 'UTF-8', 'id' => 'selectCommodityForm']) !!}
                <div class="row">
                    <div class="col-12">
                        <label>Commodity</label>
                        {!! Form::select('commodity_id', $commodities, $commodity_id, ['id' => 'commodity_id','class' => 'form-control']) !!}
                    </div>
                </div>
            {!! Form::close() !!}

            <div class="commodity-list">
                <table style="margin-bottom:20px">
                    <thead>
                        <tr>
                            <th>Year</th>
                            <th>Province</th>
                            <th class="text-right">Production</th>
                            <th class="text-right">Area Harvested</th>
                            <th class="text-right">Yield</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($data->official_data as $d)
                            <tr>
                                <td class="commodity-name" style="width:20%">{{ $d->year }}</td>
                                <td class="commodity-name" style="width:20%">{{ optional($d->province)->province }}</td>
                                <td class="crop-type text-right" style="width:20%">{{ number_format($d->production, 2) }}</td>
                                <td class="text-right">{{ number_format($d->area_harvested, 2) }}</td>
                                <td class="text-right">{{ number_format($d->yield, 2) }}</td>
                                <td class="actions">
                                    <form action="{{ route('official_data.destroy', ['id' => $d->id]) }}" method="POST" id="delete_record_{{$d->id}}">
                                        @csrf
                                        @method('DELETE')
                                        <a
                                            onclick="confirm('Are you sure you want to delete this item?'); return document.getElementById('delete_record_{{$d->id}}').submit()"
                                            href="javascript:{}"
                                            role="button"
                                            style="white-space:nowrap; color:red">
                                            <i class="fas fa-trash"></i>
                                            Delete
                                        </a>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td class="text-center" colspan="6">No data. Click Upload Data in the sidebar to upload data</td>
                            </tr>
                        @endforelse
                    <tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@push('scripts')
    <script>
        $(document).ready(function () {
            const commodityId = $('#commodity_id')
            commodityId.on('change', function () {
                $('#selectCommodityForm').submit();
            });
        });
    </script>
@endpush