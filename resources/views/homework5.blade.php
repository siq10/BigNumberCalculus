

@extends('homework')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Homework 5 Input
                </div>

                <div class="panel-body">
                        <form method="post" action="{{ route('output5') }}">
                              @csrf                                
                                <div class="form-group">
                                  <label for="size">Matrix Size</label>
                                  <input type="number" class="form-control" id="size" aria-describedby="square" placeholder="Matrix Size"  name="size" value="{{ old('size') }}">
                                  <small id="square" class="form-text text-muted">This is a squared matrix.</small>
                                </div>
                                <div class="form-group">
                                  <label for="iter">Maximum Number of Iterations</label>
                                  <input type="number" class="form-control" id="iter" placeholder="Max Iterations"  name="iter" value="{{ old('iter') }}">
                                </div>

                                <div class="form-group">
                                        <label for="matrix">Enter the Matrix</label>
                                        <textarea class="form-control" style="font-size:20px; word-spacing:10px;" id="matrix" rows="10"  name="matrix" value="{{ old('matrix') }}"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Solve</button>
                                
                        </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection