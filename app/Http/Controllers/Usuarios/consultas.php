<?php


//////////retorna el where de las consultas de las tablas, el where se forma con el año, meses[] y semanas[]
function filtroWhereTablas($anio, $meses, $semanas){
    $where = "";
    $anio = "AND ANIO=" . $anio;
    $m = "('x'";
    //si los meses no estan vacios
    if(!empty($meses)){
        foreach($meses as $mes){
            $m.=",'".$mes."'";
        }
    }
    $m.=")";

    $sem = "(0";
    //si las semanas no están vacias
    if(!empty($semanas)){
        foreach($semanas as $semana){
            $sem.=",".intval($semana)."";
        }
    }
    $sem.=")";

    $where.=$anio." AND MES in ".$m." AND SEMANA in ".$sem;
    return $where;
}


////////////////////////obtiene los meses de un año del horizontal
function queryMesesAnio($anio){
    return "SELECT DISTINCT MES from horizontal where TABLA!='0' AND ANIO=".$anio." order by MES ASC";
}

///////////////////obtiene las semanas de los meses
function querySemanasMes($anio, $meses){
    $m="''";
    foreach($meses as $mes){
        $m.=",'".$mes."'";
    }
    return "SELECT DISTINCT SEMANA from horizontal where TABLA!='0' AND ANIO=".$anio." AND MES in (".$m.") order by SEMANA ASC";
}
//////////////////consulta para obtener todos los ranchos que existen
function queryRanchos()
{
    return "SELECT DISTINCT RANCHO as RANCHOS from horizontal where TABLA!='0' order by RANCHO ASC;";
}

/////////////recibe el año, meses[] y semanas[] para realizar el filtrado
function queryHorizontal($anio, $meses, $semanas)
{
    return "SELECT ANIO,MES,SEMANA,TABLA,PRODUCTO,CODIGO,FORMAT(HECTAREAS,'#,##0.00') AS HECTAREAS,RANCHO,OBSERVACIONES,FORMAT(REND_KG_X_HA,'#,##0.00') AS REND_KG_X_HA,FORMAT(KGS_TOTALES,'#,##0.00') AS KGS_TOTALES,B,FORMAT(PLANTULA,'$#,##0.00') AS PLANTULA,FORMAT(AGROQUIMICOS,'$#,##0.00') AS AGROQUIMICOS,FORMAT(FERTILIZANTES,'$#,##0.00') AS FERTILIZANTES,FORMAT(MANO_DE_OBRA1,'$#,##0.00') AS MANO_DE_OBRA1,FORMAT(FLETES1,'$#,##0.00') AS FLETES1,FORMAT(RENTA,'$#,##0.00') AS RENTA,FORMAT(MAQUILA1,'$#,##0.00') AS MAQUILA1,FORMAT(EMPAQUE1,'$#,##0.00') AS EMPAQUE1,C,FORMAT(TOTAL_DIRECTOS,'$#,##0.00') AS TOTAL_DIRECTOS,FORMAT(TOTAL_INDIRECTOS,'$#,##0.00') AS TOTAL_INDIRECTOS,FORMAT(TOTAL_COSTO,'$#,##0.00') AS TOTAL_COSTO,FORMAT(COSTO_X_HA,'$#,##0.00') AS COSTO_X_HA,D,FORMAT(COSTO_DE_EMPAQUE,'$#,##0.00') AS COSTO_DE_EMPAQUE,FORMAT(NO_CAJAS1,'$#,##0.00') AS NO_CAJAS1,E,FORMAT(MANO_DE_OBRA2,'$#,##0.00') AS MANO_DE_OBRA2,FORMAT(FLETES2,'$#,##0.00') AS FLETES2,FORMAT(MAQUILA2,'$#,##0.00') AS MAQUILA2,FORMAT(EMPAQUE2,'$#,##0.00') AS EMPAQUE2,FORMAT(TOTAL_COSTO_EMPAQUE,'$#,##0.00') AS TOTAL_COSTO_EMPAQUE,F1,FORMAT(CAJAS_MERMADAS1,'$#,##0.00') AS CAJAS_MERMADAS1,FORMAT(NO_CAJAS2,'$#,##0.00') AS NO_CAJAS2,G1,FORMAT(MANO_DE_OBRA3,'$#,##0.00') AS MANO_DE_OBRA3,FORMAT(FLETES3,'$#,##0.00') AS FLETES3,FORMAT(MAQUILA3,'$#,##0.00') AS MAQUILA3,FORMAT(EMPAQUE3,'$#,##0.00') AS EMPAQUE3,FORMAT(TOTAL_MERMAS,'$#,##0.00') AS TOTAL_MERMAS,FORMAT(COSTO_TOTAL,'$#,##0.00') AS COSTO_TOTAL,H,FORMAT(VENTAS_EXPOR,'$#,##0.00') AS VENTAS_EXPOR,FORMAT(VENTAS_EMPAQUE,'$#,##0.00') AS VENTAS_EMPAQUE,FORMAT(VENTAS_TAYLOR,'$#,##0.00') AS VENTAS_TAYLOR,FORMAT(VENTAS_FRESH_EXPRESS,'$#,##0.00') AS VENTAS_FRESH_EXPRESS,FORMAT(VENTAS_GRANEL,'$#,##0.00') AS VENTAS_GRANEL,FORMAT(VENTAS_RANCHO_VIEJO,'$#,##0.00') AS VENTAS_RANCHO_VIEJO,FORMAT(VENTAS_ROYAL_ROSE,'$#,##0.00') AS VENTAS_ROYAL_ROSE,FORMAT(VENTAS_AVALON,'$#,##0.00') AS VENTAS_AVALON,FORMAT(COM_MONTERREY,'$#,##0.00') AS COM_MONTERREY,FORMAT(COM_GUADALAJARA,'$#,##0.00') AS COM_GUADALAJARA,FORMAT(VENTAS_ESA_FRESH,'$#,##0.00') AS VENTAS_ESA_FRESH,FORMAT(OTROS_CLIENTES,'$#,##0.00') AS OTROS_CLIENTES,FORMAT(VENTAS_TOTALES,'$#,##0.00') AS VENTAS_TOTALES,I1,FORMAT(UTILIDAD_O_PERDIDA,'$#,##0.00') AS UTILIDAD_O_PERDIDA from horizontal WHERE CODIGO!='0' ".filtroWhereTablas($anio, $meses, $semanas);
}
//recibe el año, meses[], semanas[], producto, rancho y las columnas(tipo string) que se mostrarán
function queryDetalle($anio,$meses, $semanas, $producto,$rancho, $cols)
{
    $cols='ANIO as AÑO, MES, SEMANA, TABLA, PRODUCTO, FORMAT(HECTAREAS,\'#,##0.00\') AS HECTAREAS, RANCHO,'.$cols.' , FORMAT(UTILIDAD_O_PERDIDA,\'$#,##0.00\') AS [UTILIDAD O PERDIDA]';
    $rancho = ($rancho=='all'?'':"AND RANCHO='".$rancho."'");
    return "SELECT ".$cols." from horizontal WHERE CODIGO!='0' AND PRODUCTO='" .$producto. "' " . $rancho . " ".filtroWhereTablas($anio, $meses, $semanas);
}
function queryCostoXHa($Ranchos, $anio, $meses, $semanas)
{
    //Definimos las partes de la consulta    
    $queryP2 = '';
    $queryP3 = '';
    foreach ($Ranchos as $r) {
        foreach ($r as $d) {
            
            $queryP2 = $queryP2 . 'FORMAT((CASE WHEN [' . $d . '] IS NULL THEN 0 ELSE [' . $d . '] END),\'$#,##0.00\') AS [' . $d . '],';
            $queryP3 = $queryP3 . '[' . $d . '],';
        }
    }
    //Quitamos la última coma que se le agrega
    $queryP2 = substr($queryP2, 0, strlen($queryP2) - 1);
    $queryP3 = substr($queryP3, 0, strlen($queryP3) - 1);
    return "SELECT PRODUCTO,
    " . $queryP2 . "
    FROM (select RANCHO, PRODUCTO,  sum(TOTAL_COSTO)/sum(HECTAREAS) CostoXHa from horizontal where RANCHO!='0' " .filtroWhereTablas($anio, $meses, $semanas). " group by RANCHO, PRODUCTO) as tabla PIVOT (
        sum(CostoXHa) FOR RANCHO IN (" . $queryP3 . ")
    ) as  tablaCostoXHa;";
}
function queryCostoPromedioXHa($anio, $meses, $semanas){
    return "Select PRODUCTO, FORMAT(sum(TOTAL_COSTO),'$#,##0.00') as [Costo Total], sum(HECTAREAS) Hectareas, FORMAT(sum(TOTAL_COSTO)/sum(HECTAREAS),'$#,##0.00') [Costo promedio por hectarea] from horizontal where RANCHO!='0' " . filtroWhereTablas($anio, $meses, $semanas) . " group by PRODUCTO;";
}



function queryVentasXHa($Ranchos, $anio, $meses, $semanas)
{
    //Definimos las partes de la consulta
    
    $queryP2 = '';
    $queryP3 = '';
    foreach ($Ranchos as $r) {
        foreach ($r as $d) {
            $queryP2 = $queryP2 . 'FORMAT((CASE WHEN [' . $d . '] IS NULL THEN 0 ELSE [' . $d . '] END),\'$#,##0.00\') AS [' . $d . '],';
            $queryP3 = $queryP3 . '[' . $d . '],';
        }
    }
    //Quitamos la última coma que se le agrega
    $queryP2 = substr($queryP2, 0, strlen($queryP2) - 1);
    $queryP3 = substr($queryP3, 0, strlen($queryP3) - 1);
    return "SELECT PRODUCTO,
    " . $queryP2 . "
    FROM (select RANCHO, PRODUCTO,  sum(VENTAS_TOTALES)/sum(HECTAREAS) VentasXHa from horizontal where RANCHO!='0' " . filtroWhereTablas($anio, $meses, $semanas) . " group by RANCHO, PRODUCTO) as tabla PIVOT (
    sum(VEntasXHa) FOR RANCHO IN (" . $queryP3 . ")
    ) as tablaVentasXHa
    ;";
}
function queryVentasPromedioXHa($anio, $meses, $semanas){
    return "Select PRODUCTO, FORMAT(sum(VENTAS_TOTALES),'$#,##0.00') as [Ventas Totales], sum(HECTAREAS) Hectareas, FORMAT(sum(VENTAS_TOTALES)/sum(HECTAREAS),'$#,##0.00') [Promedio de ventas por hectarea] from horizontal where RANCHO!='0' " . filtroWhereTablas($anio, $meses, $semanas) . " group by PRODUCTO;";
}
function queryRendimientoXHa($Ranchos, $anio, $meses, $semanas){
    //Definimos las partes de la consulta
    
    $queryP2='';
    $queryP3='';
    foreach($Ranchos as $r){
        foreach($r as $d){
            $queryP2 = $queryP2.'FORMAT((CASE WHEN ['.$d.'] IS NULL THEN 0 ELSE ['.$d.'] END),\'#,##0.00 Kg\') AS ['.$d.'],';
            $queryP3 = $queryP3.'['.$d.'],';
        }
    }
    //Quitamos la última coma que se le agrega
    $queryP2 = substr($queryP2, 0, strlen($queryP2)-1); 
    $queryP3 = substr($queryP3, 0, strlen($queryP3)-1);
    return "SELECT PRODUCTO,
    ".$queryP2."
    FROM (select RANCHO, PRODUCTO,  sum(KGS_TOTALES)/sum(HECTAREAS) RendimientoXHa from horizontal where RANCHO!='0' ".filtroWhereTablas($anio, $meses, $semanas)." group by RANCHO, PRODUCTO) as tabla PIVOT (
        sum(RendimientoXHa) FOR RANCHO IN (".$queryP3.")
        ) as tablaRendimientoXHa";
}

function queryRendimientoPromedioXHa($anio, $meses, $semanas){
    return "Select PRODUCTO, FORMAT(sum(KGS_TOTALES),'#,##0.00 Kg') as [Total Kg], sum(HECTAREAS) Hectareas, FORMAT(sum(KGS_TOTALES)/sum(HECTAREAS),'#,##0.00 Kg') [Rendimiento promedio por hectarea] from horizontal where RANCHO!='0' " . filtroWhereTablas($anio, $meses, $semanas) . " group by PRODUCTO;";
}

function queryResultadosXCultivo($Ranchos, $anio, $meses, $semanas){
    //Definimos las partes de la consulta
    
    $queryP2='';
    $queryP3='';
    foreach($Ranchos as $r){
        foreach($r as $d){
            $queryP2 = $queryP2.'FORMAT((CASE WHEN ['.$d.'] IS NULL THEN 0 ELSE ['.$d.'] END),\'$#,##0.00\') AS ['.$d.'],';
            $queryP3 = $queryP3.'['.$d.'],';
        }
    }
    //Quitamos la última coma que se le agrega
    $queryP2 = substr($queryP2, 0, strlen($queryP2)-1); 
    $queryP3 = substr($queryP3, 0, strlen($queryP3)-1);

    return "SELECT PRODUCTO,
    ".$queryP2."
    FROM (select RANCHO, PRODUCTO,  sum(UTILIDAD_O_PERDIDA)/sum(HECTAREAS) ResultadosXCultivo from horizontal where RANCHO!='0' ".filtroWhereTablas($anio, $meses, $semanas)." group by RANCHO, PRODUCTO) as tabla PIVOT (
        sum(ResultadosXCultivo) FOR RANCHO IN (".$queryP3.")
        ) as tablaResultadosXCultivo";
}

function queryResultadosPromedioXCultivo($anio, $meses, $semanas){
    return "Select PRODUCTO, FORMAT(sum(UTILIDAD_O_PERDIDA),'$#,##0.00') as [Utilidad o pérdida], sum(HECTAREAS) Hectareas, FORMAT(sum(UTILIDAD_O_PERDIDA)/sum(HECTAREAS),'$#,##0.00') [Utilidad o pérdida promedio por hectarea] from horizontal where RANCHO!='0' " . filtroWhereTablas($anio, $meses, $semanas) . " group by PRODUCTO;";
}

function queryAgroquimicosXHa($Ranchos, $anio, $meses, $semanas){
    //Definimos las partes de la consulta
    
    $queryP2='';
    $queryP3='';
    foreach($Ranchos as $r){
        foreach($r as $d){
            $queryP2 = $queryP2.'FORMAT((CASE WHEN ['.$d.'] IS NULL THEN 0 ELSE ['.$d.'] END),\'$#,##0.00\') AS ['.$d.'],';
            $queryP3 = $queryP3.'['.$d.'],';
        }
    }
    //Quitamos la última coma que se le agrega
    $queryP2 = substr($queryP2, 0, strlen($queryP2)-1); 
    $queryP3 = substr($queryP3, 0, strlen($queryP3)-1);
    return "SELECT PRODUCTO,
    ".$queryP2."
    FROM (select RANCHO, PRODUCTO,  sum(AGROQUIMICOS)/sum(HECTAREAS) AgroquimicosXHa from horizontal where RANCHO!='0' ".filtroWhereTablas($anio, $meses, $semanas)." group by RANCHO, PRODUCTO) as tabla PIVOT (
        sum(AgroquimicosXHa) FOR RANCHO IN (".$queryP3.")
        ) as tablaAgroquimicosXHa";
}
function queryAgroquimicosPromedioXHa($anio, $meses, $semanas){
    return "Select PRODUCTO, FORMAT(sum(AGROQUIMICOS),'$#,##0.00') as [Agroquímicos], sum(HECTAREAS) Hectareas, FORMAT(sum(AGROQUIMICOS)/sum(HECTAREAS),'$#,##0.00') [Promedio de agroquímicos por hectarea] from horizontal where RANCHO!='0' " .filtroWhereTablas($anio, $meses, $semanas) . " group by PRODUCTO;";
}

function fertilizantesXHa($Ranchos, $anio, $meses, $semanas){
    //Definimos las partes de la consulta
    
    $queryP2='';
    $queryP3='';
    foreach($Ranchos as $r){
        foreach($r as $d){
            $queryP2 = $queryP2.'FORMAT((CASE WHEN ['.$d.'] IS NULL THEN 0 ELSE ['.$d.'] END),\'$#,##0.00\') AS ['.$d.'],';
            $queryP3 = $queryP3.'['.$d.'],';
        }
    }
    
    //Quitamos la última coma que se le agrega
    $queryP2 = substr($queryP2, 0, strlen($queryP2)-1); 
    $queryP3 = substr($queryP3, 0, strlen($queryP3)-1);

    return "SELECT PRODUCTO,
    ".$queryP2."
    FROM (select RANCHO, PRODUCTO,  sum(FERTILIZANTES)/sum(HECTAREAS) FertilizantesXHa from horizontal where RANCHO!='0' ".filtroWhereTablas($anio, $meses, $semanas)." group by RANCHO, PRODUCTO) as tabla PIVOT (
        sum(FertilizantesXHa) FOR RANCHO IN (".$queryP3.")
        ) as tablaFertilizantesXHa";
}
function fertilizantesPromedioXHa($anio, $meses, $semanas){
    return "Select PRODUCTO, FORMAT(sum(FERTILIZANTES),'$#,##0.00') as [Fertilizantes], sum(HECTAREAS) Hectareas, FORMAT(sum(FERTILIZANTES)/sum(HECTAREAS),'$#,##0.00') [Promedio de fertilizante por hectarea] from horizontal where RANCHO!='0' " . filtroWhereTablas($anio, $meses, $semanas) . " group by PRODUCTO;";
}
function queryPlantulaXHa($Ranchos, $anio, $meses, $semanas){
    //Definimos las partes de la consulta
    
    $queryP2='';
    $queryP3='';
    foreach($Ranchos as $r){
        foreach($r as $d){
            $queryP2 = $queryP2.'FORMAT((CASE WHEN ['.$d.'] IS NULL THEN 0 ELSE ['.$d.'] END),\'$#,##0.00\') AS ['.$d.'],';
            $queryP3 = $queryP3.'['.$d.'],';
        }
    }
    
    //Quitamos la última coma que se le agrega
    $queryP2 = substr($queryP2, 0, strlen($queryP2)-1); 
    $queryP3 = substr($queryP3, 0, strlen($queryP3)-1);
    return "SELECT PRODUCTO,
    ".$queryP2."
    FROM (select RANCHO, PRODUCTO,  sum(PLANTULA)/sum(HECTAREAS) PlantulaXHa from horizontal where RANCHO!='0' ".filtroWhereTablas($anio, $meses, $semanas)." group by RANCHO, PRODUCTO) as tabla PIVOT (
        sum(PlantulaXHa) FOR RANCHO IN (".$queryP3.")
        ) as tablaPlantulaXHa";
}

function queryPlantulaPromedioXHa($anio, $meses, $semanas){
    return "Select PRODUCTO, FORMAT(sum(PLANTULA),'$#,##0.00') as [Plántula], sum(HECTAREAS) Hectareas, FORMAT(sum(PLANTULA)/sum(HECTAREAS),'$#,##0.00') [Promedio de plántula por hectarea] from horizontal where RANCHO!='0' " . filtroWhereTablas($anio, $meses, $semanas) . " group by PRODUCTO;";
}

function queryGraficaPromedios($anio, $meses, $semanas){
    return "Select PRODUCTO, 
    sum(TOTAL_COSTO)/sum(HECTAREAS) [Costo promedio por hectarea $],
    sum(VENTAS_TOTALES)/sum(HECTAREAS) [Promedio de ventas por hectarea $],
    sum(KGS_TOTALES)/sum(HECTAREAS) [Rendimiento promedio por hectarea (KG)],
    sum(UTILIDAD_O_PERDIDA)/sum(HECTAREAS) [Utilidad o pérdida promedio por hectarea $],
    sum(AGROQUIMICOS)/sum(HECTAREAS) [Promedio de agroquímicos por hectarea $],
    sum(FERTILIZANTES)/sum(HECTAREAS) [Promedio de fertilizante por hectarea $],
    sum(PLANTULA)/sum(HECTAREAS) [Promedio de plántula por hectarea $]
    from horizontal where RANCHO!='0' " . filtroWhereTablas($anio, $meses, $semanas) . " group by PRODUCTO;";
}

?>