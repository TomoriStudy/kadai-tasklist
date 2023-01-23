<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Task;    // 追加
use Illuminate\Support\Facades\Auth;

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    // getでtasks/にアクセスされた場合の「一覧表示処理」
    public function index()
    {
        // メッセージ一覧を取得
        $tasks = Task::all();
        
        if (Auth::check()) { // 認証済みの場合
            // 認証済みユーザを取得
            $user = Auth::user();
        }
        
        // メッセージ一覧ビューでそれを表示
        return view('tasks.index', [
            'tasks' => $tasks,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    // getでtasks/createにアクセスされた場合の「新規登録画面表示処理」
    public function create()
    {
        $task = new Task;

        // メッセージ作成ビューを表示
        return view('tasks.create', [
            'task' => $task,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    // postでtasks/にアクセスされた場合の「新規登録処理」
    public function store(Request $request)
    {
        // dd(\Auth::id());
        // バリデーション
        $request->validate([
            'status' => 'required|max:10',
            'content' => 'required',
        ]);
        
        // メッセージを作成
        $task = new Task;
        $task->status = $request->status;
        $task->content = $request->content;
        $task->user_id = Auth::id();
        $task->save();

        // タスク一覧ページへリダイレクトさせる
        return redirect('/tasks');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    // getでtasks/（任意のid）にアクセスされた場合の「取得表示処理」
    public function show($id)
    {
        // idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);

        // メッセージ詳細ビューでそれを表示
        if (\Auth::id() === $task->user_id) {
            return view('tasks.show', [
                'task' => $task,
            ]);
        }
        
        // トップページへリダイレクトさせる
        return redirect('/');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    // getでtasks/（任意のid）/editにアクセスされた場合の「更新画面表示処理」
    public function edit($id)
    {
        // idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);

        // メッセージ編集ビューでそれを表示
        if (\Auth::id() === $task->user_id) {
            return view('tasks.edit', [
                'task' => $task,
            ]);
        }
        
        // トップページへリダイレクトさせる
        return redirect('/');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
     // putまたはpatchでtasks/（任意のid）にアクセスされた場合の「更新処理」
    public function update(Request $request, $id)
    {
        // バリデーション
        $request->validate([
            'status' => 'required|max:10',
            'content' => 'required',
        ]);
        
        // idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);
        // メッセージを更新
        if (\Auth::id() === $task->user_id) {
            $task->status = $request->status;
            $task->content = $request->content;
            $task->save();
            // タスク一覧ページへリダイレクトさせる
            return redirect('/tasks');
        }

        // トップページへリダイレクトさせる
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
    // deleteでtasks/（任意のid）にアクセスされた場合の「削除処理」
    public function destroy($id)
    {
        // idの値でメッセージを検索して取得
        $task =Task::findOrFail($id);
        // メッセージを削除
        if (\Auth::id() === $task->user_id) {
            $task->delete();
            // タスク一覧ページへリダイレクトさせる
            return redirect('/tasks');
        }
        
        // トップページへリダイレクトさせる
        return redirect('/');
    }
}
