<?php

namespace App\Http\Controllers;

use App\Models\Configuration;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class TicketController extends Controller
{
    public function showTicketsLost()
    {
        $tickets = Ticket::where('pagado', '=', '0')->paginate(5);
        return view('reports.lost', compact('tickets'));
    }

    public function setTicketsLost($id)
    {
        $ticket = Ticket::find($id);
        $config = Configuration::find(1);
        $ticket->datetime_end = Carbon::now();
        $ticket->amount = $config->amountLost;
        $ticket->pagado = '4';
        $ticket->save();
        //Generamos el ticket de comprobante para que el operador lo anexe a su corte
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
        $printer->text($config->company . "\n");
        $printer->feed(1);
        $printer->setTextSize(2, 2);
        $printer->text('Ticket Perdido');
        $printer->feed(1);
        $printer->text($ticket->id . "\n");
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->feed(1);
        $printer->setTextSize(1, 1);
        $printer->text("Fecha de reporte como perdido" . "\n");
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
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setTextSize(2,2);
        $printer->text("COMPROBANTE DE TICKET");
        $printer->text("PERDIDO");
        $printer->feed(3);
        $printer->setTextSize(1,1);
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->feed(1);
        $printer->text("Placa del carro: " . Str::upper($ticket->plate) . "\n");
        $printer->text("Hora de ingreso: " . $ticket->datetime_start . "\n");
        $printer->text("Hora de salida: " . $ticket->datetime_end . "\n");
        $printer->text("Total: $" . number_format($ticket->amount, 2) . "\n");
        $printer->feed(5);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->text('-------------------------------------');
        $printer->text('Firma del cliente');
        $printer->feed(2);
        $printer->cut();
        $printer->close();
        return back();
    }
    public function cancel($id)
    {
        $ticket = Ticket::find($id);
        $diffence = Carbon::parse($ticket->datetime_start)->diffInMinutes();
        //return $diffence;
        if ($diffence <= 5) {
            //Actualizamos en la base de datos los parametros de cancelacion rembolsada
            $ticket->pagado = '2';
            $ticket->datetime_end = Carbon::now();
            $ticket->amount = 0.00;
            $ticket->save();
            //Generamos el ticket de comprobante para que el operador lo anexe a su corte
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
            $printer->text($config->company . "\n");
            $printer->feed(1);
            $printer->setTextSize(1, 2);
            $printer->text('Ticket Cancelado - Reembolsado');
            $printer->feed(1);
            $printer->text($ticket->id . "\n");
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->feed(1);
            $printer->setTextSize(1, 1);
            $printer->text("Fecha de la cancelacion" . "\n");
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
        } else {
            //Actualizamos en la base de datos los parametros de cancelacion NO rembolsada
            $ticket->pagado = '3';
            $ticket->datetime_end = Carbon::now();
            $ticket->amount = 20.00;
            $ticket->save();
            //Generamos el ticket de comprobante para que el operador lo anexe a su corte
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
            $printer->text($config->company . "\n");
            $printer->feed(1);
            $printer->setTextSize(1, 2);
            $printer->text('Ticket Cancelado - No Reembolsado');
            $printer->feed(1);
            $printer->text($ticket->id . "\n");
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $printer->feed(1);
            $printer->setTextSize(1, 1);
            $printer->text("Fecha de la cancelacion" . "\n");
            $printer->text("Mérida Yucatán - " . $dayName . " " . $day . " de " . $monthName . " de " . $year . "\n");
            $printer->text($ticket->datetime_end . "\n");
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
        }
        return back();
    }
}
