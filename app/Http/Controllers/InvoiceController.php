<?php

namespace App\Http\Controllers;

use App\Invoice;
use Illuminate\Http\Request;
use Validator;

class InvoiceController extends Controller
{
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('invoices.create', [
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

        /* File validation
         * Throws error if files dont exist
         * */
        try {
            foreach($request->allFiles()['files'] as $key => $value) {
                $rules["files.{$key}"] = 'max:1000000';
            }

        } catch (\Exception $ex) {}

        /* Catches error if fields don't exist
         * (if user did not add any purchase orders)
         * */
        try {
            foreach($request->input('po_number') as $key => $value) {
                $rules["po_number.{$key}"] = 'required|max:255|unique:purchase_orders,po_number';
            }

            foreach($request->input('po_description') as $key => $value) {
                $rules["po_description.{$key}"] = 'required|max:255';
            }

            foreach($request->input('po_value') as $key => $value) {
                $rules["po_value.{$key}"] = 'required|numeric';
            }

        } catch (\Exception $ex) {}

        $rules["ndaCheck"] = 'required';
        $rules["invoice_number"] = 'max:255';

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            // ADD TO DATABASE

            //foreach($request->input('name') as $key => $value) {
                //TagList::create(['name'=>$value]);
            //}

            return response()->json(['success'=>'done']);

            /*

            $filesUploaded = $request->allFiles()["files"];

            foreach($filesUploaded as $file) {
                $fileName = $file->getClientOriginalName();


            }

            */

        } else {

            return redirect(route('invoices'))
                ->withErrors($validator)
                ->withInput();
        }

        /*
         *
         * Parse:
         *    - Invoice:
         *       - Invoice number based off of ID
         *       - Store ID for assigning to files and POs
         *    - Files:
         *       - Save to S3
         *       - Save to database
         *       - Assign Invoice ID
         *    - Purchase Orders:
         *       - PO number
         *       - PO description
         *       - PO value
         *       - Save to database
         *       - Assign invoice ID
         *       - Add value to running total
         *    - Total value of purchase orders saved to invoice
         *    - Total number of purchase orders and files saved to invoice
         * */



        return redirect(route('invoices'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
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
    public function destroy(Invoice $invoice)
    {
        //
    }
}
