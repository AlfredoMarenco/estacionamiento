<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Ticket;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\CapabilityProfile;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\Printer;
use Illuminate\Support\Str;

class PrintController extends Controller
{
    public function reprintTicket($id){
        $ticket = Ticket::find($id);
        $dayName = Carbon::now()->dayName;
        $day = Carbon::now()->day;
        $monthName = Carbon::now()->monthName;
        $year = Carbon::now()->year;
        $config = Configuration::find(1);
        $device = $config->printer;
        $nameprinter = $device;
        $connector = new WindowsPrintConnector($nameprinter);
        $printer = new Printer($connector);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setTextSize(2, 2);
        $printer->text("Estacionamiento\n");
        $printer->text($config->company."\n");
        $printer->feed(1);
        $printer->setTextSize(1, 2);
        $printer->qrCode($ticket->barcode, 1, 10);
        $printer->feed(1);
        $printer->text($ticket->id . "\n");
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->feed(1);
        $printer->setTextSize(1, 1);
        $printer->text("Fecha de la copia del comprobante");
        $printer->text("Mérida Yucatán - " . $dayName . " " . $day . " de " . $monthName . " de " . $year . "\n");
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->feed(1);
        $printer->text("Placa del carro: " . Str::upper($ticket->plate) . "\n");
        $printer->text("Hora de ingreso: " . $ticket->datetime_start . "\n");
        $printer->text("Hora de salida: " . $ticket->datetime_end . "\n");
        $printer->text("Total: $" . number_format($ticket->amount, 2) . "\n");
        $printer->setTextSize(1, 1);
        $printer->feed(2);
        $printer->text($config->rules);
        $printer->feed(5);
        $printer->cut();
        $printer->close();

        return back();
    }


        // public function imprimir()
    // {
    //     $fecha = Carbon::now();
    //     $nameprinter = "SP2000";
    //     $connector = new WindowsPrintConnector($nameprinter);
    //     $printer = new Printer($connector);
    //     $printer->setJustification(Printer::JUSTIFY_CENTER);
    //     $printer->setTextSize(2, 2);
    //     $printer->text("Estacionamiento\n");
    //     $printer->text("Paseo de Montejo\n");
    //     $printer->feed(1);
    //     $printer->setTextSize(1, 2);
    //     $printer->qrCode('hola mundo', 1, 10);
    //     $printer->feed(1);
    //     $printer->text("Ticket de prueba del estacionamiento\n");
    //     $printer->setJustification(Printer::JUSTIFY_LEFT);
    //     $printer->feed(1);
    //     $printer->setTextSize(1, 1);
    //     $printer->text("Placa del carro: "."YZW-23A\n");
    //     $printer->text("Fecha: " . $fecha . "\n");
    //     $printer->text("Hora de ingreso " . $fecha . "\n");
    //     $printer->setTextSize(1, 1);
    //     $printer->feed(2);
    //     $printer->text("");
    //     $printer->feed(5);
    //     $printer->cut();

    //     $printer->close();

    //     return "ya mande a imprimir";
    // }
}
