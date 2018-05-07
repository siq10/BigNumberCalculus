

@extends('homework')

@section('content')
<style>
.flex{
    display: flex;
    text-align: center;
    justify-content: space-around;
    flex-direction: column;
}
.title{
    text-align: center;
}
.kid{
    word-spacing: 15px;
}
</style>
<div class="container">
    <div class="row">
        <div class="col-md-14">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="title">
                        Homework 5 Output:
                        <br>
                        @foreach ($matrix as $row)
                            {{implode($row," ")}}
                            <br>
                        @endforeach
                    </div>
                </div>
                <div class="panel-body">
                <div class="flex">
                <div>
                        <h3>Schultz</h3>
                        <h4><b>Norma</b>: {{$SchultzNorm}}</h4>
                        <h4><b>Nr Iteratii</b>: {{$SchultzIter}}</h4>
                        <h4><b>Inverse (last version)</b></h4>
                        <div class="kid">
                            
                            @foreach ($SchultzInverse as $row)
                            {{implode($row," ")}}
                            <br>
                            @endforeach
                        
                        </div>
                </div>
                    <div>
                        <hr><hr>
                            <h3>Li1</h3>                              
                            <h4><b>Norma</b>: {{$Li1Norm}}</h4>
                            <h4><b>Nr Iteratii</b>: {{$Li1Iter}}</h4>
                            <h4><b>Inverse (last version)</b></h4>
                            <div class="kid">
                            @foreach ($Li1Inverse as $row)
                            {{implode($row," ")}}
                            <br>
                            @endforeach
                            </div>
                          
                    </div>
                    <div>
                            <hr><hr>
                            
                            <h3>Li2</h3>
                                <h4><b>Norma</b>: {{$Li2Norm}}</h4>
                                <h4><b>Nr Iteratii</b>: {{$Li2Iter}}</h4>
                                <h4><b>Inverse (last version)</b></h4>
                                <div class="kid">
                                @foreach ($Li2Inverse as $row)
                                {{implode($row," ")}}
                                <br>
                                @endforeach
                                </div>
                              
                            </div>
                    

                </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection