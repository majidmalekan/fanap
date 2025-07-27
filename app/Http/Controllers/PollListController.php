<?php

namespace App\Http\Controllers;

use App\Services\PollService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PollListController extends Controller
{
    public function __construct(protected PollService $pollService)
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $polls = $this->pollService->getAll();
        return view('Polls.list', compact('polls'));
    }
}
