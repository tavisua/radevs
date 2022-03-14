<?php

namespace App\Http\Controllers;

use App\Models\TestResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class TestResultController extends Controller
{
    //

    /**
     * Show creator test-result form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function newItem(){
        if(Auth::user()->rule) return redirect('/');
        $tests =DB::table('tests')
            ->join('managers_tests', 'test_id', '=', 'tests.id')
            ->where('user_id', Auth::user()->id)->get();
        return view('tests.form-result', [
            'id' => 0,
            'full_name' => '',
            'location' => '',
            'date' => '',
            'rating' => '',
            'rule' => Auth::user()->rule,
            'user_id' => Auth::user()->id,
            'tests' => $tests,
            'test_id' => 0,
            'auth' => Auth::check() ]);
    }

    /**
     * Show editor test-result form.
     * @param integer
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function editTestResultItem($id){
        if(Auth::user()->rule) return redirect('/');
        $tests =DB::table('tests')
            ->join('managers_tests', 'test_id', '=', 'tests.id')
            ->where('user_id', Auth::user()->id)->get();

        $test_result = TestResult::find($id);
        return view('tests.form-result', [
            'id' => $id,
            'full_name' => $test_result->getAttribute('full_name'),
            'location' => $test_result->getAttribute('location'),
            'date' => date('Y-m-d', strtotime($test_result->getAttribute('date'))),
            'rating' => $test_result->getAttribute('rating'),
            'rule' => Auth::user()->rule,
            'user_id' => Auth::user()->id,
            'tests' => $tests,
            'test_id' => $test_result->getAttribute('test_id'),
            'auth' => Auth::check() ]);
    }

    /**
     * Delete test-result item
     * @param integer
     * @return Redirect
     */
    public function deleteTestResultItem($id){
        $test_result_item = TestResult::find($id);
        if(!empty($test_result_item)) $test_result_item->delete();

        return redirect('/');
    }

    /**
     * Save data from test form.
     * @param Request
     * @return Redirect
     */
    public function saveTestResultItem(Request $request){
        $postData =
            ['full_name' => $request->get('full_name'),
             'date' => $request->get('date'),
             'location' => $request->get('location'),
             'rating' => $request->get('rating'),
             'test_id' => $request->get('test_id'),
            ];

        if($postData['rating'] > 100) $postData['rating'] = 100;
        if($postData['rating'] < 0) $postData['rating'] = 0;

        if((0 <= $postData['rating']) && ($postData['rating'] <= 60)){
            $postData['criterion'] = 100;
        } elseif ((61 <= $postData['rating']) && ($postData['rating'] <= 80)){
            $postData['criterion'] = 200;
        } elseif ((81 <= $postData['rating']) && ($postData['rating'] <= 91)) {
            $postData['criterion'] = 300;
        } elseif ((92 <= $postData['rating']) && ($postData['rating'] <= 100)){
            $postData['criterion'] = 500;
        }
        $postData['user_id'] = Auth::user()->id;
        $id = $request->get('id');
        try {
            if (!$id) {
                TestResult::create($postData);
            } else {
                $test_result = TestResult::find($id);

                if(empty($test_result)) return redirect('/');

                $test_result->full_name = $postData['full_name'];
                $test_result->location = $postData['location'];
                $test_result->date = $postData['date'];
                $test_result->rating = $postData['rating'];
                $test_result->criterion = $postData['criterion'];
                $test_result->test_id = $postData['test_id'];
                $test_result->save();
            }

        }catch (Exception $exception){
            return back()->with('error', $exception->getMessage());
        }
        return redirect('/');

    }
}
