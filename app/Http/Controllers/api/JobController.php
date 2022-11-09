<?php

namespace App\Http\Controllers\api;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Resources\JobResource;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    public function index()
    {
        $AllJobs = Listing::paginate(5);
        return JobResource::collection($AllJobs);
    }

    public function show($id)
    {
        $show = Listing::find($id);

        return new JobResource($show);
    }

    public function store(Request $request) {
        $formFields = $request->validate([
            'title' => 'required',
            'company' => ['required', Rule::unique('listings', 'company')],
            'location' => 'required',
            'website' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')
                ->store('logos', 'public');
        }

        $formFields['user_id'] = auth()->id();

        $createListing = Listing::create($formFields);

        return new JobResource($createListing);
    }

    public function update(Request $request, Listing $listing, $id) {
        // Make sure logged in user is the owner
        // if($listing->user_id != auth()->id()) {
        //     abort(403, 'Unauthorized Action');
        // }

        // $formFields = $request->validate([
        //     'title' => 'required',
        //     'company' => ['required'],
        //     'location' => 'required',
        //     'website' => 'required',
        //     'email' => ['required', 'email'],
        //     'tags' => 'required',
        //     'description' => 'required'
        // ]);

        // if($request->hasFile('logo')) {
        //     $formFields['logo'] = $request->file('logo')
        //         ->store('logos', 'public');
        // }


        $list = Listing::find($id);

        $list->update($request->all());

        return new JobResource($list);
    }

    public function destroy(Listing $listing, $id) {



        // Auth::user()->id == $article->user_id
        //$user->id === $post->user_id
        // if(Auth::user()->id !== $listing->user_id) {
        //     // abort(403, 'Unauthorized Action');
        //     return 'You are not the author of the post';
        // }

        $listing::find($id)->delete();
        return "Listing deleted successfully";
    }
}
