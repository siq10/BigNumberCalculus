<?php

namespace App\Http\Controllers;
use MathPHP\LinearAlgebra\Matrix;
use MathPHP\LinearAlgebra\SquareMatrix;
use MathPHP\LinearAlgebra\MatrixFactory;
use Illuminate\Http\Request;

class Tema5Controller extends Controller
{
    public $epsilon = 10**-10;
    
    public function gotoHomework()
    {
        return view('homework5');
    }
    public function solve(Request $request)
    {
        $size = $request->size;
        $iterations = $request->iter;
        $matrix = explode("\r\n",$request->matrix);
        foreach($matrix as &$m)
        {
            $m = explode(" ", $m);
        }
        $workMatrix = new SquareMatrix($matrix);
        $V0 = $workMatrix->scalarDivide(($workMatrix->oneNorm()*$workMatrix->infinityNorm()));
        
        $Schultz = $this->solveSchultz($V0,$iterations,$workMatrix,$size);
        if($Schultz["convergent"]===true)
        {
            $SchultzNorm = $workMatrix->multiply($Schultz["value"])->subtract(MatrixFactory::identity($size))->oneNorm();
            $SchultzIter = $Schultz["iter"];
        }
        else
        {
            $SchultzNorm = "";
            $SchultzIter = $Schultz["iter"];
        }
        $SchultzInverse = $Schultz["value"]->getMatrix();

        $Li1 = $this->solveLi1($V0,$iterations,$workMatrix,$size);
        if($Li1["convergent"]===true)
        {
            $Li1Norm = $workMatrix->multiply($Li1["value"])->subtract(MatrixFactory::identity($size))->oneNorm();
            $Li1Iter = $Li1["iter"];
        }
        else
        {
            $Li1Norm = "";
            $Li1Iter = $Li1["iter"];
        }
        $Li1Inverse = $Li1["value"]->getMatrix();

        $Li2 = $this->solveLi2($V0,$iterations,$workMatrix,$size);
        if($Li2["convergent"]===true)
        {
            $Li2Norm = $workMatrix->multiply($Li2["value"])->subtract(MatrixFactory::identity($size))->oneNorm();
            $Li2Iter = $Li2["iter"];
        }
        else
        {
            $Li2Norm = "";
            $Li2Iter = $Li2["iter"];
        }
        $Li2Inverse = $Li2["value"]->getMatrix();

        return view('homework5output',compact("Li1Inverse","Li1Norm", "Li1Iter",
                                        "SchultzInverse","SchultzNorm", "SchultzIter",
                                        "Li2Inverse","Li2Norm", "Li2Iter",
                                        "matrix"));
        
        
    }

    public function solveSchultz($v0,$iter,$A,$size)
    {
        $deltaV = 1; // initial value will be overridden
        $Schultz[0] = $v0;
        $i=0;
        $Schultz[1] = $v0;
        do {
            $Schultz[0] = $Schultz[1];
            $Schultz[1] = $Schultz[0]->multiply(MatrixFactory::identity($size)->scalarMultiply(2)->subtract($A->multiply($Schultz[0])));
            $deltaV = $Schultz[1]->subtract($Schultz[0])->oneNorm();
            $i+=1;
        }
        while($deltaV >= $this->epsilon && $i < $iter && $deltaV <=10**10);
        if($deltaV < $this->epsilon)
        {
            $response["value"] = $Schultz[1];
            $response["iter"] = $i;
            $response["convergent"] = true;
        }
        else{
            $response["value"] = $Schultz[1];
            $response["iter"] = $i;
            $response["convergent"] = false;
        } 
        
        return $response;
    }

    public function solveLi1($v0,$iter,$A,$size)
    {
        $deltaV = 1; // initial value will be overridden
        $Li1[0] = $v0;
        $i=0;
        $Li1[1] = $v0;
        do {
            $Li1[0] = $Li1[1];
            $Li1[1] = $Li1[0]->multiply(
                MatrixFactory::identity($size)->scalarMultiply(3)->subtract(
                    $A->multiply(
                        $Li1[0]->multiply(
                            MatrixFactory::identity($size)->scalarMultiply(3)->subtract(
                                    $A->multiply($Li1[0])
                            )
                        )
                    )        
                )
            );
            $deltaV = $Li1[1]->subtract($Li1[0])->oneNorm();
            $i+=1;
        }
        while($deltaV >= $this->epsilon && $i < $iter && $deltaV <=10**10);
        if($deltaV < $this->epsilon)
        {
            $response["value"] = $Li1[1];
            $response["iter"] = $i;
            $response["convergent"] = true;
        }
        else{
            $response["value"] = $Li1[1];
            $response["iter"] = $i;
            $response["convergent"] = false;
        } 
        
        return $response;
    }

    public function solveLi2($v0,$iter,$A,$size)
    {
        $deltaV = 1; // initial value will be overridden
        $Li2[0] = $v0;
        $i=0;
        $Li2[1] = $v0;
        do {
            $Li2[0] = $Li2[1];
            $Li2[1] = MatrixFactory::identity($size)->add(
                MatrixFactory::identity($size)->subtract($Li2[0]->multiply($A))
                ->multiply(MatrixFactory::identity($size)->scalarMultiply(3)->subtract($Li2[0]->multiply($A))
                )->multiply(MatrixFactory::identity($size)->scalarMultiply(3)->subtract($Li2[0]->multiply($A))
                )->scalarMultiply(1/4))->multiply($Li2[0]);
            $deltaV = $Li2[1]->subtract($Li2[0])->oneNorm();
            $i+=1;
        }
        while($deltaV >= $this->epsilon && $i < $iter && $deltaV <=10**10);
        if($deltaV < $this->epsilon)
        {
            $response["value"] = $Li2[1];
            $response["iter"] = $i;
            $response["convergent"] = true;
        }
        else{
            $response["value"] = $Li2[1];
            $response["iter"] = $i;
            $response["convergent"] = false;
        } 
        
        return $response;
    }
}   
