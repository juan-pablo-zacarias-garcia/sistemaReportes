<?php

namespace App\Http\Controllers\Usuarios;
use Illuminate\Support\Facades\DB;

trait consultas
{
    //consulta para obtener todos los ranchos que existen
    var $queryRanchos=DB::select("Select DISTINCT RANCHO as RANCHOS from tablas where RANCHO!='0' order by RANCHO ASC;");

////////////////////////////tablaCostoXHa///////////////////
public function ftCostosXHa(){
    //Definimos las partes de la consulta
    $queryP1='';
    $queryP2='';
    $queryP3='';

    foreach($this->queryRanchos as $r){
        foreach($r as $d){
            $queryP1 = $queryP1.'tablaCostoXHa.['.$d.'],';
            $queryP2 = $queryP2.'CASE WHEN ['.$d.'] IS NULL THEN 0 ELSE ['.$d.'] END AS ['.$d.'],';
            $queryP3 = $queryP3.'['.$d.'],';
        }
    }
    
    //Quitamos la última coma que se le agrega
    $queryP1 = substr($queryP1, 0, strlen($queryP1)-1); 
    $queryP2 = substr($queryP2, 0, strlen($queryP2)-1); 
    $queryP3 = substr($queryP3, 0, strlen($queryP3)-1);


    //formamos la parte de casos de la consulta para que los nulos los cambie por cero
    $query="with tablaTotalCostoXHa as (select PRODUCTO,RANCHO,  sum(TOTAL_COSTO)/sum(HECTAREAS) CostoXHa from tablas where RANCHO!='0' group by  PRODUCTO, RANCHO)
    select tablaTotalCostoXHa.PRODUCTO as PRODUCTO,".$queryP1.", sum(tablaTotalCostoXHa.CostoXHa) Total from tablaTotalCostoXHa
    join
    (SELECT PRODUCTO,
    ".$queryP2."
    FROM (select RANCHO, PRODUCTO,  sum(TOTAL_COSTO)/sum(HECTAREAS) CostoXHa from tablas where RANCHO!='0' group by RANCHO, PRODUCTO) as tabla PIVOT (
        sum(CostoXHa) FOR RANCHO IN (".$queryP3.")
    ) as tabla2) as tablaCostoXHa 
    on tablaTotalCostoXHa.PRODUCTO = tablaCostoXHa.PRODUCTO 
    group by tablaTotalCostoXHa.PRODUCTO, ".$queryP1.";";
        return $query;
}
}

?>