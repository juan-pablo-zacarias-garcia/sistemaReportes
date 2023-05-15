<?php

//////////retorna el where de las consultas de las tablas, el where se forma con el año, meses[] y semanas[]
function filtroWhereTablas($anio, $meses, $semanas, $tipoCultivo){
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

    //si el tipo de cultivo no está vacio
    if($tipoCultivo!=[]){
        $tipoC="(";
        //genera la parte de la consulta para filtrar por tipo de cultivo, se toma como referencia el nombre de los Productos
        foreach($tipoCultivo as $tipo){
            switch($tipo){
                case "CONVENCIONAL":
                    // Se agrega la función COLLATE para que no sea sensible a mayúsculas, minúsculas ni acentos
                    $tipoC.="PRODUCTO COLLATE SQL_Latin1_General_Cp1_CI_AI NOT LIKE ('%ORGANICO%')";
                    break;
                case "ORGANICO":
                    $tipoC.="PRODUCTO COLLATE SQL_Latin1_General_Cp1_CI_AI LIKE ('%ORGANICO%')";
                    break;
                default:
                    $tipoC.="PRODUCTO LIKE ('%NINGUNO%')";
                    break;
            }
            //si no es el último elemento del arreglo agrega 'or'
            if(end($tipoCultivo)!=$tipo){
                $tipoC.=" or ";
            }            
        }
        $tipoC.=") ";
        $where.=$anio." AND MES in ".$m." AND SEMANA in ".$sem." AND ".$tipoC;
    return $where;
    }else{
        return $where;
    }
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
function queryHorizontal($anio, $meses, $semanas, $tipoCultivo)
{
    return "SELECT ANIO,MES,SEMANA,TABLA,PRODUCTO,CODIGO,FORMAT(HECTAREAS,'#,##0.00') AS HECTAREAS,RANCHO,OBSERVACIONES,
    FORMAT(REND_KG_X_Ha,'#,##0.00') AS REND_KG_X_Ha,FORMAT(KGS_TOTALES,'#,##0.00') AS KGS_TOTALES,B,FORMAT(PLANTULA,'$#,##0.00') AS PLANTULA,
    FORMAT(PLANTULA/HECTAREAS,'$#,##0.00') AS [PLANTULA POR Ha],FORMAT(AGROQUIMICOS,'$#,##0.00') AS AGROQUIMICOS, 
    FORMAT(AGROQUIMICOS/HECTAREAS,'$#,##0.00') AS [AGROQUIMICOS POR Ha],FORMAT(FERTILIZANTES,'$#,##0.00') AS FERTILIZANTES,
    FORMAT(FERTILIZANTES/HECTAREAS,'$#,##0.00') AS [FERTILIZANTES POR Ha],FORMAT(MANO_DE_OBRA1,'$#,##0.00') AS [MANO DE OBRA 1],
    FORMAT(MANO_DE_OBRA1/HECTAREAS,'$#,##0.00') AS [MANO DE OBRA 1 POR Ha],FORMAT(FLETES1,'$#,##0.00') AS FLETES1,FORMAT(FLETES1/HECTAREAS,'$#,##0.00') AS [FLETES 1 POR Ha],
    FORMAT(RENTA,'$#,##0.00') AS RENTA,FORMAT(RENTA/HECTAREAS,'$#,##0.00') AS [RENTA POR Ha],FORMAT(MAQUILA1,'$#,##0.00') AS MAQUILA1,FORMAT(MAQUILA1/HECTAREAS,'$#,##0.00') AS [MAQUILA 1 POR Ha],
    FORMAT(EMPAQUE1,'$#,##0.00') AS EMPAQUE1,FORMAT(EMPAQUE1/HECTAREAS,'$#,##0.00') AS [EMPAQUE 1 POR Ha],C,FORMAT(TOTAL_DIRECTOS,'$#,##0.00') AS [TOTAL DIRECTOS],FORMAT(TOTAL_DIRECTOS/HECTAREAS,'$#,##0.00') AS [TOTAL DIRECTOS POR Ha],
    FORMAT(TOTAL_INDIRECTOS,'$#,##0.00') AS [TOTAL INDIRECTOS], FORMAT(TOTAL_INDIRECTOS/HECTAREAS,'$#,##0.00') AS [TOTAL INDIRECTOS POR Ha],FORMAT(TOTAL_COSTO,'$#,##0.00') AS TOTAL_COSTO,
    FORMAT(COSTO_X_Ha,'$#,##0.00') AS [COSTO POR Ha],D,FORMAT(COSTO_DE_EMPAQUE,'$#,##0.00') AS [COSTO DE EMPAQUE], NO_CAJAS1,E,
    FORMAT(MANO_DE_OBRA2,'$#,##0.00') AS [MANO DE OBRA 2],FORMAT(FLETES2,'$#,##0.00') AS FLETES2,FORMAT(MAQUILA2,'$#,##0.00') AS MAQUILA2,
    FORMAT(EMPAQUE2,'$#,##0.00') AS EMPAQUE2,FORMAT(TOTAL_COSTO_EMPAQUE,'$#,##0.00') AS TOTAL_COSTO_EMPAQUE,F1,
    FORMAT(CAJAS_MERMADAS1,'$#,##0.00') AS [CAJAS MERMADAS 1],FORMAT(NO_CAJAS2,'$#,##0.00') AS NO_CAJAS2,G1,
    FORMAT(MANO_DE_OBRA3,'$#,##0.00') AS [MANO DE OBRA 3],FORMAT(FLETES3,'$#,##0.00') AS FLETES3,
    FORMAT(MAQUILA3,'$#,##0.00') AS MAQUILA3,FORMAT(EMPAQUE3,'$#,##0.00') AS EMPAQUE3,FORMAT(TOTAL_MERMAS,'$#,##0.00') AS [TOTAL MERMAS],
    FORMAT(COSTO_TOTAL,'$#,##0.00') AS [COSTO TOTAL],H,FORMAT(VENTAS_EXPOR,'$#,##0.00') AS [VENTAS EXPOR],
    FORMAT(VENTAS_EMPAQUE,'$#,##0.00') AS [VENTAS EMPAQUE],FORMAT(VENTAS_TAYLOR,'$#,##0.00') AS [VENTAS TAYLOR],
    FORMAT(VENTAS_FRESH_EXPRESS,'$#,##0.00') AS [VENTAS FRESH EXPRESS],FORMAT(VENTAS_GRANEL,'$#,##0.00') AS [VENTAS GRANEL],
    FORMAT(VENTAS_RANCHO_VIEJO,'$#,##0.00') AS [VENTAS RANCHO VIEJO],FORMAT(VENTAS_ROYAL_ROSE,'$#,##0.00') AS [VENTAS ROYAL ROSE],
    FORMAT(VENTAS_AVALON,'$#,##0.00') AS [VENTAS AVALON],FORMAT(COM_MONTERREY,'$#,##0.00') AS [COM MONTERREY],
    FORMAT(COM_GUADALAJARA,'$#,##0.00') AS [COM GUADALAJARA],FORMAT(VENTAS_ESA_FRESH,'$#,##0.00') AS [VENTAS ESA FRESH],
    FORMAT(OTROS_CLIENTES,'$#,##0.00') AS [OTROS CLIENTES],FORMAT(VENTAS_TOTALES,'$#,##0.00') AS [VENTAS TOTALES],I1,
    FORMAT(UTILIDAD_O_PERDIDA,'$#,##0.00') AS [UTILIDAD O PERDIDA] from horizontal WHERE CODIGO!='0' ".filtroWhereTablas($anio, $meses, $semanas,$tipoCultivo);
}

//recibe el año, meses[], semanas[], producto, rancho y las columnas(tipo string) que se mostrarán
function queryDetalle($anio,$meses, $semanas, $producto,$rancho, $cols, $tipoCultivo)
{
    $cols='ANIO as AÑO, MES, SEMANA, TABLA, PRODUCTO, RANCHO,FORMAT(HECTAREAS,\'#,##0.00\') AS HECTAREAS,'.$cols;
    $rancho = ($rancho=='all'?'':"AND RANCHO='".$rancho."'");
    return "SELECT ".$cols." from horizontal h left join cajas c on c.PROD= h.PRODUCTO WHERE CODIGO!='0' AND PRODUCTO='" .$producto. "' " . $rancho . " ".filtroWhereTablas($anio, $meses, $semanas, $tipoCultivo);
}

function queryCostoXHa($Ranchos, $anio, $meses, $semanas, $tipoCultivo)
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
    FROM (select RANCHO, PRODUCTO,  sum(TOTAL_COSTO)/sum(HECTAREAS) CostoXHa from horizontal where RANCHO!='0' " .filtroWhereTablas($anio, $meses, $semanas, $tipoCultivo). " group by RANCHO, PRODUCTO) as tabla PIVOT (
        sum(CostoXHa) FOR RANCHO IN (" . $queryP3 . ")
    ) as  tablaCostoXHa;";
}
function queryCostoPromedioXHa($anio, $meses, $semanas, $tipoCultivo){
    return "Select PRODUCTO, FORMAT(sum(TOTAL_COSTO),'$#,##0.00') as [Costo Total], sum(HECTAREAS) Hectareas, FORMAT(sum(TOTAL_COSTO)/sum(HECTAREAS),'$#,##0.00') [Costo promedio por Ha] from horizontal where RANCHO!='0' " . filtroWhereTablas($anio, $meses, $semanas, $tipoCultivo) . " group by PRODUCTO;";
}

function queryVentasXHa($Ranchos, $anio, $meses, $semanas, $tipoCultivo)
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
    FROM (select RANCHO, PRODUCTO,  sum(VENTAS_TOTALES)/sum(HECTAREAS) VentasXHa from horizontal where RANCHO!='0' " . filtroWhereTablas($anio, $meses, $semanas, $tipoCultivo) . " group by RANCHO, PRODUCTO) as tabla PIVOT (
    sum(VEntasXHa) FOR RANCHO IN (" . $queryP3 . ")
    ) as tablaVentasXHa
    ;";
}
function queryVentasPromedioXHa($anio, $meses, $semanas, $tipoCultivo){
    return "Select PRODUCTO, FORMAT(sum(VENTAS_TOTALES),'$#,##0.00') as [Ventas Totales], sum(HECTAREAS) Hectareas, FORMAT(sum(VENTAS_TOTALES)/sum(HECTAREAS),'$#,##0.00') [Promedio de ventas por Ha] from horizontal where RANCHO!='0' " . filtroWhereTablas($anio, $meses, $semanas, $tipoCultivo) . " group by PRODUCTO;";
}
function queryRendimientoXHa($Ranchos, $anio, $meses, $semanas, $tipoCultivo){
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
    FROM (select RANCHO, PRODUCTO,  sum(KGS_TOTALES)/sum(HECTAREAS) RendimientoXHa from horizontal where RANCHO!='0' ".filtroWhereTablas($anio, $meses, $semanas, $tipoCultivo)." group by RANCHO, PRODUCTO) as tabla PIVOT (
        sum(RendimientoXHa) FOR RANCHO IN (".$queryP3.")
        ) as tablaRendimientoXHa";
}

function queryRendimientoPromedioXHa($anio, $meses, $semanas, $tipoCultivo){
    return "Select PRODUCTO, FORMAT(sum(KGS_TOTALES),'#,##0.00 Kg') as [Total Kg], sum(HECTAREAS) Hectareas, FORMAT(sum(KGS_TOTALES)/sum(HECTAREAS),'#,##0.00 Kg') [Rendimiento promedio por Ha] from horizontal where RANCHO!='0' " . filtroWhereTablas($anio, $meses, $semanas, $tipoCultivo) . " group by PRODUCTO;";
}
function queryResultadosXCultivo($Ranchos, $anio, $meses, $semanas, $tipoCultivo){
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
    FROM (select RANCHO, PRODUCTO,  sum(UTILIDAD_O_PERDIDA)/sum(HECTAREAS) ResultadosXCultivo from horizontal where RANCHO!='0' ".filtroWhereTablas($anio, $meses, $semanas, $tipoCultivo)." group by RANCHO, PRODUCTO) as tabla PIVOT (
        sum(ResultadosXCultivo) FOR RANCHO IN (".$queryP3.")
        ) as tablaResultadosXCultivo";
}
function queryResultadosPromedioXCultivo($anio, $meses, $semanas, $tipoCultivo){
    return "Select PRODUCTO, FORMAT(sum(UTILIDAD_O_PERDIDA),'$#,##0.00') as [Utilidad o pérdida], sum(HECTAREAS) Hectareas, FORMAT(sum(UTILIDAD_O_PERDIDA)/sum(HECTAREAS),'$#,##0.00') [Utilidad o pérdida promedio por Ha] from horizontal where RANCHO!='0' " . filtroWhereTablas($anio, $meses, $semanas, $tipoCultivo) . " group by PRODUCTO;";
}

function queryAgroquimicosXHa($Ranchos, $anio, $meses, $semanas, $tipoCultivo){
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
    FROM (select RANCHO, PRODUCTO,  sum(AGROQUIMICOS)/sum(HECTAREAS) AgroquimicosXHa from horizontal where RANCHO!='0' ".filtroWhereTablas($anio, $meses, $semanas, $tipoCultivo)." group by RANCHO, PRODUCTO) as tabla PIVOT (
        sum(AgroquimicosXHa) FOR RANCHO IN (".$queryP3.")
        ) as tablaAgroquimicosXHa";
}
function queryAgroquimicosPromedioXHa($anio, $meses, $semanas, $tipoCultivo){
    return "Select PRODUCTO, FORMAT(sum(AGROQUIMICOS),'$#,##0.00') as [Agroquímicos], sum(HECTAREAS) Hectareas, FORMAT(sum(AGROQUIMICOS)/sum(HECTAREAS),'$#,##0.00') [Promedio de agroquímicos por Ha] from horizontal where RANCHO!='0' " .filtroWhereTablas($anio, $meses, $semanas, $tipoCultivo) . " group by PRODUCTO;";
}

function fertilizantesXHa($Ranchos, $anio, $meses, $semanas, $tipoCultivo){
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
    FROM (select RANCHO, PRODUCTO,  sum(FERTILIZANTES)/sum(HECTAREAS) FertilizantesXHa from horizontal where RANCHO!='0' ".filtroWhereTablas($anio, $meses, $semanas, $tipoCultivo)." group by RANCHO, PRODUCTO) as tabla PIVOT (
        sum(FertilizantesXHa) FOR RANCHO IN (".$queryP3.")
        ) as tablaFertilizantesXHa";
}
function fertilizantesPromedioXHa($anio, $meses, $semanas, $tipoCultivo){
    return "Select PRODUCTO, FORMAT(sum(FERTILIZANTES),'$#,##0.00') as [Fertilizantes], sum(HECTAREAS) Hectareas, FORMAT(sum(FERTILIZANTES)/sum(HECTAREAS),'$#,##0.00') [Promedio de fertilizante por Ha] from horizontal where RANCHO!='0' " . filtroWhereTablas($anio, $meses, $semanas, $tipoCultivo) . " group by PRODUCTO;";
}
function queryPlantulaXHa($Ranchos, $anio, $meses, $semanas, $tipoCultivo){
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
    FROM (select RANCHO, PRODUCTO,  sum(PLANTULA)/sum(HECTAREAS) PlantulaXHa from horizontal where RANCHO!='0' ".filtroWhereTablas($anio, $meses, $semanas, $tipoCultivo)." group by RANCHO, PRODUCTO) as tabla PIVOT (
        sum(PlantulaXHa) FOR RANCHO IN (".$queryP3.")
        ) as tablaPlantulaXHa";
}

function queryPlantulaPromedioXHa($anio, $meses, $semanas, $tipoCultivo){
    return "Select PRODUCTO, FORMAT(sum(PLANTULA),'$#,##0.00') as [Plántula], sum(HECTAREAS) Hectareas, FORMAT(sum(PLANTULA)/sum(HECTAREAS),'$#,##0.00') [Promedio de plántula por Ha] from horizontal where RANCHO!='0' " . filtroWhereTablas($anio, $meses, $semanas, $tipoCultivo) . " group by PRODUCTO;";
}

function queryFletesXHa($Ranchos, $anio, $meses, $semanas, $tipoCultivo){
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
    FROM (select RANCHO, PRODUCTO,  sum(FLETES1)/sum(HECTAREAS) FletesXHa from horizontal where RANCHO!='0' ".filtroWhereTablas($anio, $meses, $semanas, $tipoCultivo)." group by RANCHO, PRODUCTO) as tabla PIVOT (
        sum(FletesXHa) FOR RANCHO IN (".$queryP3.")
        ) as tablaFletesXHa";
}

function queryFletesPromedioXHa($anio, $meses, $semanas, $tipoCultivo){
    return "Select PRODUCTO, FORMAT(sum(FLETES1),'$#,##0.00') as [Fletes], sum(HECTAREAS) Hectareas, FORMAT(sum(FLETES1)/sum(HECTAREAS),'$#,##0.00') [Promedio de fletes por Ha] from horizontal where RANCHO!='0' " . filtroWhereTablas($anio, $meses, $semanas, $tipoCultivo) . " group by PRODUCTO;";
}

function queryManoDeObraXHa($Ranchos, $anio, $meses, $semanas, $tipoCultivo){
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
    FROM (select RANCHO, PRODUCTO,  sum(MANO_DE_OBRA1)/sum(HECTAREAS) ManoDeObraXHa from horizontal where RANCHO!='0' ".filtroWhereTablas($anio, $meses, $semanas, $tipoCultivo)." group by RANCHO, PRODUCTO) as tabla PIVOT (
        sum(ManoDeObraXHa) FOR RANCHO IN (".$queryP3.")
        ) as tablaManoDeObraXHa";
}

function queryManoDeObraPromedioXHa($anio, $meses, $semanas, $tipoCultivo){
    return "Select PRODUCTO, FORMAT(sum(MANO_DE_OBRA1),'$#,##0.00') as [Mano de obra], sum(HECTAREAS) Hectareas, FORMAT(sum(MANO_DE_OBRA1)/sum(HECTAREAS),'$#,##0.00') [Promedio de mano de obra por Ha] from horizontal where RANCHO!='0' " . filtroWhereTablas($anio, $meses, $semanas, $tipoCultivo) . " group by PRODUCTO;";
}

function queryMaquilaXHa($Ranchos, $anio, $meses, $semanas, $tipoCultivo){
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
    FROM (select RANCHO, PRODUCTO,  sum(MAQUILA1)/sum(HECTAREAS) MaquilaXHa from horizontal where RANCHO!='0' ".filtroWhereTablas($anio, $meses, $semanas, $tipoCultivo)." group by RANCHO, PRODUCTO) as tabla PIVOT (
        sum(MaquilaXHa) FOR RANCHO IN (".$queryP3.")
        ) as tablaMaquilaXHa";
}

function queryMaquilaPromedioXHa($anio, $meses, $semanas, $tipoCultivo){
    return "Select PRODUCTO, FORMAT(sum(MAQUILA1),'$#,##0.00') as [Maquila], sum(HECTAREAS) Hectareas, FORMAT(sum(MAQUILA1)/sum(HECTAREAS),'$#,##0.00') [Promedio de maquila por Ha] from horizontal where RANCHO!='0' " . filtroWhereTablas($anio, $meses, $semanas, $tipoCultivo) . " group by PRODUCTO;";
}
function queryEmpaque($Ranchos, $anio, $meses, $semanas, $tipoCultivo){
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
    FROM (select RANCHO, PRODUCTO,   case SUM(NO_CAJAS1) when 0 then 0 else sum(TOTAL_COSTO_EMPAQUE+TOTAL_MERMAS)/sum(NO_CAJAS1)  end  AS costoXCaja from horizontal where RANCHO!='0' ".filtroWhereTablas($anio, $meses, $semanas, $tipoCultivo)." group by RANCHO, PRODUCTO) as tabla PIVOT (
        sum(costoXCaja) FOR RANCHO IN (".$queryP3.")
        ) as tablaEmpaque";
}
function queryEmpaquePromedio($anio, $meses, $semanas, $tipoCultivo){
    return "Select PRODUCTO, FORMAT(sum(TOTAL_COSTO_EMPAQUE+TOTAL_MERMAS),'$#,##0.00') as [Empaque], FORMAT(sum(NO_CAJAS1), '#,##0.00') [Cantidad de cajas], FORMAT(case SUM(NO_CAJAS1) when 0 then 0 else (sum(TOTAL_COSTO_EMPAQUE+TOTAL_MERMAS)/sum(NO_CAJAS1))  end,'$#,##0.00')  AS [Costo por caja]  from horizontal where RANCHO!='0' " . filtroWhereTablas($anio, $meses, $semanas, $tipoCultivo) . " group by PRODUCTO";
}

function queryGraficaPromedios($anio, $meses, $semanas, $tipoCultivo){
    return "Select PRODUCTO, 
    (sum(TOTAL_COSTO)+sum(TOTAL_COSTO_EMPAQUE))/sum(HECTAREAS) [Costo promedio por Ha $],
    sum(VENTAS_TOTALES)/sum(HECTAREAS) [Promedio de ventas por Ha $],
    sum(UTILIDAD_O_PERDIDA)/sum(HECTAREAS) [Utilidad o pérdida promedio por Ha $],
    sum(PLANTULA)/sum(HECTAREAS) [Promedio de plántula por Ha $],
    sum(AGROQUIMICOS)/sum(HECTAREAS) [Promedio de agroquímicos por Ha $],
    sum(FERTILIZANTES)/sum(HECTAREAS) [Promedio de fertilizante por Ha $],
    sum(KGS_TOTALES)/sum(HECTAREAS) [Rendimiento promedio por Ha (KG)]
    from horizontal where RANCHO!='0' " . filtroWhereTablas($anio, $meses, $semanas, $tipoCultivo) . " group by PRODUCTO;";
}
?>