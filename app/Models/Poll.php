<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Morilog\Jalali\Jalalian;

class Poll extends BaseModel
{
    protected $fillable = [
        'title',
        'start_at',
        'end_at',
    ];

    public array $defaultRelationsForFind=["options","votes"];

    protected $appends = ['vote_percentages'];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    /**
     * @return HasMany
     */
    public function options(): HasMany
    {
        return $this->hasMany(PollOption::class);
    }

    /**
     * @return HasMany
     */
    public function votes(): HasMany
    {
        return $this->hasMany(PollVote::class);
    }

    /**
     * @return array
     */
    public function getVotePercentagesAttribute(): array
    {
        if (! $this->relationLoaded('options')) {
            $this->load('options');
        }

        $totalVotes = $this->votes()->count();
        if ($totalVotes === 0) {
            return [];
        }

        $optionCounts = $this->votes()
            ->selectRaw('poll_option_id, COUNT(*) as count')
            ->groupBy('poll_option_id')
            ->pluck('count', 'poll_option_id')
            ->toArray();

        $percentages = [];

        foreach ($this->options as $option) {
            $count = $optionCounts[$option->id] ?? 0;
            $percentages[$option->id] = round(($count / $totalVotes) * 100, 1);
        }

        return $percentages;
    }

}
