#!/usr/bin/php
<?php
  include_once("codcontrolv7.class.php");

  echo "Codigo de Control para Facturacion en BOLIVIA Segun v7".PHP_EOL;
  echo "------------------------------------------------------".PHP_EOL;
  $CodigoControl = new CodigoControl();
  $fichero = @fopen("5000CasosPruebaCCVer7.txt", "r");
  if ($fichero) {
    $contador = 1;
    while (($linea = fgets($fichero, 4096)) !== false) {
      list($autorizacion, $nrofactura, $nitci, $fecha, $monto, $llave, $verhoeff, $cadena, $sumatoria, $base64, $codigocontrol)=explode("|", $linea);
      if ($autorizacion > 0) {
        echo "[".str_pad($contador,5," ",STR_PAD_LEFT)."] ";
        echo str_pad($codigocontrol,16," ", STR_PAD_LEFT)." / ";
        $fecha = str_replace("/", "", $fecha);
        $monto = round(str_replace(",", ".", $monto),0);
        $newcodigo = $CodigoControl->generar($autorizacion,$nrofactura,$nitci,$fecha,$monto,$llave);
        echo str_pad($newcodigo,16," ", STR_PAD_LEFT)." [";
        if ($codigocontrol == $newcodigo ) { echo "  OK"; } else { echo "NOOK"; }
        echo "]\n";
        $contador ++;
      }
    }
    if (!feof($fichero)) {
      echo "Error: unexpected fgets() fail\n";
    }
    fclose($fichero);
  }
?>
