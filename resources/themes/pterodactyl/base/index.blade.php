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
@extends('layouts.master')
@section('title')
@lang('base.index.header')
@endsection
@section('content-header')
<h1>@lang('base.index.header')<small>@lang('base.index.header_sub')</small></h1>
<ol class="breadcrumb">
   <li><a href="{{ route('index') }}">@lang('strings.home')</a></li>
   <li class="active">@lang('strings.servers')</li>
</ol>
@endsection
@section('content')
<div class="row">
   <div class="col-xs-12">
      <div class="box">
         <div class="box-header">
            <h3 class="box-title">@lang('base.index.list')</h3>
            <div class="box-tools">
               <form action="{{ route('index') }}" method="GET">
                  <div class="input-group input-group-sm">
                     <input type="text" name="query" class="form-control pull-right" style="width:30%;" value="{{ request()->input('query') }}" placeholder="@lang('strings.search')">
                     <div class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                     </div>
                  </div>
               </form>
            </div>
         </div>
         <div class="box-body table-responsive no-padding">

            <table class="table table-hover" data-toggle="table" data-sort-order="desc">
               <thead>
				        <tr>
                            <th data-field="username" data-sortable="true"> @lang('strings.username')</th>
                            <th data-field="name" data-sortable="true"> @lang('strings.name')</th>
                            <th data-field="node" data-sortable="true"> @lang('strings.node')</th>
                            <th class="text-center" data-field="connection" data-sortable="true"> @lang('strings.connection')</th>
                            <th class="text-center" data-field="memory" data-sortable="true"> @lang('strings.memory')</th>
                            <th class="text-center" data-field="cpu" data-sortable="true"> @lang('strings.cpu')</th>
                            <th class="text-center" data-field="owner" data-sortable="true"> @lang('strings.owner')</th>
                            <th class="text-center" data-field="status" data-sortable="true">@lang('strings.status')</th>
                        </tr>
				</thead>

				<tbody>
                        @foreach($servers as $server)
                            <tr class="dynamic-update" data-server="{{ $server->uuidShort }}">
                                <td><a href="{{ route('server.index', $server->uuidShort) }}">{{ $server->username }}</code></td>
                                <td><a href="{{ route('server.index', $server->uuidShort) }}">{{ $server->name }}</a></td>
                                <td>@if(Auth::user()->isRootAdmin())<a href="admin/nodes/view/{{ $server->node->id }}">@endif{{ $server->node->name }}</td>
                                <td><code>{{ $server->allocation->alias }}:{{ $server->allocation->port }}</code></td>
                                <td class="text-center hidden-sm hidden-xs"><span data-action="memory">--</span> / {{ $server->memory === 0 ? '&infin;' : $server->memory }} MB</td>
                                <td class="text-center hidden-sm hidden-xs"><span data-action="cpu" data-cpumax="{{ $server->cpu }}">--</span> %</td>
                                <td class="text-center">if(Auth::user()->isRootAdmin()<a href="{{ route('admin.users.view', $server->user->id) }}">@endif{{ $server->user->username }}</a></td>
                                <td class="text-center" data-action="status">
                                    <span class="label label-default"><i class="fa fa-refresh fa-fw fa-spin"></i></span>
                                </td>
                            </tr>
                        @endforeach
               </tbody>			   
            </table>
         </div>
         @if($servers->hasPages())
         <div class="box-footer">
            <div class="col-md-12 text-center">{!! $servers->render() !!}</div>
         </div>
         @endif
      </div>
   </div>
</div>
@endsection
@section('footer-scripts')
@parent
{!! Theme::js('js/frontend/serverlist.js') !!}
@endsection
