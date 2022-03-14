<?php

namespace App\Http\Controllers;

use App\Models\ManagersTest;
use App\Models\Test;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Mockery\Exception;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the users list.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('users.user-list', ['active_page' => 'home']);
    }

    /**
     * Show creator users form.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function newItem(){
        if(!Auth::user()->rule) return redirect('/');

        $tests = Test::orderBy('title')->get();

        return view('users.form', ['active_page' => 'home',
            'id' => 0,
            'aviable_list' => [],
            'name' => '',
            'tests' => $tests,
            'auth' => Auth::check() ]);
    }

    /**
     * Show editor users form.
     * @param integer
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function editUserItem($id){
        if(Auth::user()->rule != 1) return redirect('/');

        $user = User::find($id);
        $tests = Test::orderBy('title')->get();
        $managers_test = DB::table('managers_tests')
            ->where('user_id', $id)->get();
        $aviable_list = [];
        foreach ($managers_test as $item){
            $aviable_list[] = $item->test_id;
        }

        if(empty($user)) return redirect('/');

        return view('users.form', [
            'id' => $id,
            'name' => $user->getAttribute('name'),
            'rule' => $user->getAttribute('rule'),
            'active_page' => 'home',
            'tests' => $tests,
            'aviable_list' => $aviable_list,
            'auth' => Auth::check()]);
    }

    /**
     * Save data from users form.
     * @param Request
     * @return Redirect
     */
    public function saveUserItem(Request $request){
        if(!Auth::user()->rule) return redirect('/');

        $postData = ['name'     => $request->get('name'),
                    'test_list' => $request->get('test_list'),
                    'password'  => $request->get('password'),
                    'rule'      => $request->get('rule'),
                    'password'  => Hash::make($request->get('password'))
            ];

        $id = $request->get('id');
        try {
            if (!$id) {
                $user = User::create($postData);
                $id = $user->id;
            } else {
                $user = User::find($id);

                if(empty($user)) return redirect('/');

                $user->name = $postData['name'];
                $user->rule = $postData['rule'];
                $user->password = $postData['password'];
                $user->save();
            }
            $task_list = ManagersTest::where('user_id', $id);

            if($task_list->count() > 0) $task_list->delete();

            foreach ($postData['test_list'] as $item){
                ManagersTest::create(['user_id' => $id, 'test_id' => $item]);
            }

        }catch (Exception $exception){
            return back()->with('error', $exception->getMessage());
        }
        return redirect('/');
    }

    /**
     * Delete users item.
     * @param integer
     * @return Redirect
     */
    public function deleteUserItem($id){
        if(User::find($id)->rule == 1 && User::where('rule', 1)->get()->count() == 1){
            return redirect('/');
        }

        $aviable_tests = ManagersTest::where('user_id', $id);
        if($aviable_tests) $aviable_tests->delete();

        $user = User::find($id);
        if($user) $user->delete();

        return redirect('/');
    }
}
