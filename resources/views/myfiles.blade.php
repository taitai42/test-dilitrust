<div class="col-md-10 col-md-offset-1">
    <div class="panel panel-default">
        <div class="panel-heading">my files</div>

        <div class="panel-body">
            <div class="row col-md-4 col-md-offset-2">
                <h2> my files</h2>
            <div class="list-group">
                @foreach($files as $file)
                    <a class="list-group-item list-group-item-action" href="{{route('view', ['id' => $file->id])}}">{{ $file->original_name }}</a>
                @endforeach
            </div>
            </div>
            <div class="row col-md-4 col-md-offset-1">
                <h2>other files</h2>
            <div class="list-group">
                @foreach($access as $file)
                   <a class="list-group-item list-group-item-action" href="{{route('view', ['id' => $file->id])}}">{{ $file->original_name }}</a>
                @endforeach
            </div>
            </div>
        </div>
    </div>
</div>