<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Poll\StorePollRequest;
use App\Http\Requests\Admin\Poll\UpdatePollRequest;
use App\Services\PollOptionService;
use App\Services\PollService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PollController extends Controller
{
    public function __construct(protected PollService $pollService,protected PollOptionService $pollOptionService)
    {
    }

    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $polls = $this->pollService->index($request);
        return view('admin.polls.index', compact('polls'));
    }

    public function create(): View
    {
        return view('admin.polls.create');
    }

    /**
     * @param StorePollRequest $request
     * @return RedirectResponse
     */
    public function store(StorePollRequest $request): RedirectResponse
    {
        try {
            $poll=$this->pollService->create($request->only(['title','start_at','end_at']));
            $this->pollOptionService->createBulk($poll->id, $request->input('options', []));
            return redirect()->route('admin.polls.index')->with('success', 'نظرسنجی با موفقیت ایجاد شد.');
        }catch (\Exception $exception){
            return redirect()->route('admin.polls.index')->with('error', $exception->getMessage());
        }

    }

    /**
     * @param string $id
     * @return View|RedirectResponse
     */
    public function edit(string $id):View|RedirectResponse
    {
        try {
            if ($this->checkHasVote($id)) {
                return redirect()->route('admin.polls.index')
                    ->withErrors(['edit' => 'نمی‌توان نظرسنجی دارای رأی را ویرایش کرد.']);
            }
                $poll = $this->pollService->find($id);
            return view('admin.polls.edit', compact('poll'));
        }catch (\Exception $exception){
            return redirect()->route('admin.polls.index')->with('error', $exception->getMessage());
        }

    }

    /**
     * @param UpdatePollRequest $request
     * @param string $id
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(UpdatePollRequest $request, string $id): RedirectResponse
    {
        try {
            if ($this->checkHasVote($id)) {
                return redirect()->route('admin.polls.index')
                    ->withErrors(['edit' => 'نمی‌توان نظرسنجی دارای رأی را ویرایش کرد.']);
            }
            $poll=$this->pollService->updateAndFetch($id, $request->only('title','start_at','end_at'));
            $existingOptionIds = [];
            foreach ($request->input('options') ?? [] as $option) {
                $this->pollOptionService->updateOrCreate($poll->id,$option);
                $existingOptionIds[] = $option['id'];
            }
            $this->pollOptionService->deleteNotExistingIds($existingOptionIds);
            foreach ($request->input('new_options') ?? [] as $text) {
                if (!empty($text)) {
                   $this->pollOptionService->create(['text' => $text,'poll_id' => $id]);
                }
            }
            return redirect()->route('admin.polls.index')->with('success', 'نظرسنجی بروزرسانی شد.');
        }catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }

    }

    /**
     * @param string $id
     * @return RedirectResponse
     * @throws \Exception
     */
    public function destroy(string $id): RedirectResponse
    {
        try {
            $this->pollService->delete($id);
            return redirect()->route('admin.polls.index')->with('success', 'نظرسنجی حذف شد.');
        }catch (\Exception $exception){
            throw new \Exception($exception->getMessage());
        }
    }

    /**
     * @param string $pollId
     * @return bool
     */
    private function checkHasVote(string $pollId):bool
    {
        return $this->pollService->hasVote($pollId);

    }
}
