@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <div class="row">
                    <h3> my files</h3>
                    <div class="list-group">
                        @foreach($files as $ifile)
                            <a href="{{route('view', ['id'=>$ifile->id])}}" class="list-group-item list-group-item-action @if($ifile->id == $file->id)active @endif">{{ $ifile->original_name }}</a>
                        @endforeach
                    </div>
                </div>

                @if ($access->count() > 0)
                    <div class="row">
                        <h3> other files</h3>
                        <div class="list-group">
                            @foreach($access as $ifile)
                                <a href="{{route('view', ['id'=>$ifile->id]) }}" class="list-group-item  list-group-item-action @if($ifile->id == $file->id)active @endif ">{{ $ifile->original_name }}</a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
            <div class="col-md-7 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-md-6">
                                <p>File name : {{ $file->original_name }}</p>
                                <p>owned by: {{ $file->owner->name }}</p>
                            </div>
                            <div class="col-md-6">

                                @if ($file->user_id === auth()->user()->id)
                                    <a href="{{ route('delete', ['id' => $file->id]) }}"
                                       class="pull-right btn btn-danger"> Delete file </a>
                                @endif
                                <a href="{{ $url }}" class="pull-right btn btn-primary" target="_blank"
                                   style="margin-right: 20px"> view file </a>

                            </div>
                        </div>
                        @if ($file->user_id === auth()->user()->id)
                            @if ($file->public )
                                <div class="row">
                                    <div class="col-md-12">
                                        <p> viewed by :</p>
                                        <table class="table">
                                            <tr>
                                                <th>name</th>
                                                <th>read at</th>
                                            </tr>
                                            @foreach ($file->viewers as $user)
                                                <tr>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ (new \Carbon\Carbon($user->pivot->read_at))->format('Y-m-d H:i') }}</td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            @else
                                <div class="row">
                                    <div class="col-md-12">
                                        <p> viewed by :</p>
                                        <table class="table">
                                            <tr>
                                                <th>name</th>
                                                <th>has access</th>
                                                <th>read at</th>
                                                <th>action</th>
                                            </tr>
                                            @foreach ($users as $user)
                                                @if ($user->id == $file->id)
                                                    @continue
                                                @endif
                                                <tr>
                                                    <td>{{ $user->name }}</td>
                                                    <td> {{ $user->access->where('id', $file->id)->first() && $user->access->where('id', $file->id)->first()->pivot->where('can_see', true)->count() > 0 ? 'yes' : 'no' }}</td>
                                                    <td>{{ $user->access->where('id', $file->id)->count() > 0 ?  (new \Carbon\Carbon($user->access->where('id', $file->id)->first()->pivot->read_at))->format('Y-m-d H:i') : 'not read'}}</td>
                                                    <td> @if (  $user->access->where('id', $file->id)->count() > 0 && $user->access->where('id', $file->id)->first()->pivot->where('can_see', true)->count() > 0)
                                                            <a href="{{ route('toggleAccess', ['id' => $file->id, 'user_id' => $user->id, 'can_see' => 0])}}"
                                                               class="btn btn-danger"> remove
                                                                access</a>
                                                        @else
                                                            <a href="{{ route('toggleAccess', ['id' => $file->id, 'user_id' => $user->id, 'can_see' => true])}}"
                                                               class="btn btn-primary"> grant
                                                                access</a>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                    @endif
                                    @endif
                                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
