<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Redirect;
use Illuminate\Http\Request;
use App\Tablero;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class TableroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function feedStates($stateid, $val, $userName)
    {
      Tablero::feedingIndicator($stateid, $val, $userName);   
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function findStates($id)
    {      
         //dd($id);
      $callStatesIndicators = Tablero::callStatesIndicator($id);
      $callDatasIndicators = Tablero::callDatasIndicator($id);

      //dd($states[1]['datasStates'][0]->stateid);
      //dd($states[0]['datasIndicator'][0]->indicatorid);
      //$states->orderBy('stateid', 'asc')->paginate(10);

         return view('feed', [
                               'callStatesIndicators' => $callStatesIndicators, 
                               'callDatasIndicators'  => $callDatasIndicators, 
                               'id'                  => $id
                             ]);
    }


    // RECIBE EL ID DE SELECT Y REDIRECCIONA A GETMOSTRAR PARA OPTENER EL TABLERO.
    public function llamarTablero(){

      $prueba = Input::get('tabla');
           //dd($prueba);
      return Redirect::action('TableroController@getMostrar',['tablero'=>$prueba]);
    }


    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
     public function showGrafic($tablero='')
     { 
       // TOMA EL RESULTADO DE LA FUNCIÓN ANTERIOR PARA CONTARLOS.
       $countStates = count($lastStateGrafic);
      //dd($countStates);

       $sumStates=0;
       foreach ($lastStateGrafic as $value) {
          $sumStates = $sumStates + $value->actualvalue;       
         //dd($value->actualvalue);
       } 
       //dd($sumStates) 
     }



    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
     public function getMostrar($tablero='')
    {   

        $test = Tablero::prueba('ind-77', 205980050);

        dd($test[2]);

        // OBTIENE DATOS DEL MODELO TABLERO.
        $allIndicators = Tablero::allIndicatorsOfUser();  
        $allControlviews = Tablero::defaultControlViewsOfUser($allIndicators);         
        
        $indicadores = [];
        $selectControlviews  = [];

        array_push($selectControlviews, $allControlviews[0]['nameControlView']);
        $aux1 = $allControlviews[0]['nameControlView'];
        $aux2 = $allControlviews[0]['nameControlView'];
        

        foreach ($allControlviews as $allControlview) { 

            $i=0;

          // CONSULTA SI EL PARAMETRO VIENE VACIO PARA OBTENER EL TABLERO POR DEFAULT.
          if ($tablero == '') {
            if ($allControlview['defaultControlView'] == 1) {
               array_push($indicadores, $allControlview);
            }
           // SI EL PARAMETRO NO VIENE VACIO OBTIENE EL TABLERO POR PARAMETRO. 
          }elseif ($allControlview['nameControlView'] == $tablero) {
            array_push($indicadores, $allControlview);
          }

          // OBTIENE LOS NOMBRES DE LOS TABLEROS PARA ENVIARLOS A LA VISTA.
          if ($aux1 != $aux2) {            
            array_push($selectControlviews, $allControlview['nameControlView']);            
            $aux2 = $allControlview['nameControlView'];
            $aux1 =   $allControlview['nameControlView'];
          }else{
            $aux1 =   $allControlview['nameControlView'];             
          }

         # FIN DEL FOR
        }  

       //dd($selectControlviews);
       
        return view( 'tablero', [
                                  'indicadores' => $indicadores, 
                                  'selectControlviews' => $selectControlviews
                                ]);      
        
    }


     /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function findControView()
    {
        //
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    public function getIndicadores($idUser){
        
         $idUser     = '205980050';//  = '0206380517'; //603570183 205980050 9999999  0205370500 0205420005;

         
         $indicadores = Tablero::tableroControl(); 

         //$indicadores[1]['employeeNoRelated']

          $tablero;
          $i = 0;           
          $ind = 0;

        foreach ( $indicadores[$ind++]['userIndicators'] as $userIndicator) {



                                                                                                                    
           
            // $faculty           = \DB::select('select PKG_CMI_FACULTIES.FUNC_GET_FACULTY(?) from dual',            [ $employeeNoRelated[0]->facultyid ]);
            // $lastsState        = \DB::select('select PKG_CMI_INDICATOR_STATES.FUNC_GET_LASTSSTATE(?) from dual',  [ $userIndicator->indicatorid ]);
            // $colorValues       = \DB::select('select PKG_CMI_COLORMETRIC.FUNC_GET_COLORVALUES(?) from dual',      [ $userIndicator->colormetricid ]);
            // $colometric        = \DB::select('select PKG_CMI_COLORMETRIC.FUNC_GET_COLORMETRIC(?) from dual',      [ $userIndicator->colormetricid ]);



           $averageColor1 = '';

          if ( ($userIndicator->actualvalue >= $colorValues[0]->initialvalue) && ($userIndicator->actualvalue <= $colorValues[0]->lastvalue) ) {
            $averageColor1 = $colorValues[0]->color;
          }elseif ( ($userIndicator->actualvalue >= $colorValues[1]->initialvalue) && ($userIndicator->actualvalue <= $colorValues[1]->lastvalue) ) {
            $averageColor1 = $colorValues[1]->color;
          }elseif ( ($userIndicator->actualvalue >= $colorValues[2]->initialvalue) && ($userIndicator->actualvalue <= $colorValues[2]->lastvalue) ) {
            $averageColor1 = $colorValues[2]->color;
          }elseif ( ($userIndicator->actualvalue >= $colorValues[3]->initialvalue) && ($userIndicator->actualvalue <= $colorValues[3]->lastvalue) ) {
            $averageColor1 = $colorValues[3]->color;
          }else{
            $averageColor1 = 'N/A';
          }
          
          
          /*--------------------------------------------------
               $tamano=0;
             if ($userIndicator->indicatorid == 'ind-nueve') {
               $tamano = count($lastsState);
               break;
             }
          */


          
          $lastsState_0_score = ''; $lastsState_1_score = ''; $lastsState_2_score = ''; $lastsState_3_score = ''; 
          $colometricAverage = 0.000;


          //Count consulta el tamaño de lasstate para poder sacarle el promedio y le asigna el valor del score,
          //sino le asigna N/A para mostrarlo en Ultimas Alimentaciones.
          if ( count($lastsState) == 5 ) {

             if ( !empty($lastsState[0]->score) ) {        
               $colometricAverage += ($lastsState[0]->score) / 4;
               $lastsState_0_score = $lastsState[0]->score;
             }else{
               $colometricAverage += 0;
               $lastsState_0_score = 'N/A';
             }

             if ( !empty($lastsState[1]->score) ) {
               $colometricAverage += ($lastsState[1]->score) / 4;
               $lastsState_1_score = $lastsState[1]->score;
             }else{
               $colometricAverage += 0;
               $lastsState_1_score = 'N/A';
             } 

             if ( !empty($lastsState[2]->score) ) {
               $colometricAverage += ($lastsState[2]->score) / 4;
               $lastsState_2_score = $lastsState[2]->score;
             }else{
               $colometricAverage += 0;
               $lastsState_2_score = 'N/A';
             }

             if ( !empty($lastsState[3]->score) ) {
               $colometricAverage += ($lastsState[3]->score) / 4;
               $lastsState_3_score = $lastsState[3]->score;
             }else{
               $colometricAverage += 0;
               $lastsState_3_score = 'N/A';
             }
             
           }elseif (count($lastsState) == 4) {

               if ( !empty($lastsState[0]->score) ) {        
                 $colometricAverage += ($lastsState[0]->score) / 3;
                 $lastsState_0_score = $lastsState[0]->score;
               }else{
                 $colometricAverage += 0;
                 $lastsState_0_score = 'N/A';
               }

               if ( !empty($lastsState[1]->score) ) {
                 $colometricAverage += ($lastsState[1]->score) / 3;
                 $lastsState_1_score = $lastsState[1]->score;
               }else{
                 $colometricAverage += 0;
                 $lastsState_1_score = 'N/A';
               } 

               if ( !empty($lastsState[2]->score) ) {
                 $colometricAverage += ($lastsState[2]->score) / 3;
                 $lastsState_2_score = $lastsState[2]->score;
               }else{
                 $colometricAverage += 0;
                 $lastsState_2_score = 'N/A';
               }

                 $lastsState_3_score = 'N/A'; 

           }elseif (count($lastsState) == 3) {

               if ( !empty($lastsState[0]->score) ) {        
                 $colometricAverage += ($lastsState[0]->score) / 2;
                 $lastsState_0_score = $lastsState[0]->score;
               }else{
                 $colometricAverage += 0;
                 $lastsState_0_score = 'N/A';
               }

               if ( !empty($lastsState[1]->score) ) {
                 $colometricAverage += ($lastsState[1]->score) / 2;
                 $lastsState_1_score = $lastsState[1]->score;
               }else{
                 $colometricAverage += 0;
                 $lastsState_1_score = 'N/A';
               } 
               
                 $lastsState_2_score = 'N/A';        
                 $lastsState_3_score = 'N/A';

           }elseif (count($lastsState) == 2) {

               if ( !empty($lastsState[0]->score) ) {        
                 $colometricAverage += ($lastsState[0]->score) / 1;
                 $lastsState_0_score = $lastsState[0]->score;
               }else{
                 $colometricAverage += 0;
                 $lastsState_0_score = 'N/A';
               }        
                 $lastsState_1_score = 'N/A';             
                 $lastsState_2_score = 'N/A';        
                 $lastsState_3_score = 'N/A';

           }elseif (count($lastsState) == 1 || count($lastsState) == 0) {
              
                 $lastsState_0_score = 'N/A';       
                 $lastsState_1_score = 'N/A';     
                 $lastsState_2_score = 'N/A';        
                 $lastsState_3_score = 'N/A';      
           }
           

           //Toma el promedio final de últimas alimentaciones y los compara con 
           //valor-inicial y último-valor para asignarle el color hex.
          $averageColor2;
          if ( ($colometricAverage >= $colorValues[0]->initialvalue) && ($colometricAverage <= $colorValues[0]->lastvalue) ) {
            $averageColor2 = $colorValues[0]->color;
          }elseif ( ($colometricAverage >= $colorValues[1]->initialvalue) && ($colometricAverage <= $colorValues[1]->lastvalue) ) {
            $averageColor2 = $colorValues[1]->color;
          }elseif (  ($colometricAverage >= $colorValues[2]->initialvalue) && ($colometricAverage <= $colorValues[2]->lastvalue) ) {
            $averageColor2 = $colorValues[2]->color;
          } elseif ( ($colometricAverage >= $colorValues[3]->initialvalue) && ($colometricAverage <= $colorValues[3]->lastvalue) ) {
            $averageColor2 = $colorValues[3]->color;
          }elseif ( $colometricAverage = 0 ) {
            $averageColor2 = 'N/A';
          }

          $frecuenciaAlimentacion = '';

          if ($userIndicator->updatefrq == 1) {
            $frecuenciaAlimentacion = 'Diaria';
          }elseif ($userIndicator->updatefrq == 30) {
            $frecuenciaAlimentacion = 'Mensual';
          }elseif ($userIndicator->updatefrq == 90) {
            $frecuenciaAlimentacion = 'Trimestral';
          }elseif ($userIndicator->updatefrq == 180) {
            $frecuenciaAlimentacion = 'Semestral';
          }elseif ($userIndicator->updatefrq == 365) {
            $frecuenciaAlimentacion = 'Anual';
          }


         $tablero[$i++] = [
                           'indicatorid'        => $userIndicator->indicatorid, 
                           'indicatorname'      => $userIndicator->indicatorname, 
                           'categoryname'       => $userIndicator->categoryname, 
                           'updatefrq'          => $frecuenciaAlimentacion, 
                           'score'              => $userIndicator->score, 
                           'actualvalue'        => $userIndicator->actualvalue, 
                           'colometric'         => $colometric[0]->metricname, 
                           'desirevalue'        => $userIndicator->desirevalue, 
                           'averageColor1'      => $averageColor1, 
                           'lastsState_0_score' => round($lastsState_0_score, 2),
                           'lastsState_1_score' => round($lastsState_1_score, 2),
                           'lastsState_2_score' => round($lastsState_2_score, 2),
                           'lastsState_3_score' => round($lastsState_3_score, 2),
                           'colometricAverage'  => round($colometricAverage, 2),
                           'averageColor2'      => $averageColor2 
                         ];
         
        

          }

        return $tablero;
         

        }
    
}
