{{-- Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com> --}}

{{-- Permission is hereby granted, free of charge, to any person obtaining a copy --}}
{{-- of this software and associated documentation files (the "Software"), to deal --}}
{{-- in the Software without restriction, including without limitation the rights --}}
{{-- to use, copy, modify, merge, publish, distribute, sublicense, and/or sell --}}
{{-- copies of the Software, and to permit persons to whom the Software is --}}
{{-- furnished to do so, subject to the following conditions: --}}

{{-- The above copyright notice and this permission notice shall be included in all --}}
{{-- copies or substantial portions of the Software. --}}

{{-- THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR --}}
{{-- IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, --}}
{{-- FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE --}}
{{-- AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER --}}
{{-- LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, --}}
{{-- OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE --}}
{{-- SOFTWARE. --}}
@extends('layouts.admin')

@section('title')
    List Servers
@endsection

@section('content-header')
    <h1>Servers<small>All servers available on the system.</small></h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('admin.index') }}">Admin</a></li>
        <li class="active">Servers</li>
    </ol>
@endsection

@section('content')
<div class="row">
    <div class="col-xs-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Server List</h3>
                <div class="box-tools">
                    <form action="{{ route('admin.servers') }}" method="GET">
                        <div class="input-group input-group-sm">
                            <input type="text" name="query" class="form-control pull-right" style="width:30%;" value="{{ request()->input('query') }}" placeholder="Search Servers">
                            <div class="input-group-btn">
                                <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                <a href="{{ route('admin.servers.new') }}"><button type="button" class="btn btn-sm btn-primary" style="border-radius: 0 3px 3px 0;margin-left:-1px;">Create New</button></a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="box-body table-responsive no-padding">
            <table class="table table-hover" data-toggle="table" data-sort-order="desc">
               <thead>
				        <tr>
                            <th data-field="username" data-sortable="true"> @lang('strings.id')</th>
                            <th data-field="name" data-sortable="true"> @lang('strings.name')</th>
                            <th data-field="node" data-sortable="true"> @lang('strings.owner')</th>
                            <th data-field="connection" data-sortable="true"> @lang('strings.username')</th>
                            <th class="text-center" data-field="memory" data-sortable="true"> @lang('strings.node')</th>
                            <th class="text-center" data-field="cpu" data-sortable="true"> @lang('strings.connection')</th>
							<th class="text-center" data-field="owner" data-sortable="true"> @lang('strings.status')</th>
                        </tr>
				</thead>

				<tbody>
                        @foreach($servers as $server)
                            <tr class="dynamic-update" data-server="{{ $server->uuidShort }}">
                                <td><a href="{{ route('server.index', $server->uuidShort) }}">{{ $server->id }}</code></td>
                                <td><a href="{{ route('server.index', $server->uuidShort) }}">{{ $server->name }}</a></td>
								<td><a href="{{ route('admin.users.view', $server->user->id) }}">{{ $server->user->username }}</a></td>
								<td><a href="{{ route('server.index', $server->uuidShort) }}">{{ $server->username }}</code></td>
                                <td>@if(Auth::user()->isRootAdmin())<a href="nodes/view/{{ $server->node->id }}">@endif{{ $server->node->name }}</td>
                                <td><code>{{ $server->allocation->alias }}:{{ $server->allocation->port }}</code></td>
								<td class="text-center">
                                    @if($server->suspended)
                                        <span class="label bg-maroon">Suspended</span>
                                    @elseif(! $server->installed)
                                        <span class="label label-warning">Installing</span>
                                    @else
                                        <span class="label label-success">Active</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
               </tbody>
            </table>
            </div>
            @if($servers->hasPages())
                <div class="box-footer with-border">
                    <div class="col-md-12 text-center">{!! $servers->render() !!}</div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
