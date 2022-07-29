<?php

namespace App\Services\Api\Core\Question;

use App\Models\Core\Answer;
use App\Models\Core\Question;
use App\Models\Core\Waitlister;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SearchQuestionService
{
    private $question;
    
    CONST COUNT = 10;

    public function __construct()
    {
        $this->question = Question::select(
            'questions.uuid', 
            'questions.content', 
            'questions.category_id', 
            'questions.created_at', 
            'questions.updated_at', 
            DB::raw('answers_latest.updated_at as latest_answer_at'),
            DB::raw('coalesce(waitlist.count, 0) as waitlist_count'),
            DB::raw('coalesce(EXTRACT(DAY FROM NOW() - answers_latest.updated_at), 0)::int as days_since_latest_answer')
        )
        ->leftJoinSub(
            Answer::select('question_id', 'updated_at')->latest(),
            'answers_latest', 'questions.id', '=', 'answers_latest.question_id'
        )
        ->leftJoinSub(
            Waitlister::select('question_id', DB::raw('count(*) as count'))->groupBy('question_id'),
            'waitlist', 'questions.id', '=', 'waitlist.question_id'
        );
    }

    /**
     * This returns the result. This is called when the object is treated as a string.
     * e.g. exit($service)
     */
    public function __toString() {
        return $this->question->paginate(self::COUNT)->toJson();
    }

    /**
     * Another variation of the function above which returns the result. This function
     * can be used like response()->json($service->getResults())
     */
    public function getResults() {
        return $this->question->paginate(self::COUNT);
    }

    /**
     * This function adds the main query to the search.
     */
    public function addKeywords($keywords)
    {
        if(!is_array($keywords)) {
            $this->question->where('questions.content', 'like', "%{$keywords}%");
        } else {
            $this->question->where(function($query) use ($keywords) {
                foreach($keywords as $keyword) {
                    if($keyword != '') {
                        $query->orWhere('questions.content', 'like', "%{$keyword}%");
                    }
                }
            });
        }
    }

    /**
     * This function adds the category filter to the search.
     */
    public function addCategory($category)
    {
        // TODO: To be implemented
        // $this->question->where('category_id', $category);
    }

    /**
     * This function adds the tags filter to the search.
     */
    public function addTags($tags)
    {
        // TODO: To be implemented
        // $this->question->whereHas('tags', function ($query) use ($tags) {
        //     $query->whereIn('tags.uuid', $tags);
        // });
    }

    /**
     * This function adds the order of the search intended for admins.
     * In this case, unanswered questions will be ranked first.
     */
    public function orderResultForAdmin()
    {
        $this->question->orderBy('days_since_latest_answer', 'asc');
        $this->question->orderBy('created_at', 'asc');
    }

    /**
     * This function simplifies the orderBy clause intended for users.
     * In this case, latest answered questions will be ranked first.
     */
    public function orderResultForUser()
    {
        $this->question->orderBy('latest_answer_at', 'desc');
        $this->question->orderBy('days_since_latest_answer', 'asc');
    }

    /**
     * This function determines the order of the search based on the user context.
     */
    public function order()
    {
        if(Auth::guard('api')->check()) {
            $this->orderResultForAdmin();
        } else {
            $this->orderResultForUser();
        }
    }
}