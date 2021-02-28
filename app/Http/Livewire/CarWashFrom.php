<?php

namespace App\Http\Livewire;

use App\Models\Configuration;
use App\Models\Ticket;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Str;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;
use Psy\Configuration as PsyConfiguration;

class CarWashFrom extends Component
{
    public $mensaje;
    public $plate;
    public $accion = 'placa';
    public $amount;
    public function render()
    {
        return view('livewire.car-wash-from');
    }

    public function cobrar()
    {
        // $tickets = Ticket::where('plate', '=', $this->plate)->where('pagado', '=', '0')->count();
        // if ($tickets > 0) {
            $this->accion = 'cobrar';
        // } else {
        //     $this->mensaje = "Este vehiculo no esta en el estacionamiento";
        //     $this->reset('plate');
        // }
    }

    public function cancelar()
    {
        $this->accion = "placa";
    }


    public function create()
    {
        $barcode = Str::random();
        $datetime_start = Carbon::now();
        $user = auth()->user()->id;
        $config = Configuration::find(1);

        $ticket = Ticket::create([
            'barcode' => $barcode,
            'plate' => 'CarWash-' . $this->plate,
            'amount' => $this->amount,
            'pagado' =>'5',
            'datetime_start' => $datetime_start,
            'datetime_end' => $datetime_start,
            'user_id' => $user
        ]);

        $dayName = Carbon::parse($datetime_start)->dayName;
        $day = Carbon::parse($datetime_start)->day;
        $monthName = Carbon::parse($datetime_start)->monthName;
        $year = Carbon::parse($datetime_start)->year;
        $device = $config->printer;
        $datetime_start->locale('es_Mx');
        $nameprinter = $device;
        $connector = new WindowsPrintConnector($nameprinter);
        $printer = new Printer($connector);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setTextSize(2, 2);
        $printer->text("Estacionamiento\n");
        $printer->text($config->company . "\n");
        $printer->feed(1);
        $printer->setTextSize(1, 2);
        $printer->text("Cobro de servicio de lavado\n");
        $printer->qrCode($barcode, 1, 10);
        $printer->feed(1);
        $printer->text("Orden: " . $ticket->id . "\n");
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->feed(1);
        $printer->setTextSize(1, 1);
        $printer->text("Mérida Yucatán - " . $dayName . " " . $day . " de " . $monthName . " de " . $year . "\n");
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->feed(1);
        $printer->text("Placa del carro: " . Str::upper($this->plate) . "\n");
        $printer->text("Hora de cobro:" . $datetime_start . "\n");
        $printer->text("Total: $" . number_format($ticket->amount,2) . "\n");
        $printer->setTextSize(1, 1);
        $printer->feed(2);
        $printer->text($config->rules);
        $printer->feed(5);
        $printer->cut();
        $printer->close();
        $this->reset(['mensaje', 'plate', 'accion']);
    }
}
