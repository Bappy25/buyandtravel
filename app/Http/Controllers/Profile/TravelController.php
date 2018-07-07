<?php

namespace App\Http\Controllers\Profile;
use Countries;
use App\Travel;
use App\User;
use Carbon\Carbon;
use App\Http\Requests\TravelRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

class TravelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $travel;
    protected $user;

    public function __construct(Travel $travel, User $user)
    {
        $this->middleware('auth');
        $this->travel = $travel;
        $this->user = $user;
    }

    public function index()
    {
        $user = $this->user->find(Auth::user()->id);
        $search = \Request::get('search');
        $travelHistory = $user->travels()->search($search)->orderBy('arrival_date', 'desc')->paginate(20);
        return view('profile.travel.index', compact('user', 'travelHistory', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = Auth::user();
        $countries = Countries::getListForSelect();
        return view('profile.travel.create', compact('user', 'countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TravelRequest $request)
    {
        $input = $request->all();
        $input['arrival_date'] = Carbon::parse($input['arrival_date'])->format('Y-m-d');
        $input['leave_date'] = Carbon::parse($input['leave_date'])->format('Y-m-d');
        Travel::create($input);
        return redirect()->route('travel.index')->with('success', array('Success'=>'Travel Schedule has been added'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = Auth::user();
        $travel = $this->travel->find($id);
        if($travel == null){
            return redirect()->back()->with('error', array('Empty Result'=>'Your requested travel Schedule does not exist'));
        }
        return view('profile.travel.show', compact('user', 'travel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = Auth::user();
        $countries = Countries::getListForSelect();
        $travel = $this->travel->find($id);
        if($travel == null){
            return redirect()->back()->with('error', array('Empty Result'=>'Your requested travel Schedule does not exist'));
        }
        return view('profile.travel.edit', compact('user', 'travel', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
