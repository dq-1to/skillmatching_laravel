<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ route('home') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                    data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('posts.index') }}">投稿一覧</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('requests.index') }}">依頼一覧</a>
                        </li>
                        @auth
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('posts.create') }}">新規投稿</a>
                            </li>
                        @endauth
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    @if(Auth::user()->role === 1)
                                        <a class="dropdown-item" href="{{ route('admin.dashboard') }}">管理者ダッシュボード</a>
                                        <div class="dropdown-divider"></div>
                                    @elseif(Auth::user()->role === 0)
                                        <a class="dropdown-item" href="{{ route('mypage.show') }}">マイページ</a>
                                        <div class="dropdown-divider"></div>
                                    @endif
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    {{-- 非同期処理 --}}
    <script>
        document.addEventListener('click', async (e) => {
            const btn = e.target.closest('.js-bookmark-btn');
            if (!btn) return;

            @if(!auth()->check())
                // 未ログインならログインへ
                window.location.href = "{{ route('login') }}";
                return;
            @endif

  const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const postId = btn.dataset.postId;
            const isBookmarked = btn.dataset.bookmarked === '1';

            const url = isBookmarked
                ? "{{ url('/bookmarks') }}/" + postId
                : "{{ url('/bookmarks') }}/" + postId;

            const options = {
                method: isBookmarked ? 'DELETE' : 'POST',
                headers: {
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                }
            };

            btn.disabled = true;
            try {
                const res = await fetch(url, options);
                const data = await res.json();

                if (data.ok) {
                    btn.dataset.bookmarked = data.bookmarked ? '1' : '0';
                    btn.classList.toggle('btn-warning', data.bookmarked);
                    btn.classList.toggle('btn-outline-warning', !data.bookmarked);

                    const cnt = btn.querySelector('.js-bookmark-count');
                    if (cnt) cnt.textContent = data.count;
                } else {
                    alert('更新に失敗しました');
                }
            } catch (err) {
                console.error(err);
                alert('通信エラーが発生しました');
            } finally {
                btn.disabled = false;
            }
        });
    </script>
</body>

</html>