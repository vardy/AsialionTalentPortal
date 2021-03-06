<?php

namespace App\Http\Controllers;

use App\File;
use App\Invoice;
use App\PurchaseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Validator;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display 'thank you' screen after invoice submission.
     *
     * @return \Illuminate\Http\Response
     */
    public function thank_you()
    {
        return view('invoices.thank_you');
    }

    /**
     * Show the index of invoice objects and form for creating new invoices.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('invoices.index', [
            'invoices' => auth()->user()->invoices
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [];
        $numOfPOs = 0;

        /* Catches error if fields don't exist
         * (if user did not add any purchase orders)
         * */
        try {
            foreach($request->input('po_number') as $key => $value) {
                $rules["po_number.{$key}"] = 'required|max:255|unique:purchase_orders,po_number';
                $numOfPOs++;
            }

            foreach($request->input('po_description') as $key => $value) {
                $rules["po_description.{$key}"] = 'required|max:255';
            }

            foreach($request->input('po_value') as $key => $value) {
                $rules["po_value.{$key}"] = 'required|numeric';
            }

        } catch (\Exception $ex) {}

        $rules["ndaCheck"] = 'required';
        $rules["invoice_number"] = 'max:255|required';
        $rules["file"] = 'max:1000000';

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            $invoice = new Invoice();
            $invoice->user_id = auth()->user()->id;
            $invoice->num_of_pos = $numOfPOs;
            $invoice->invoice_number = $request->invoice_number;
            $invoice->save();

            // Save file to database and S3
            // Assign invoice ID to files
            if($request->file) {
                $file = $request->file;

                $fileEntry = new File();
                $fileEntry->invoice_id = $invoice->id;
                $fileEntry->file_name = $file->getClientOriginalName();
                $fileEntry->original_file_name = $file->getClientOriginalName();
                $fileEntry->file_size = (string) $file->getSize();
                $fileEntry->file_extension = $file->getClientOriginalExtension();
                $fileEntry->file_mime = $file->getClientMimeType();
                $fileEntry->save();

                // Commit object to s3 with file path and contents of file (key:object)
                $filePathToStore = '/talentportal/' . $fileEntry->id;
                \Storage::disk('s3')->put($filePathToStore, file_get_contents($file));
            }

            // Save POs to database
            // Assign invoice ID to POs
            // Add up running total
            $po_total_value = 0;
            if ($numOfPOs > 0) {
                $poNum = 0;
                foreach ($request->all()['po_number'] as $po_number) {
                    $po_description = $request->all()['po_description'][$poNum];
                    $po_value = $request->all()['po_value'][$poNum];

                    $purchase_order = new PurchaseOrder();
                    $purchase_order->invoice_id = $invoice->id;
                    $purchase_order->po_number = $po_number ;
                    $purchase_order->description = $po_description;
                    $purchase_order->value = $po_value;
                    $purchase_order->save();

                    $po_total_value += $po_value;
                    $poNum++;
                }
            }

            // Save total value of POs to invoice
            $invoice->total = $po_total_value;
            $invoice->save();

            return redirect(route('invoices'))->with([
                'success-message' => __('success.invoice_submitted')
            ]);

        } else {

            return redirect(route('invoices'))
                ->withErrors($validator)
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);

        // Delete file belonging to invoice
        if($invoice->file) {
            $file = $invoice->file;

            // Delete files from S3
            $s3PathToFile = '/talentportal/' . $file->id;
            Storage::disk('s3')->delete($s3PathToFile);

            // Delete files from SQL
            File::findOrFail($file->id)->delete();
        }

        // Loop through purchase order IDs in SQL and delete rows
        foreach ($invoice->purchase_orders as $purchase_order) {

            // Delete purchase orders from SQL
            PurchaseOrder::findOrFail($purchase_order->id)->delete();
        }

        // Delete invoice entry
        $invoice->delete();

        return redirect()->action('RedirectController@invoice_delete');
    }
}
