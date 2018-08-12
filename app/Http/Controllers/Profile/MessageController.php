<?php

namespace App\Http\Controllers\Profile;
use Session;
use DB;
use App\Message;
use App\MessageSubject;
use App\MessageParticipant;
use App\MessageViewer;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{

    protected $user;
    protected $message;
    protected $messageSubject;
    protected $messageParticipant;
    protected $messageView;

    public function __construct(Message $message, MessageSubject $messageSubject, MessageParticipant $messageParticipant, MessageViewer $messageView, User $user)
    {
        $this->middleware('auth');
        $this->middleware('message.participant')->only('show');
        $this->message = $message;
        $this->messageSubject = $messageSubject;
        $this->messageParticipant = $messageParticipant;
        $this->messageView = $messageView;
        $this->user = $user;
    }

    /**
     * Get all participants
     *
     * @return \Illuminate\Http\Response
     */
    private function getParticipants($id){
        $conversation = $this->messageSubject->findOrFail($id);
        $allParticipants = array();
        foreach($conversation->participants as $participants){ 
            array_push($allParticipants, $participants->user->id);
        }
        return $allParticipants;
    }

    /**
     * Get new messages.
     *
     * @return \Illuminate\Http\Response
     */
    public function newMessages()
    {
        $unreadMessages = array();
        $allMessageSubjects = DB::table('message_subjects')->whereIn('id', function($query){
                                    $query->select('message_subject_id')->from('message_participants')->where('user_id','=', Auth::user()->id);
                                })->get();
        foreach($allMessageSubjects as $messageSubject){
            $message = $this->message->where('message_subject_id','=', $messageSubject->id)->orderBy('id', 'DESC')->first();
            if((isset($message) && count($message->viewers) == 0) || (isset($message) && count($message->viewers) > 0 && !in_array(Auth::user()->id, $message->viewers->pluck('user_id')->toArray()))){
                $unreadMessages[] = array(
                    'user'=>$message->user->name, 
                    'message_subject'=>$message->message_subject->subject, 
                    'message'=>$message->message_text, 
                    'date'=>date('l d F Y, h:i A', strtotime($message->created_at))
                );
            }
        }

        return json_encode($unreadMessages);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = \Request::get('search');
        $user = $this->user->find(Auth::user()->id);
        $messages = $user->messages()->search($search)->orderBy('created_at', 'desc')->paginate(30);
        return view('profile.messages.index', compact('user', 'messages', 'search'));
    }

    /**
     * Show the form for creating a new message subject.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $user = $this->user->find(Auth::user()->id);
        return view('profile.messages.create', compact('user'));
    }

    /**
     * Show the form for store a new subject.
     *
     * @return \Illuminate\Http\Response
     */
    public function storeSubject(Request $request)
    {
        $this->validate(request(),[
            'subject' => 'required|max:500'
        ]);
        $message_id = $this->createMessage($request['subject'], array($request['user_id']));
        return redirect(route('messages.show', $message_id))->with('success', array('Message Create'=>'Message has been created! Please add some participants!'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate(request(),[
            'message_text' => 'required|max:50000'
        ]);
        $input = $request->all();
        $this->message->create($input);
        return redirect()->route('messages.show', $request->message_subject_id)->with('success', array('Success'=>'Message has been added!'));
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
        $conversation = $this->messageSubject->findOrFail($id);
        $messages = $this->message->where('message_subject_id', '=', $id)->orderBy('created_at', 'desc')->paginate(15);
        if($messages->onFirstPage() && $messages->isNotEmpty() && !$messages->first()->viewers->contains('user_id', Auth::user()->id)){
            $view = $this->messageView;
            $view->message_id = $messages->first()->id;
            $view->user_id = Auth::user()->id;
            $view->save();
        } 
        return view('profile.messages.messages', compact('user', 'conversation', 'messages'));
    }

    /**
     * Get all users that are not participants.
     *
     * @return \Illuminate\Http\Response
     */
    public function getUsersList(Request $request, $id)
    {
        return $this->user->whereNotIn('id', $this->getParticipants($id))
                            ->where(function ($query) use ($request) {
                                $query
                                    ->where('username', $request->user)
                                    ->orWhere('email', $request->user)
                                    ->orWhere('name', 'LIKE', '%' . $request->user . '%');
                            })
                            ->take(30)->get()->toJson();
    }

    /**
     * Add a new participant to the conversation.
     *
     * @return \Illuminate\Http\Response
     */
    public function addParticipant($id, $user)
    {
        if (in_array(Auth::user()->id, $this->getParticipants($id)) && !in_array($user, $this->getParticipants($id))){
            $messageParticipant = $this->messageParticipant;
            $messageParticipant->message_subject_id = $id;
            $messageParticipant->user_id = $user;
            $messageParticipant->save();
            $user = $this->user->findOrFail($user);
            return redirect()->back()->with('success', array('Success'=> $user->name.' has been added to this conversation!'));
        }
        return redirect()->back()->with('error', array('Error'=> 'There has been a problem while performing this action!'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $message = $this->message->findOrFail($id);
        return json_encode(array('message_text'=>$message->message_text, 'last_updated'=>date('l d F Y, h:i A', strtotime($message->updated_at))));
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
        $input = $request->all();
        $message = $this->message->findOrFail($id);
        $message->update($input);
        return redirect()->route('messages.show', $message->message_subject_id)->with('success', array('Success'=>'Message has been updated!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function removeParticipant($id)
    {
        $messageParticipant = $this->messageParticipant;
        $messageParticipant->where('message_subject_id', '=', $id)->where('user_id', '=', Auth::user()->id)->delete();
        return redirect()->route('messages.index')->with('success', array('Success'=> 'You have removed yourself from this coversation!'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = $this->message->findOrFail($id);
        $message->delete();
        return redirect()->route('messages.show', $id)->with('success', array('Success'=>'Message has been deleted!'));
    }
}
