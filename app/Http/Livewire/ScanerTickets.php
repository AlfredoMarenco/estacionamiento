<?php

namespace App\Http\Livewire;

use App\Models\Configuration;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Illuminate\Support\Str;

class ScanerTickets extends Component
{
    public $diff;
    public $subTotal = 0;
    public $total = 0;
    public $barcode;
    public $plate;
    public $datetime_end;
    public $datetime_start;
    public $price;
    public $accion = 'escanear';
    public $cambio;

    public function render()
    {
        return view('livewire.scaner-tickets');
    }

    public function getBarcodeInfo()
    {
        $ticketInfo = Ticket::where('barcode', '=', $this->barcode)->first();
        switch ($ticketInfo->pagado) {
            case '0':
                $this->barcode = $ticketInfo->barcode;
                $this->plate = $ticketInfo->plate;
                $this->datetime_start = $ticketInfo->datetime_start;
                $this->accion = 'cobrar';
                break;
            case '1':
                $this->accion = 'pagado';
                break;
            case '2':
                $this->accion = 'cancelado';
                break;
            case '3':
                $this->accion = 'cancelado';
                break;
        }
    }

    public function difference()
    {
        $this->getBarcodeInfo();
        $datetime_start = Carbon::parse($this->datetime_start);
        $datetime_end = $this->datetime_end = Carbon::now();
        $this->diff = $datetime_end->floatDiffInRealHours($datetime_start);
        return $this->diff;
    }

    public function getValue()
    {
        $price = Configuration::find(1);
        $this->price = $price->price_hours;
        $horas = $this->subTotal = $this->difference();
        $minutos =  $this->difference() - intval($horas);
        if ($horas <= 0 || $horas < 1) {
            $this->subTotal = $this->price;
        } elseif ($horas >= 1) {
            $this->subTotal = intval($horas) * $this->price;
            if ($minutos >= 0 && $minutos <= 0.25) {
                $this->subTotal = $this->subTotal + $price->quarter1;
            } elseif ($minutos > 0.25 && $minutos <= 0.50) {
                $this->subTotal = $this->subTotal + $price->quarter2;
            } elseif ($minutos > 0.50 && $minutos <= 0.75) {
                $this->subTotal = $this->subTotal + $price->quarter3;
            } elseif ($minutos > 0.75 && $minutos <= 0.99) {
                $this->subTotal = $this->subTotal + $price->quarter4;
            }
        }
    }

    public function setDataBaseInfo()
    {
        Ticket::where('barcode', $this->barcode)
            ->update([
                'datetime_end' => $this->datetime_end,
                'pagado' => 1,
                'amount' => $this->subTotal
            ]);
        // Http::patch('https://pruebas-ecdd7-default-rtdb.firebaseio.com/tickets/'.$this->barcode.'.json',
        // [
        //     'plate' => $this->plate,
        //     'datetime_end' => $this->datetime_end,
        //     'pagado' => 1,
        //     'amount' => $this->subTotal,
        //     'updated_at' => $this->datetime_end
        // ]);
    }

    public function printTicket()
    {
        $dayName = Carbon::parse($this->datetime_start)->dayName;
        $day = Carbon::parse($this->datetime_start)->day;
        $monthName = Carbon::parse($this->datetime_start)->monthName;
        $year = Carbon::parse($this->datetime_start)->year;
        $cambio = $this->cambio - $this->subTotal;
        $config = Configuration::find(1);
        $device = $config->printer;
        //$this->datetime_start->locale('es_Mx');
        $nameprinter = $device;
        $connector = new WindowsPrintConnector($nameprinter);
        $printer = new Printer($connector);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setTextSize(2, 2);
        $printer->text("Estacionamiento\n");
        $printer->text($config->company . "\n");
        $printer->feed(1);
        $printer->setTextSize(1, 2);
        $printer->qrCode($this->barcode, 1, 10);
        $printer->feed(1);
        $printer->text($this->barcode . "\n");
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->feed(1);
        $printer->setTextSize(1, 1);
        $printer->text("Mérida Yucatán - " . $dayName . " " . $day . " de " . $monthName . " de " . $year . "\n");
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->feed(1);
        $printer->text("Placa del carro: " . Str::upper($this->plate) . "\n");
        $printer->text("Hora de ingreso: " . $this->datetime_start . "\n");
        $printer->text("Hora de salida: " . $this->datetime_end . "\n");
        $printer->text("Total: $" . number_format($this->subTotal, 2) . "\n");
        $printer->text("Pago con: $" . number_format($this->cambio, 2) . "\n");
        $printer->text("Cambio: $" . number_format($cambio, 2) . "\n");
        $printer->setTextSize(1, 1);
        $printer->feed(2);
        $printer->text($config->rules);
        $printer->feed(5);
        $printer->cut();
        $printer->close();
        $this->reset('plate');
    }

    public function cancelar()
    {
        $this->accion = 'escanear';
        $this->reset('barcode');
    }

    public function cobrar()
    {
        if ($this->cambio < $this->subTotal) {
            $this->accion = 'invalido';
        } else {
            $this->printTicket();
            $this->setDataBaseInfo();
            $this->accion = 'escanear';
            $this->reset(['barcode', 'cambio']);
        }
    }

    public function regresar()
    {
        if ($this->accion  == 'invalido') {
            $this->accion = 'cobrar';
        } elseif ($this->accion == 'pagado' || $this->accion == 'cancelado') {
            $this->accion = 'escanear';
            $this->barcode = '';
        }
    }
}
