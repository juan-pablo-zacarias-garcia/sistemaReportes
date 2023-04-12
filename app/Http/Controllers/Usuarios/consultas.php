<?php

//consulta para obtener todos los ranchos que existen
function queryRanchos()
{
    return "SELECT DISTINCT RANCHO as RANCHOS from horizontal where RANCHO!='0' order by RANCHO ASC;";
}

function queryHorizontal($anio)
{
    $anio = ($anio == "0") ? "" : "AND ANIO=" . $anio;
    return "SELECT * from horizontal WHERE CODIGO!='0' " . $anio;
}
function queryCostoXHa($Ranchos, $anio)
{
    //Definimos las partes de la consulta
    $queryP1 = '';
    $queryP2 = '';
    $queryP3 = '';

    foreach ($Ranchos as $r) {
        foreach ($r as $d) {
            $queryP1 = $queryP1 . 'tablaCostoXHa.[' . $d . '],';
            $queryP2 = $queryP2 . 'CASE WHEN [' . $d . '] IS NULL THEN 0 ELSE [' . $d . '] END AS [' . $d . '],';
            $queryP3 = $queryP3 . '[' . $d . '],';
        }
    }

    //Quitamos la última coma que se le agrega
    $queryP1 = substr($queryP1, 0, strlen($queryP1) - 1);
    $queryP2 = substr($queryP2, 0, strlen($queryP2) - 1);
    $queryP3 = substr($queryP3, 0, strlen($queryP3) - 1);

    return "SELECT PRODUCTO,
    " . $queryP2 . "
    FROM (select RANCHO, PRODUCTO,  sum(TOTAL_COSTO)/sum(HECTAREAS) CostoXHa from horizontal where RANCHO!='0' " . $anio . " group by RANCHO, PRODUCTO) as tabla PIVOT (
        sum(CostoXHa) FOR RANCHO IN (" . $queryP3 . ")
    ) as  tablaCostoXHa; ";
}
function queryCostoPromedioXHa($anio){
    return "Select PRODUCTO, sum(TOTAL_COSTO) as [Costo Total], sum(HECTAREAS) Hectareas, sum(TOTAL_COSTO)/sum(HECTAREAS) [Costo promedio por hectarea] from horizontal where RANCHO!='0' " . $anio . " group by PRODUCTO;";
}



function queryVentasXHa($Ranchos, $anio)
{
    //Definimos las partes de la consulta
    $queryP1 = '';
    $queryP2 = '';
    $queryP3 = '';
    foreach ($Ranchos as $r) {
        foreach ($r as $d) {
            $queryP1 = $queryP1 . 'tablaVentasXHa.[' . $d . '],';
            $queryP2 = $queryP2 . 'CASE WHEN [' . $d . '] IS NULL THEN 0 ELSE [' . $d . '] END AS [' . $d . '],';
            $queryP3 = $queryP3 . '[' . $d . '],';
        }
    }
    //Quitamos la última coma que se le agrega
    $queryP1 = substr($queryP1, 0, strlen($queryP1) - 1);
    $queryP2 = substr($queryP2, 0, strlen($queryP2) - 1);
    $queryP3 = substr($queryP3, 0, strlen($queryP3) - 1);
    return "SELECT PRODUCTO,
    " . $queryP2 . "
    FROM (select RANCHO, PRODUCTO,  sum(VENTAS_TOTALES)/sum(HECTAREAS) VentasXHa from horizontal where RANCHO!='0' " . $anio . " group by RANCHO, PRODUCTO) as tabla PIVOT (
    sum(VEntasXHa) FOR RANCHO IN (" . $queryP3 . ")
    ) as tablaVentasXHa
    ;";
}
function queryVentasPromedioXHa($anio){
    return "Select PRODUCTO, sum(VENTAS_TOTALES) as [Ventas Totales], sum(HECTAREAS) Hectareas, sum(VENTAS_TOTALES)/sum(HECTAREAS) [Promedio de ventas por hectarea] from horizontal where RANCHO!='0' " . $anio . " group by PRODUCTO;";
}

function queryRendimientoXHa($Ranchos, $anio){
    //Definimos las partes de la consulta
    $queryP1='';
    $queryP2='';
    $queryP3='';
    foreach($Ranchos as $r){
        foreach($r as $d){
            $queryP1 = $queryP1.'tablaRendimientoXHa.['.$d.'],';
            $queryP2 = $queryP2.'CASE WHEN ['.$d.'] IS NULL THEN 0 ELSE ['.$d.'] END AS ['.$d.'],';
            $queryP3 = $queryP3.'['.$d.'],';
        }
    }
    //Quitamos la última coma que se le agrega
    $queryP1 = substr($queryP1, 0, strlen($queryP1)-1); 
    $queryP2 = substr($queryP2, 0, strlen($queryP2)-1); 
    $queryP3 = substr($queryP3, 0, strlen($queryP3)-1);
    return "SELECT PRODUCTO,
    ".$queryP2."
    FROM (select RANCHO, PRODUCTO,  sum(KGS_TOTALES)/sum(HECTAREAS) RendimientoXHa from horizontal where RANCHO!='0' ".$anio." group by RANCHO, PRODUCTO) as tabla PIVOT (
        sum(RendimientoXHa) FOR RANCHO IN (".$queryP3.")
        ) as tablaRendimientoXHa ";
}

function queryRendimientoPromedioXHa($anio){
    return "Select PRODUCTO, sum(KGS_TOTALES) as [Total Kg], sum(HECTAREAS) Hectareas, sum(KGS_TOTALES)/sum(HECTAREAS) [Rendimiento promedio por hectarea] from horizontal where RANCHO!='0' " . $anio . " group by PRODUCTO;";
}

function queryResultadosXCultivo($Ranchos, $anio){
    //Definimos las partes de la consulta
    $queryP1='';
    $queryP2='';
    $queryP3='';
    foreach($Ranchos as $r){
        foreach($r as $d){
            $queryP1 = $queryP1.'tablaResultadosXCultivo.['.$d.'],';
            $queryP2 = $queryP2.'CASE WHEN ['.$d.'] IS NULL THEN 0 ELSE ['.$d.'] END AS ['.$d.'],';
            $queryP3 = $queryP3.'['.$d.'],';
        }
    }
    //Quitamos la última coma que se le agrega
    $queryP1 = substr($queryP1, 0, strlen($queryP1)-1); 
    $queryP2 = substr($queryP2, 0, strlen($queryP2)-1); 
    $queryP3 = substr($queryP3, 0, strlen($queryP3)-1);

    return "SELECT PRODUCTO,
    ".$queryP2."
    FROM (select RANCHO, PRODUCTO,  sum(UTILIDAD_O_PERDIDA)/sum(HECTAREAS) ResultadosXCultivo from horizontal where RANCHO!='0' ".$anio." group by RANCHO, PRODUCTO) as tabla PIVOT (
        sum(ResultadosXCultivo) FOR RANCHO IN (".$queryP3.")
        ) as tablaResultadosXCultivo";
}

function queryResultadosPromedioXCultivo($anio){
    return "Select PRODUCTO, sum(UTILIDAD_O_PERDIDA) as [Utilidad o pérdida], sum(HECTAREAS) Hectareas, sum(UTILIDAD_O_PERDIDA)/sum(HECTAREAS) [Utilidad o pérdida promedio por hectarea] from horizontal where RANCHO!='0' " . $anio . " group by PRODUCTO;";
}

function queryAgroquimicosXHa($Ranchos, $anio){
    //Definimos las partes de la consulta
    $queryP1='';
    $queryP2='';
    $queryP3='';
    foreach($Ranchos as $r){
        foreach($r as $d){
            $queryP1 = $queryP1.'tablaAgroquimicosXHa.['.$d.'],';
            $queryP2 = $queryP2.'CASE WHEN ['.$d.'] IS NULL THEN 0 ELSE ['.$d.'] END AS ['.$d.'],';
            $queryP3 = $queryP3.'['.$d.'],';
        }
    }
    //Quitamos la última coma que se le agrega
    $queryP1 = substr($queryP1, 0, strlen($queryP1)-1); 
    $queryP2 = substr($queryP2, 0, strlen($queryP2)-1); 
    $queryP3 = substr($queryP3, 0, strlen($queryP3)-1);
    return "SELECT PRODUCTO,
    ".$queryP2."
    FROM (select RANCHO, PRODUCTO,  sum(AGROQUIMICOS)/sum(HECTAREAS) AgroquimicosXHa from horizontal where RANCHO!='0' ".$anio." group by RANCHO, PRODUCTO) as tabla PIVOT (
        sum(AgroquimicosXHa) FOR RANCHO IN (".$queryP3.")
        ) as tablaAgroquimicosXHa";
}
function queryAgroquimicosPromedioXHa($anio){
    return "Select PRODUCTO, sum(AGROQUIMICOS) as [Agroquímicos], sum(HECTAREAS) Hectareas, sum(AGROQUIMICOS)/sum(HECTAREAS) [Promedio de agroquímicos por hectarea] from horizontal where RANCHO!='0' " . $anio . " group by PRODUCTO;";
}

function fertilizantesXHa($Ranchos, $anio){
    //Definimos las partes de la consulta
    $queryP1='';
    $queryP2='';
    $queryP3='';
    foreach($Ranchos as $r){
        foreach($r as $d){
            $queryP1 = $queryP1.'tablaFertilizantesXHa.['.$d.'],';
            $queryP2 = $queryP2.'CASE WHEN ['.$d.'] IS NULL THEN 0 ELSE ['.$d.'] END AS ['.$d.'],';
            $queryP3 = $queryP3.'['.$d.'],';
        }
    }
    
    //Quitamos la última coma que se le agrega
    $queryP1 = substr($queryP1, 0, strlen($queryP1)-1); 
    $queryP2 = substr($queryP2, 0, strlen($queryP2)-1); 
    $queryP3 = substr($queryP3, 0, strlen($queryP3)-1);

    return "SELECT PRODUCTO,
    ".$queryP2."
    FROM (select RANCHO, PRODUCTO,  sum(FERTILIZANTES)/sum(HECTAREAS) FertilizantesXHa from horizontal where RANCHO!='0' ".$anio." group by RANCHO, PRODUCTO) as tabla PIVOT (
        sum(FertilizantesXHa) FOR RANCHO IN (".$queryP3.")
        ) as tablaFertilizantesXHa";
}
function fertilizantesPromedioXHa($anio){
    return "Select PRODUCTO, sum(FERTILIZANTES) as [Fertilizantes], sum(HECTAREAS) Hectareas, sum(FERTILIZANTES)/sum(HECTAREAS) [Promedio de fertilizante por hectarea] from horizontal where RANCHO!='0' " . $anio . " group by PRODUCTO;";
}
function queryPlantulaXHa($Ranchos, $anio){
    //Definimos las partes de la consulta
    $queryP1='';
    $queryP2='';
    $queryP3='';
    foreach($Ranchos as $r){
        foreach($r as $d){
            $queryP1 = $queryP1.'tablaPlantulaXHa.['.$d.'],';
            $queryP2 = $queryP2.'CASE WHEN ['.$d.'] IS NULL THEN 0 ELSE ['.$d.'] END AS ['.$d.'],';
            $queryP3 = $queryP3.'['.$d.'],';
        }
    }
    
    //Quitamos la última coma que se le agrega
    $queryP1 = substr($queryP1, 0, strlen($queryP1)-1); 
    $queryP2 = substr($queryP2, 0, strlen($queryP2)-1); 
    $queryP3 = substr($queryP3, 0, strlen($queryP3)-1);
    return "SELECT PRODUCTO,
    ".$queryP2."
    FROM (select RANCHO, PRODUCTO,  sum(PLANTULA)/sum(HECTAREAS) PlantulaXHa from horizontal where RANCHO!='0' ".$anio." group by RANCHO, PRODUCTO) as tabla PIVOT (
        sum(PlantulaXHa) FOR RANCHO IN (".$queryP3.")
        ) as tablaPlantulaXHa";
}

function queryPlantulaPromedioXHa($anio){
    return "Select PRODUCTO, sum(PLANTULA) as [Plántula], sum(HECTAREAS) Hectareas, sum(PLANTULA)/sum(HECTAREAS) [Promedio de plántula por hectarea] from horizontal where RANCHO!='0' " . $anio . " group by PRODUCTO;";
}

function queryGraficaPromedios($anio){
    return "Select PRODUCTO, 
    sum(TOTAL_COSTO)/sum(HECTAREAS) [Costo promedio por hectarea],
    sum(VENTAS_TOTALES)/sum(HECTAREAS) [Promedio de ventas por hectarea],
    sum(KGS_TOTALES)/sum(HECTAREAS) [Rendimiento promedio por hectarea],
    sum(UTILIDAD_O_PERDIDA)/sum(HECTAREAS) [Utilidad o pérdida promedio por hectarea],
    sum(AGROQUIMICOS)/sum(HECTAREAS) [Promedio de agroquímicos por hectarea],
    sum(FERTILIZANTES)/sum(HECTAREAS) [Promedio de fertilizante por hectarea],
    sum(PLANTULA)/sum(HECTAREAS) [Promedio de plántula por hectarea]
    from horizontal where RANCHO!='0' " . $anio . " group by PRODUCTO;";
}

?>