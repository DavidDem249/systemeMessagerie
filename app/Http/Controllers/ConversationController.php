<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use App\Repository\ConversationRepository;
use Illuminate\Auth\AuthManager;
use App\Http\Requests\StoreMessageRequest;
use App\Notifications\MessageRecived;

class ConversationController extends Controller
{

	private $r;
	private $auth;

	public function __construct(ConversationRepository $conversationRepository, AuthManager$auth)
	{
		$this->middleware('auth');
		$this->r = $conversationRepository;
		$this->auth = $auth;
	}
    

    public function index()
    {
    	//$users = User::select('name','id')->where('id', '!=', auth()->user()->id)->get();
    	return View('conversation.index', [

    		'users' => $this->r->getConversation($this->auth->user()->id),
    		'unread' => $this->r->unreadCount($this->auth->user()->id),
    	]);
    }

    public function show(User $user)
    {
    	//$users = User::select('name','id')->where('id', '!=', auth()->user()->id)->get();
    	$me = $this->auth->user();
    	$messages = $this->r->getMessagesFor($me->id, $user->id)->paginate(5);
    	$unread = $this->r->unreadCount($me->id);

    	if(isset($unread[$user->id]))
    	{
    		$this->r->readAllFrom($user->id, $me->id);
    		unset($unread[$user->id]);
    	}
        //dd($user->message->content);
    	return View('conversation.show', [

    		'users' => $this->r->getConversation($this->auth->user()->id),
    		'user' => $user,
    		'messages' => $messages,
    		'unread' => $unread,
    	]);
    }

    public function store(User $user, StoreMessageRequest $request)
    {

    	$message = $this->r->createMessage(

    		$request->get('content'),
    		$this->auth->user()->id,
    		$user->id

    	);
    	$user->notify(new MessageRecived($message));
    	return redirect(route('conversation.show',['id' =>$user->id]));

    }
}
