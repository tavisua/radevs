<?php

namespace App\Http\Controllers;

use App\Models\ManagersTest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Test;
use Illuminate\Support\Facades\Redirect;
use Mockery\Exception;

class TestController extends Controller
{

    /**
     * Show the dashboard for work with tests list.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $tests = Test::orderBy('title')->get();
        return view('tests.test-list', ['active_page' => 'tests',
                                             'rule' => Auth::user()->rule,
                                             'tests' => $tests,
                                             'auth' => Auth::check(),
            ]
        );
    }

    /**
     * Show creator test form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function newItem(){
        if(Auth::user()->rule != 1) return redirect('/');

        return view('tests.form', ['id' => 0, 'title' => '', 'rule' => Auth::user()->rule, 'active_page' => 'tests', 'auth' => Auth::check()]);
    }

    /**
     * Show editor test form.
     * @param integer
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function editTestItem($id){
        if(Auth::user()->rule != 1) return redirect('/');

        $test = Test::find($id);

        if(empty($test)) return redirect('/test');

        return view('tests.form', ['id' => $id, 'title' => $test->getAttribute('title'), 'rule' => Auth::user()->rule, 'active_page' => 'tests', 'auth' => Auth::check()]);
    }

    /**
     * Delete tests item
     * @param integer
     * @return Redirect
     */
    public function deleteTestItem($id){
        if(Auth::user()->rule != 1) return redirect('/');

        $aviable_tests = ManagersTest::where('test_id', $id);
        if($aviable_tests) $aviable_tests->delete();

        $item = Test::find($id);

        if($item) $item->delete();

        return redirect('/test');
    }

    /**
     * Save data from test form.
     * @param Request
     * @return Redirect
     */
    public function saveTestItem(Request $request){
        $postData = ['title' => $request->get('title')];

        $id = $request->get('id');
        try {
            if (!$id) {
                Test::create($postData);
            } else {
                $test = Test::find($id);

                if(empty($test)) return redirect('/test');

                $test->title = $postData['title'];
                $test->save();
            }
        }catch (Exception $exception){
            return back()->with('error', $exception->getMessage());
        }
        return redirect('/test');
    }
}
