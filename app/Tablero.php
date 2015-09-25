<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tablero extends Model
{

protected $table = 'tableros';   
private $userIndicators;
private $employeeNoRelated;
private $faculty;
private $lastsState;
private $colorValues;
private $colometric; 

public static function prueba($ind, $idUser){
  $ind = 'ind-77';
  $idUser = 205980050;
  $val1 = ''; //2012;
  $val2 = ''; //85.5;
 // $feed = \DB::select('call pkg_cmi_indicators.proc_calc_multiperiod_all(?,?,?)',[$ind, $val1, $val2]);

  $graficDates = [];


  
  // OBTIENE LOS VALORES PARA MOSTRAR Y RELACIONAR OTROS DATOS.
  $indicator = \DB::select('select PKG_CMI_CONTROLVIEW.FUNC_GET_INDICATOR(?, ?) from dual',[$ind, $idUser]);
  //dd($indicator);



  // LLAMA A LA FUNCIÓN PARA OBTENER TODOS LOS DATOS ALIMENTADOS, PARA LUEGO SER CONTADOS Y SUMADOS.
  $lastStateGrafic = \DB::select('select PKG_CMI_INDICATOR_STATES.FUNC_GET_LASTSSTATEGRAFIC(?) from dual',[$ind]);
  //dd($lastStateGrafic);

  // TOMA EL RESULTADO DE LA FUNCIÓN ANTERIOR PARA CONTARLOS.
  $countStates = count($lastStateGrafic);
 //dd($countStates);

 $sumStates=0;
  foreach ($lastStateGrafic as $value) {
   $sumStates = $sumStates + $value->actualvalue;
  
    //dd($value->actualvalue);
  } 
  //dd($sumStates);
  
  // FUNCIÓN PARA OBTENER ÚNICAMENTE LA COLORIMETRÍA EN QUE SE ENCUENTRA EL INDICADOR.
  $colorValue = \DB::select('select PKG_CMI_COLORVALUE.FUNC_GET_COLORVALUE(?) from dual',[$indicator[0]->actuallevel]);
   //dd($colorValue);
  
  // FUNCIÓN QUE OBTIENE EL NOMBRE Y EL APELLIDO DEL ADMINISTRADOR.
  $nameAdmin = \DB::select('select PKG_CMI_EMPLOYEES.FUNC_GET_EMPLOYEENOTRELATED(?) from dual',[$indicator[0]->administrator ]);
  //dd($colorValue);
  

   array_push($graficDates, [ 
                              'indicator' => $indicator, 
                              'lastStateGrafic' => $lastStateGrafic, 
                              'colorValue' => $colorValue, 
                              'nameAdmin' => $nameAdmin
                            ]);
  

  //dd($graficDates);
   return [$indicator, $lastStateGrafic, $colorValue, $nameAdmin];
}











public static function feedingIndicator($stateid, $val, $userName){


  /*$user = 'lnunez';
  $val = 58.66;
  $stateid = 25619; */

  //ALIMENTA UN ESTADO DEL INDICADOR.
  $feed = \DB::statement('call PKG_CMI_INDICATOR_STATES.PROC_MAKE_FEED(?,?,?)',[$stateid, $val, $userName]);

}


public static function callStatesIndicator($ind){
  
 
  //$p = \DB::statement('call PKG_CMI_INDICATOR_STATES.PROC_MAKE_FEED(?,?,?)',[$stateid, $val, $user]);
  
  //$p = \DB::exec('pkg_cmi_indicator_states.func_get_valid_fees(?, ?, ?)',[$ind, $per, $user]);
  //$p= \DB::table('select * from CMI_INDICATOR_STATE t where t.indicatorid = '.$ind.';');
 


 $datasStates= \DB::table('CMI_INDICATOR_STATE')->select('*')->where('indicatorid', '=',  $ind)->get();  
   
 return $datasStates;
}


public static function callDatasIndicator($ind){  


//Obtiene todos los datos de un indicador en especifico.
//getIndicator(String indicatorID)
$datasIndicator = \DB::select('select PKG_CMI_INDICATORS.FUNC_GET_INDICATOR(?) from dual',[$ind]);  
 
 return $datasIndicator;
}

  

public static function defaultControlViewsOfUser($userIndicators){

  // $retornar = Tablero::tableroControl();
  // return $retornar[0]['indicatorid'];


 $idUser     = '205980050';

    // OBTIENE TODOS LOS INDICADORES DEL USUARIO.
     //$userIndicators     = Tablero::allIndicatorsOfUser();

    // OBTIENE LOS TABLEROS POR DEFAULT DEL USUARIO.
    $userDefaultControlViewS = \DB::select('select PKG_CMI_CONTROLVIEW.FUNC_GET_CONTROLVIEWS(?) from dual', [ $idUser ]);
    

    $arrayIndicators = []; // = array(); //= [];
    $i=0;

  // BUCLE QUE OBTIENE LOS TABLEROS POR DEFAULT.
  foreach ($userDefaultControlViewS as $userDefaultControlView) {

      // OBTIENE LOS INDICADORES DEL TABLERO.
      $userIndicatorsOfCV  = \DB::select('select PKG_CMI_CONTROLVIEW.FUNC_GET_INDICATORSofCV(?,?) from dual', [
                                                                                                                $idUser, 
                                                                                                                $userDefaultControlView->controlviewid
                                                                                                              ]);
    
      // BUCLE QUE OBTIENE LOS INDICADORES DE CADA TABLERO.
     foreach ($userIndicatorsOfCV  as $userIndicatorsCV) {
       // BUCLE QUE OBTIENE TODOS LOS INDICADORES DEL USUARIO REGISTRADO.
        foreach ($userIndicators as $userIndicator) {
          //return $userIndicator;

            // COMPARA LOS INDICADORES DEL TABLERO CON LOS DEL USUARIO, PARA ALMACENARLOS Y RETORNARLOS.
            if ($userIndicatorsCV->indicatorid == $userIndicator['indicatorid']) {

                //FUNCION PARA IR AGREGANDO LOS INDICADORES.                
                array_push($arrayIndicators, [
                                               'nameControlView'     =>  $userDefaultControlView->controlviewname,
                                               'defaultControlView'  =>  $userDefaultControlView->defaultcv,
                                               'indicatorid'         =>  $userIndicator['indicatorid'],
                                               'indicatorname'       =>  $userIndicator['indicatorname'],
                                               'categoryname'        =>  $userIndicator['categoryname'],
                                               'updatefrq'           =>  $userIndicator['updatefrq'],
                                               'score'               =>  $userIndicator['score'],
                                               'actualvalue'         =>  $userIndicator['actualvalue'],
                                               'colometric'          =>  $userIndicator['colometric'],
                                               'desirevalue'         =>  $userIndicator['desirevalue'],
                                               'averageColor1'       =>  $userIndicator['averageColor1'],
                                               'lastsState_0_score'  =>  $userIndicator['lastsState_0_score'],
                                               'lastsState_1_score'  =>  $userIndicator['lastsState_1_score'],
                                               'lastsState_2_score'  =>  $userIndicator['lastsState_2_score'],
                                               'lastsState_3_score'  =>  $userIndicator['lastsState_3_score'],
                                               'colometricAverage'   =>  $userIndicator['colometricAverage'],
                                               'averageColor2'       =>  $userIndicator['averageColor2']
                                               
                                            ]); 
            }

            # code...
          }
          
        }

    }    

  return $arrayIndicators;

}





 public static function allIndicatorsOfUser(){

  $idUser     = '205980050';


  // OBTIENE TODOS LOS INDICADORES DEL USUARIO.
  $userIndicators     = \DB::select('select PKG_CMI_CONTROLVIEW.FUNC_GET_USERINDICATOR(?) from dual', [ $idUser ]);
  // OBTIENE LOS DATOS PERSONALES DEL USUARIO Y FACULTAD.
  $employeeNoRelated = \DB::select('select PKG_CMI_EMPLOYEES.FUNC_GET_EMPLOYEENOTRELATED(?) from dual', [ $idUser ]);
  

   $tablero;
   $i = 0;   
 
 // BUCLE QUE OBTIENE CADA INDICADOR DEL USUARIOS REGISTRADO.
 foreach ($userIndicators as $userIndicator) {

     // CONSULTAS QUE OBTIENEN LOS DATOS DE UN INDICADOR ESPECIFICO.
     $faculty           = \DB::select('select PKG_CMI_FACULTIES.FUNC_GET_FACULTY(?) from dual',            [ $employeeNoRelated[0]->facultyid ]);
     $lastsState        = \DB::select('select PKG_CMI_INDICATOR_STATES.FUNC_GET_LASTSSTATE(?) from dual',  [ $userIndicator->indicatorid ]);
     $colorValues       = \DB::select('select PKG_CMI_COLORMETRIC.FUNC_GET_COLORVALUES(?) from dual',      [ $userIndicator->colormetricid ]);
     $colometric        = \DB::select('select PKG_CMI_COLORMETRIC.FUNC_GET_COLORMETRIC(?) from dual',      [ $userIndicator->colormetricid ]);
     $averageColor      = \DB::select('select PKG_CMI_COLORVALUE.FUNC_GET_COLORVALUE(?) from dual',        [ $userIndicator->actuallevel ] );


    //Define la colometría para el campo colorimetría de la tabla.
    /* 
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
   */
   
   /*--------------------------------------------------
     //PRUEBA PARA CADA INDICADOR
        $tamano=0;
      if ($userIndicator->indicatorid == 'ind-nueve') {
        $tamano = count($lastsState);
        break;
      }
   */


   //Count consulta el tamaño de lasstate para poder sacarle el promedio y le asigna el valor del score,
   //sino le asigna N/A para mostrarlo en Ultimas Alimentaciones.
   $lastsState_0_score = ''; $lastsState_1_score = ''; $lastsState_2_score = ''; $lastsState_3_score = ''; 
   $colometricAverage = 0.000;

   
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
    

    //Toma el promedio final de últimas alimentaciones y los compara con el
    //valor-inicial y último-valor para asignarle la colorimetría.
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


   //Frecuencia de alimentación de los indicadores.
   //Convierte la actualización en días, meses y años.
   $frecuenciaAlimentacion = '';

   if ($userIndicator->updatefrq == 1) {
     $frecuenciaAlimentacion = 'Diaria';
   }elseif ($userIndicator->updatefrq == 7) {
     $frecuenciaAlimentacion = 'Semanal';
   }elseif ($userIndicator->updatefrq == 15) {
     $frecuenciaAlimentacion = 'Quincenal';
   }elseif ($userIndicator->updatefrq == 30) {
     $frecuenciaAlimentacion = 'Mensual';
   }elseif ($userIndicator->updatefrq == 60) {
     $frecuenciaAlimentacion = 'Bimensual';
   }elseif ($userIndicator->updatefrq == 90) {
     $frecuenciaAlimentacion = 'Trimestral';
   }elseif ($userIndicator->updatefrq == 120) {
     $frecuenciaAlimentacion = 'Cuatrimestral';
   }elseif ($userIndicator->updatefrq == 180) {
     $frecuenciaAlimentacion = 'Semestral';
   }elseif ($userIndicator->updatefrq == 365) {
     $frecuenciaAlimentacion = 'Anual';
   }   
   
 //Arreglo de indicadores para la el tablero de control
  $tablero[$i++] = [
                    'employeeID'         => $employeeNoRelated[0]->employeeid,
                    'firstName'          => $employeeNoRelated[0]->firstname,
                    'lastName'           => $employeeNoRelated[0]->lastname,
                    'employeeActive'     => $employeeNoRelated[0]->active,

                    'indicatorid'        => $userIndicator->indicatorid, 
                    'indicatorname'      => $userIndicator->indicatorname, 
                    'categoryname'       => $userIndicator->categoryname, 
                    'updatefrq'          => $frecuenciaAlimentacion, 
                    'score'              => $userIndicator->score, 
                    'actualvalue'        => $userIndicator->actualvalue, 
                    'colometric'         => $colometric[0]->metricname, 
                    'desirevalue'        => $userIndicator->desirevalue, 

                    'averageColor1'      => $averageColor[0]->color, 

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



