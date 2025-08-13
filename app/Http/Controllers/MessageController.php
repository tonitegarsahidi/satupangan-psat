<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageListRequest;
use App\Services\MessageService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use App\Helpers\AlertHelper;
use Illuminate\Validation\ValidationException;

class MessageController extends Controller
{
    private $messageService;
    private $notificationService;
    private $mainBreadcrumbs;

    public function __construct(MessageService $messageService, NotificationService $notificationService)
    {
        $this->messageService = $messageService;
        $this->notificationService = $notificationService;

        // Store common breadcrumbs in the constructor
        $this->mainBreadcrumbs = [
            'Dashboard' => route('admin.dashboard'),
            'Messages' => route('message.index'),
        ];
    }

    /**
     * =============================================
     *      List all message threads with search/filter/sort
     * =============================================
     */
    public function index(MessageListRequest $request)
    {
        $sortField = session()->get('sort_field', $request->input('sort_field', 'last_message_at'));
        $sortOrder = session()->get('sort_order', $request->input('sort_order', 'desc'));

        $perPage = $request->input('per_page', config('constant.CRUD.PER_PAGE'));
        $page = $request->input('page', config('constant.CRUD.PAGE'));
        $keyword = $request->input('keyword');
        $unreadOnly = $request->input('unreadOnly', false);

        $threads = $this->messageService->listUserMessageThreads(
            auth()->id(),
            $perPage,
            $sortField,
            $sortOrder,
            $keyword,
            filter_var($unreadOnly, FILTER_VALIDATE_BOOLEAN)
        );

        $unreadCount = $this->messageService->getUnreadThreadCount(auth()->id());
        $stats = $this->messageService->getMessageThreadStats(auth()->id());

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['List' => null]);

        $alerts = AlertHelper::getAlerts();

        return view('admin.pages.message.index', compact(
            'threads',
            'breadcrumbs',
            'sortField',
            'sortOrder',
            'perPage',
            'page',
            'keyword',
            'unreadOnly',
            'unreadCount',
            'stats',
            'alerts'
        ));
    }

    /**
     * =============================================
     *      Display message thread detail
     * =============================================
     */
    public function show($id)
    {
        $thread = $this->messageService->getMessageThreadDetail($id, auth()->id());

        if (!$thread) {
            abort(404, 'Message thread not found');
        }

        // Mark thread as read when viewing
        $this->messageService->markThreadAsRead($id, auth()->id());

        $messages = $this->messageService->getThreadMessages($id, 50, 'created_at', 'asc', auth()->id());

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Detail' => null]);

        return view('admin.pages.message.show', compact('breadcrumbs', 'thread', 'messages'));
    }

    /**
     * =============================================
     *      Send a new message in a thread
     * =============================================
     */
    public function sendMessage(Request $request, $threadId)
    {
        $validatedData = $request->validate([
            'message' => 'required|string|max:5000',
        ]);

        $validatedData['thread_id'] = $threadId;

        $message = $this->messageService->sendMessage($validatedData, auth()->id());

        if ($message) {
            // Create notification for the other participant
            $thread = $this->messageService->getMessageThreadDetail($threadId, auth()->id());
            $otherUserId = ($thread->initiator_id === auth()->id()) ? $thread->participant_id : $thread->initiator_id;

            $this->notificationService->createSystemNotification(
                $otherUserId,
                'New Message from ' . auth()->user()->name,
                'You have received a new message in your conversation with ' . auth()->user()->name,
                'new_message',
                [
                    'thread_id' => $threadId,
                    'sender_id' => auth()->id(),
                ]
            );
        }

        $alert = $message
            ? AlertHelper::createAlert('success', 'Message sent successfully')
            : AlertHelper::createAlert('danger', 'Failed to send message');

        return redirect()->back()->with('alerts', [$alert]);
    }

    /**
     * =============================================
     *      Create a new message thread
     * =============================================
     */
    public function createThread(Request $request)
    {
        $validatedData = $request->validate([
            'participant_id' => 'required|exists:users,id',
            'title' => 'required|string|max:255',
            'message' => 'required|string|max:5000',
        ]);

        // Ensure we're not creating a thread with ourselves
        if ($validatedData['participant_id'] === auth()->id()) {
            throw ValidationException::withMessages([
                'participant_id' => 'You cannot start a conversation with yourself.'
            ]);
        }

        $threadData = [
            'title' => $validatedData['title'],
            'participant_id' => $validatedData['participant_id'],
        ];

        $messageData = [
            'message' => $validatedData['message'],
        ];

        $thread = $this->messageService->createThreadWithMessage($threadData, $messageData, auth()->id());

        if ($thread) {
            // Create notification for the other participant
            $this->notificationService->createSystemNotification(
                $validatedData['participant_id'],
                'New Conversation from ' . auth()->user()->name,
                'You have received a new conversation from ' . auth()->user()->name,
                'new_conversation',
                [
                    'thread_id' => $thread->id,
                    'sender_id' => auth()->id(),
                ]
            );
        }

        $alert = $thread
            ? AlertHelper::createAlert('success', 'Conversation started successfully')
            : AlertHelper::createAlert('danger', 'Failed to start conversation');

        return redirect()->route('message.show', ['id' => $thread->id ?? null])->with('alerts', [$alert]);
    }

    /**
     * =============================================
     *      Delete a message thread
     * =============================================
     */
    public function destroy($id)
    {
        $result = $this->messageService->deleteMessageThread($id, auth()->id());

        $alert = $result
            ? AlertHelper::createAlert('success', 'Conversation deleted successfully')
            : AlertHelper::createAlert('danger', 'Failed to delete conversation');

        return redirect()->route('message.index')->with('alerts', [$alert]);
    }

    /**
     * =============================================
     *      Mark thread as read
     * =============================================
     */
    public function markThreadAsRead($id)
    {
        $result = $this->messageService->markThreadAsRead($id, auth()->id());

        return response()->json([
            'success' => $result,
            'message' => $result ? 'Thread marked as read' : 'Failed to mark thread as read'
        ]);
    }

    /**
     * =============================================
     *      Get message threads for API (AJAX)
     * =============================================
     */
    public function getThreadsApi(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $unreadOnly = $request->input('unreadOnly', false);

        $threads = $this->messageService->listUserMessageThreads(
            auth()->id(),
            $perPage,
            null,
            null,
            null,
            filter_var($unreadOnly, FILTER_VALIDATE_BOOLEAN)
        );

        return response()->json([
            'threads' => $threads->items(),
            'total' => $threads->total(),
            'unread_count' => $this->messageService->getUnreadThreadCount(auth()->id()),
            'pagination' => [
                'current_page' => $threads->currentPage(),
                'last_page' => $threads->lastPage(),
                'per_page' => $threads->perPage(),
                'total' => $threads->total(),
            ]
        ]);
    }

    /**
     * =============================================
     *      Get unread messages count for header
     * =============================================
     */
    public function getUnreadCount()
    {
        $count = $this->messageService->getUnreadThreadCount(auth()->id());

        return response()->json(['count' => $count]);
    }

    /**
     * =============================================
     *      Get conversation between two users
     * =============================================
     */
    public function getConversation($userId)
    {
        $conversation = $this->messageService->getConversationBetweenUsers(auth()->id(), $userId, 50);

        return response()->json([
            'messages' => $conversation->items(),
            'other_user' => $userId,
            'pagination' => [
                'current_page' => $conversation->currentPage(),
                'last_page' => $conversation->lastPage(),
                'per_page' => $conversation->perPage(),
                'total' => $conversation->total(),
            ]
        ]);
    }

    /**
     * =============================================
     *      Search users for starting new conversations
     * =============================================
     */
    public function searchUsers(Request $request)
    {
        $search = $request->input('q');
        $users = \App\Models\User::where('id', '!=', auth()->id())
            ->where(function ($query) use ($search) {
                $query->whereRaw('lower(name) LIKE ?', ['%' . strtolower($search) . '%'])
                    ->orWhereRaw('lower(email) LIKE ?', ['%' . strtolower($search) . '%']);
            })
            ->limit(10)
            ->get(['id', 'name', 'email']);

        $formattedUsers = $users->map(function ($user) {
            return ['id' => $user->id, 'text' => $user->name . ' (' . $user->email . ')'];
        });

        return response()->json($formattedUsers);
    }
}
