@if (Auth::check())
    {{-- 新規タスク追加ページへのリンク --}}
    {{-- <li><a class="link link-hover" href="#">新規タスクの追加</a></li> --}}
    <li><a class="link link-hover" href="{{ route('tasks.index') }}">タスク一覧</a></li>
    <li class="divider lg:hidden"></li>
    {{-- ログアウトへのリンク --}}
    <li><a class="link link-hover" href="#" onclick="event.preventDefault();this.closest('form').submit();">Logout</a></li>
@else
    {{-- ユーザ登録ページへのリンク --}}
    <li><a class="link link-hover" href="{{ route('register') }}">Signup</a></li>
    <li class="divider lg:hidden"></li>
    {{-- ログインページへのリンク --}}
    <li><a class="link link-hover" href="{{ route('login') }}">Login</a></li>
@endif