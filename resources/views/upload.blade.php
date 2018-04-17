<div class="col-md-10 col-md-offset-1">
    <div class="panel panel-default">
        <div class="panel-heading">upload doc</div>

        <div class="panel-body">
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            <form action="{{ route('upload') }}" method="post" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group row">
                    <label for="file" class="col-sm-2 col-form-label"> file : </label>
                    <div class="col-sm-8">
                        <input type="file" name="file" class="form-control">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="public" class="col-sm-2 col-form-label"> visibility : </label>
                    <div class="col-sm-10">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="public" id="public"
                                   value="1" checked>
                            <label class="form-check-label" for="public">
                                public
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="public" id="private"
                                   value="0">
                            <label class="form-check-label" for="private">
                                private
                            </label>
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-10">
                        <button type="submit" class="btn btn-primary">upload</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
