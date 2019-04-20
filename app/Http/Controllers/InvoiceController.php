<?php

namespace App\Http\Controllers;

use App\File;
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
        $numOfPOs = 0;
        $numOfFiles = 0;

        /* File validation
         * Throws error if files dont exist
         * */
        try {
            foreach($request->allFiles()['files'] as $key => $value) {
                $rules["files.{$key}"] = 'max:1000000';
                $numOfFiles++;
            }

        } catch (\Exception $ex) {}

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
        $rules["invoice_number"] = 'max:255';

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {

            // ADD TO DATABASE

            //foreach($request->input('name') as $key => $value) {
                //TagList::create(['name'=>$value]);
            //}

            /*
            $filesUploaded = $request->allFiles()["files"];

            foreach($filesUploaded as $file) {
                $fileName = $file->getClientOriginalName();


            }
            */

            $invoice = new Invoice();
            $invoice->user_id = auth()->user()->id;
            $invoice->num_of_pos = $numOfPOs;
            $invoice->num_of_files = $numOfFiles;

            // Setting invoice number based off of user input
            $empty_invoice_number =  $request->invoice_number == null;
            if (!$empty_invoice_number) {
                $invoice->invoice_number = $request->invoice_number;
            }
            $invoice->save();

            // If no user input, set invoice number to first 5 chars of invoice ID
            if ($empty_invoice_number) {
                $invoice->invoice_number = substr($invoice->id, 0, 5);
            }
            $invoice->save();

            // Save files to database and S3
            // Assign invoice ID to files
            if ($numOfFiles > 0) {
                $allFiles = $request->allFiles()['files'];
                foreach ($allFiles as $file) {

                    $fileEntry = new File();
                    $fileEntry->invoice_id = $invoice->id;
                    $fileEntry->file_name = $file->getClientOriginalName();
                    $fileEntry->original_file_name = $file->getClientOriginalName();
                    $fileEntry->fileSize = (string) $file->getSize();
                    $fileEntry->fileExtension = $file->getClientOriginalExtension();
                    $fileEntry->fileMime = $file->getClientMimeType();
                    $fileEntry->save();

                    // Commit object to s3 with file path and contents of file (key:object)
                    $filePathToStore = '/talentportal/' . $fileEntry->id;
                    \Storage::disk('s3')->put($filePathToStore, file_get_contents($file));
                }
            }

            // Save POs to database
            // Assign invoice ID to POs
            // Add up running total

            // Save total value of POs to invoice

            dd($request->all(), $validator);
            dd($request->all()['files'][0], $validator);

            return redirect(route('invoices'));

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
