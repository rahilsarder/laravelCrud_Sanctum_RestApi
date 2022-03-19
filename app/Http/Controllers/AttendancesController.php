<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\DutyTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LaravelDaily\Invoices\Classes\Buyer;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Invoice;
use Symfony\Component\HttpFoundation\Response;





class AttendancesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user()->isAdmin;

        if (!$user) {
            return response()->json([
                'message' => 'Not Permitted'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $attendance = Attendance::all();

        // $ip = $_SERVER['REMOTE_ADDR'];

        // if ($ip == '192.140.252.2') {
        //     return response()->json([
        //         'wabang' => 'awabg'
        //     ]);
        // }

        return response()->json([
            'attendances' => $attendance
        ], Response::HTTP_ACCEPTED);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user()->isAdmin;

        if (!$user) {
            return response()->json([
                'message' => 'Not Permitted'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $request->validate([
            'in_time' => 'required',
            'out_time' => 'required',
            'employee_id' => 'required',
            'duty_timing_id' => 'required',
        ]);



        $dutyTime = DutyTime::find($request->input('duty_timing_id'));

        $compare = $dutyTime->start_time < $request->input('in_time');

        if ($compare) {


            $attendance = Attendance::create([
                'in_time' => $request->input('in_time'),
                'out_time' => $request->input('out_time'),
                'employee_id' => $request->input('employee_id'),
                'is_late' => $request->input('isLate')
            ]);

            return response()->json([
                'attendance' => $attendance
            ]);
        }


        return $dutyTime;


        // dd($compare);




        // return response()->json([
        //     'attendance' => $attendance
        // ], Response::HTTP_CREATED);
    }

    public function generateInvoice()
    {
        $customer = new Buyer([
            'name'          => 'John Doe',
            'custom_fields' => [
                'email' => 'test@example.com',
            ],
        ]);

        $item = (new InvoiceItem())->title('Invoice Item')->pricePerUnit(100)->quantity(1);

        $invoice  = Invoice::make('invoice')
            ->shipping(50)
            ->buyer($customer)
            ->addItem($item)
            ->currencyCode('BDT')
            ->currencySymbol('৳')
            ->payUntilDays(false)
            ->logo('https://inspirebroadband.net/wp-content/uploads/2021/11/logo-black.png');




        return $invoice->download();
    }
}
