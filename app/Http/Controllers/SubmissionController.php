<?php

namespace App\Http\Controllers;

use DateTimeZone;
use Carbon\Carbon;
use Mockery\Expectation;
use App\Models\Submission;
use Illuminate\Http\Request;
use App\Http\Requests\Submissions\StoreRequest;


class SubmissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Submission::query();
        if ($request->has('entryDate') && $request->entryDate !=null ) {
            $entryDate = $request->input('entryDate');
            $query->whereDate('entry_at', $entryDate);
        }
        $submissions = $query->paginate(10);

        return $submissions;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $validatedData = $request->validated();

        // Assign other non-validated fields
        try{
            $validatedData['buyer_ip'] = $request->ip();
            $validatedData['entry_at'] = Carbon::now()->toDateString();
            $validatedData['entry_by'] = "1";

            $validatedData['hash_key'] = hash('sha512', $validatedData['receipt_id'] . 'salt');

            // Create a new submission
            $submission = Submission::create($validatedData);

            // Return a response
            return response()->json([
                'message' => 'Submission stored successfully',
                'data' => $submission

            ], 201);

        }catch(Expectation $e){
            return response()->json(['message' => 'Something went wrong'. $e->getMessage().'' ], 400);

        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
