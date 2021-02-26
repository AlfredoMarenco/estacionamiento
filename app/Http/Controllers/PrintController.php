<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\Printer;

class PrintController extends Controller
{
    public function imprimir()
    {
        $fecha = Carbon::now();
        $nameprinter = "SP2000";
        $connector = new WindowsPrintConnector($nameprinter);
        $printer = new Printer($connector);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setTextSize(2, 2);
        $printer->text("Estacionamiento\n");
        $printer->text("Paseo de Montejo\n");
        $printer->feed(1);
        $printer->setTextSize(1, 2);
        $printer->qrCode('hola mundo', 1, 10);
        $printer->feed(1);
        $printer->text("Ticket de prueba del estacionamiento\n");
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->feed(1);
        $printer->setTextSize(1, 1);
        $printer->text("Placa del carro: "."YZW-23A\n");
        $printer->text("Fecha: " . $fecha . "\n");
        $printer->text("Hora de ingreso " . $fecha . "\n");
        $printer->setTextSize(1, 1);
        $printer->feed(2);
        $printer->text("");
        $printer->feed(5);
        $printer->cut();

        $printer->close();

        return "ya mande a imprimir";
    }
}
