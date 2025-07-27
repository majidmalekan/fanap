<?php

namespace App\Http\Controllers;

use App\Http\Requests\Vote\StoreVoteRequest;
use App\Models\Poll;
use App\Services\VoteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class VoteController extends Controller
{
    public function __construct(protected VoteService $voteService)
    {
    }

    /**
     * @param Poll $poll
     * @return View|JsonResponse
     */
    public function show(Poll $poll): View|JsonResponse
    {
        $userId = Auth::id();
        $hasVoted = $this->voteService->userHasVoted($poll->id, $userId);
        $results = $hasVoted ? $this->voteService->getVotePercentages($poll) : [];
        if (request()->expectsJson()) {
            return response()->json([
                'poll' => $poll,
                'has_voted' => $hasVoted,
                'results' => $results,
            ]);
        }
        return view('Vote.vote', compact('poll', 'hasVoted', 'results'));
    }

    /**
     * @param StoreVoteRequest $request
     * @param Poll $poll
     * @return JsonResponse
     */
    public function store(StoreVoteRequest $request, Poll $poll): JsonResponse
    {
        try {
           $vote= $this->voteService->vote($poll, $request->input('option_id'), Auth::id());
             return response()->json([
                'vote' => $vote,
            ]);
        } catch (\Exception $e) {
            return response()->json([ $e->getMessage()]);
        }
    }

}
