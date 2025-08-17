<?php

namespace App\Http\Controllers;

use App\Http\Requests\MessageListRequest;
use App\Http\Requests\MessageReplyRequest;
use App\Services\MessageService;
use App\Services\NotificationService;
use Illuminate\Http\Request;
use App\Helpers\AlertHelper;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;

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
            Auth::id(),
            $perPage,
            $sortField,
            $sortOrder,
            $keyword,
            filter_var($unreadOnly, FILTER_VALIDATE_BOOLEAN)
        );

        $unreadCount = $this->messageService->getUnreadThreadCount(Auth::id());
        $stats = $this->messageService->getMessageThreadStats(Auth::id());

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
        $thread = $this->messageService->getMessageThreadDetail($id, Auth::id());

        if (!$thread) {
            abort(404, 'Message thread not found');
        }

        // Mark thread as read when viewing
        $this->messageService->markThreadAsRead($id, Auth::id());

        $messages = $this->messageService->getThreadMessages($id, 50, 'created_at', 'asc', Auth::id());

        $breadcrumbs = array_merge($this->mainBreadcrumbs, ['Detail' => null]);

        return view('admin.pages.message.show', compact('breadcrumbs', 'thread', 'messages'));
    }

    /**
     * =============================================
     *      Send a new message in a thread
     * =============================================
     */
    public function sendMessage(MessageReplyRequest $request, $threadId)
    {
        $validatedData = $request->validated();
        $validatedData['thread_id'] = $threadId;

        $message = $this->messageService->sendMessage($validatedData, Auth::id());

        if ($message) {
            // Create notification for the other participant
            $thread = $this->messageService->getMessageThreadDetail($threadId, Auth::id());
            $otherUserId = ($thread->initiator_id === Auth::id()) ? $thread->participant_id : $thread->initiator_id;

            $this->notificationService->createSystemNotification(
                $otherUserId,
                'New Message from ' . Auth::user()->name,
                'You have received a new message in your conversation with ' . Auth::user()->name,
                'new_message',
                [
                    'thread_id' => $threadId,
                    'sender_id' => Auth::id(),
                ]
            );

            // Update last_message_at timestamp
            $thread->updateLastMessageAt();
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
        if ($validatedData['participant_id'] === Auth::id()) {
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

        $thread = $this->messageService->createThreadWithMessage($threadData, $messageData, Auth::id());

        if ($thread) {
            // Create notification for the other participant
            $this->notificationService->createSystemNotification(
                $validatedData['participant_id'],
                'New Conversation from ' . Auth::user()->name,
                'You have received a new conversation from ' . Auth::user()->name,
                'new_conversation',
                [
                    'thread_id' => $thread->id,
                    'sender_id' => Auth::id(),
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
        $result = $this->messageService->deleteMessageThread($id, Auth::id());

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
        $result = $this->messageService->markThreadAsRead($id, Auth::id());

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
        $limit = $request->input('limit', 10);
        $sortBy = $request->input('sort_by', 'created_at');
        $sortOrder = $request->input('sort_order', 'desc');
        $unreadOnly = $request->input('unread_only', true); // Default to true for navbar

        $threads = $this->messageService->listUserMessageThreads(
            Auth::id(),
            $limit, // Use limit instead of perPage
            $sortBy,
            $sortOrder,
            null, // keyword
            filter_var($unreadOnly, FILTER_VALIDATE_BOOLEAN)
        );

        return response()->json(
            $threads->items() // Return only the items for simplicity in navbar
        );
    }

    /**
     * =============================================
     *      Get unread messages count for header
     * =============================================
     */
    public function getUnreadCount()
    {
        $count = $this->messageService->getUnreadThreadCount(Auth::id());

        return response()->json(['count' => $count]);
    }

    /**
     * =============================================
     *      Get conversation between two users
     * =============================================
     */
    public function getConversation($userId)
    {
        $conversation = $this->messageService->getConversationBetweenUsers(Auth::id(), $userId, 50);

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
        $users = \App\Models\User::where('id', '!=', Auth::id())
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
