<?php

namespace App\Http\Livewire;

use App\Models\Configuration;
use App\Models\Ticket;
use Carbon\Carbon;
use Livewire\Component;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class BoxCutForm extends Component
{
    public $datetime_start;
    public $datetime_end;

    public function render()
    {
        return view('livewire.box-cut-form');
    }


    public function toDay()
    {
        $this->datetime_start = Carbon::now()->toDateString() . "T00:00:00";
        $this->datetime_end = Carbon::now()->toDateString() . "T23:59:59";
    }

    public function printCut()
    {
        $total = 0;
        $pagados = 0;
        $canceladosRembolsados = 0;
        $canceladosNoRembolsados = 0;
        $ticketsPeridodos=0;
        $totalPagados = 0;
        $totalCanceladosRembolsados = 0;
        $totalCanceladosNoRembolsados = 0;
        $totalTicketsPeridodos=0;
        $from = Carbon::parse($this->datetime_start);
        $to = Carbon::parse($this->datetime_end);
        $tickets = Ticket::whereBetween('datetime_start', [$from, $to])->where('pagado', '!=', '0')->get();
        foreach ($tickets as $ticket) {
            switch ($ticket->pagado) {
                case '1':
                    $pagados++;
                    $totalPagados += $ticket->amount;
                    break;
                case '2':
                    $canceladosRembolsados++;
                    $totalCanceladosRembolsados += $ticket->amount;
                    break;
                case '3':
                    $canceladosNoRembolsados++;
                    $totalCanceladosNoRembolsados += $ticket->amount;
                    break;
                case '4':
                    $ticketsPeridodos++;
                    $totalTicketsPeridodos += $ticket->amount;
                    break;
            }
            $total += $ticket->amount;
        }
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
        $printer->feed(1);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->feed(1);
        $printer->setTextSize(2, 2);
        $printer->text("Corte de Caja\n");
        $printer->setTextSize(1, 1);
        $printer->text("Mérida Yucatán - " . $dayName . " " . $day . " de " . $monthName . " de " . $year . "\n");
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->feed(2);
        $printer->text("Tickets Pagados: " . $pagados . " = $" . number_format($totalPagados) . "\n");
        $printer->text("Tickets Cancelados: " . $canceladosRembolsados . " = $" . number_format($totalCanceladosRembolsados) . "\n");
        $printer->text("Tickets C. No-Reembolsados: " . $canceladosNoRembolsados . " = $" . number_format($totalCanceladosNoRembolsados) . "\n");
        $printer->text("Tickets Perdidos: " . $ticketsPeridodos . " = $" . number_format($totalTicketsPeridodos) . "\n");
        $printer->feed(1);
        $printer->text("Total del corte: " . $tickets->count() . " = $" . number_format($total) . "\n");
        $printer->text("Este corte es el comprobante para realizar el cierre del dia");
        $printer->feed(5);
        $printer->cut();
        $printer->close();
        $this->reset(['datetime_start', 'datetime_end']);
    }
}
