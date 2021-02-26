<?php

namespace App\Http\Livewire;

use App\Models\Configuration;
use App\Models\Ticket;
use Carbon\Carbon;
use Faker\Provider\Barcode;
use GuzzleHttp\Promise\Create;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Illuminate\Support\Str;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class FormCreateTickets extends Component
{
    public $plate;

    public function render()
    {
        return view('livewire.form-create-tickets');
    }

    public function create(){
        $barcode = Str::random();
        $datetime_start = Carbon::now();
        $user = auth()->user()->id;
        //Creamos el registro en la base de datos local para tener un respalñd
        $ticket = Ticket::create([
            'barcode' => $barcode,
            'plate' => $this->plate,
            'datetime_start' => $datetime_start,
            'user_id' => $user
        ]);
        // Creamos el registro en realtime database en firebase de google
        // Http::put('https://pruebas-ecdd7-default-rtdb.firebaseio.com/tickets/'.$barcode.'.json', [
        //     'barcode' => $barcode,
        //     'plate' => $this->plate,
        //     'datetime_start' => $datetime_start,
        //     'datetime_end' => 'null',
        //     'pagado' => 0,
        //     'amount' => 'null',
        //     'user_id' => $user,
        //     'created_at' => $datetime_start,
        //     'updated_at' => $datetime_start
        // ]);
        $dayName = Carbon::parse($datetime_start)->dayName;
        $day = Carbon::parse($datetime_start)->day;
        $monthName = Carbon::parse($datetime_start)->monthName;
        $year = Carbon::parse($datetime_start)->year;
        $device = Configuration::find(1)->printer;
        $datetime_start->locale('es_Mx');
        $nameprinter = $device;
        $connector = new WindowsPrintConnector($nameprinter);
        $printer = new Printer($connector);
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setTextSize(2, 2);
        $printer->text("Estacionamiento\n");
        $printer->text("Paseo de Montejo\n");
        $printer->feed(1);
        $printer->setTextSize(1, 2);
        $printer->qrCode($barcode, 1, 10);
        $printer->feed(1);
        $printer->text("Orden: ".$ticket->id ."\n");
        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->feed(1);
        $printer->setTextSize(1, 1);
        $printer->text("Mérida Yucatán - " . $dayName ." ". $day." de ".$monthName." de ".$year. "\n");
        $printer->setJustification(Printer::JUSTIFY_LEFT);
        $printer->feed(1);
        $printer->text("Placa del carro: ". Str::upper($this->plate) ."\n");
        $printer->text("Hora de ingreso " . $datetime_start . "\n");
        $printer->setTextSize(1, 1);
        $printer->feed(2);
        $printer->text("Reglamento del estacionamiento donde se describen todas las reglas que se aplicaran Reglamento del estacionamiento donde se describen todas las reglas que se aplicaran Reglamento del estacionamiento donde se describen todas las reglas que se aplicaran ");
        $printer->feed(5);
        $printer->cut();
        $printer->close();
        $this->reset('plate');

    }
}
