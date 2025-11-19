<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <style>
        :root {
            --primary-color: #0095D9;
            --primary-hover: #007AB3;
            --accent-color: #8FC31F;
            --text-color: #333;
            --bg-color: #F5F9FC;
            --white: #ffffff;
            --error: #e74c3c;
            --gray: #f0f0f0;
        }
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: "Helvetica Neue", Arial, "Hiragino Kaku Gothic ProN", "Hiragino Sans", Meiryo, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            line-height: 1.6;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        header {
            background-color: var(--white);
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 100;
        }
        .header-inner {
            max-width: 1000px;
            margin: 0 auto;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 1rem;
        }
        .logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: var(--primary-color);
            text-decoration: none;
            display: flex;
            align-items: center;
        }
        .logo span { color: var(--accent-color); margin-left: 5px; }
        nav ul {
            list-style: none;
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }
        nav a {
            text-decoration: none;
            color: var(--text-color);
            font-weight: bold;
            font-size: 0.9rem;
            padding: 0.5rem 0.8rem;
            border-radius: 4px;
            transition: background 0.3s;
            cursor: pointer;
        }
        nav a:hover { background-color: var(--gray); color: var(--primary-color); }
        nav a.btn-nav-login { background-color: var(--primary-color); color: #fff; }
        nav a.btn-nav-login:hover { background-color: var(--primary-hover); }
        main {
            flex: 1;
            max-width: 1000px;
            margin: 0 auto;
            padding: 2rem 1rem;
            width: 100%;
        }
        section { display: none; animation: fadeIn 0.5s ease; }
        section.active { display: block; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        h2 { font-size: 1.8rem; margin-bottom: 1.5rem; border-bottom: 3px solid var(--accent-color); display: inline-block; padding-bottom: 0.3rem; }
        .hero {
            text-align: center;
            padding: 3rem 1rem;
            background-color: var(--white);
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }
        .hero h1 { font-size: 2.5rem; color: var(--primary-color); margin-bottom: 1rem; }
        .hero p { font-size: 1.1rem; color: #666; margin-bottom: 2rem; }
        .hero-buttons { display: flex; justify-content: center; gap: 1rem; flex-wrap: wrap; }
        .btn { display: inline-block; padding: 0.8rem 2rem; border-radius: 50px; text-decoration: none; font-weight: bold; cursor: pointer; border: none; font-size: 1rem; transition: all 0.3s; }
        .btn-primary { background-color: var(--primary-color); color: #fff; }
        .btn-primary:hover { background-color: var(--primary-hover); }
        .btn-secondary { background-color: var(--accent-color); color: #fff; }
        .btn-secondary:hover { opacity: 0.9; }
        .btn-outline { border: 2px solid var(--primary-color); color: var(--primary-color); background: transparent; }
        .btn-outline:hover { background-color: var(--primary-color); color: #fff; }
        .features { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-top: 2rem; }
        .feature-card { background: var(--white); padding: 1.5rem; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); text-align: left; }
        .feature-card h3 { color: var(--primary-color); margin-bottom: 1rem; }
        .info-box { background: var(--white); padding: 1.5rem; border-radius: 10px; margin-bottom: 1.5rem; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .info-box ul { padding-left: 1.2rem; }
        .info-box li { margin-bottom: 0.6rem; }
        form {
            background: var(--white);
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.05);
        }
        .form-group { margin-bottom: 1rem; }
        label { display: block; margin-bottom: 0.5rem; font-weight: bold; }
        input, select, textarea {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 6px;
            font-size: 1rem;
        }
        textarea { min-height: 120px; resize: vertical; }
        .club-list { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; }
        .club-card { background: var(--white); border-radius: 10px; padding: 1.5rem; box-shadow: 0 4px 12px rgba(0,0,0,0.05); display: flex; flex-direction: column; justify-content: space-between; }
        .club-header { font-size: 1.2rem; font-weight: bold; color: var(--primary-color); margin-bottom: 0.5rem; }
        .club-meta { font-size: 0.9rem; color: #666; margin-bottom: 1rem; display: flex; gap: 0.5rem; flex-wrap: wrap; }
        .club-meta span { background: var(--gray); padding: 0.3rem 0.8rem; border-radius: 20px; }
        .club-needs { background: #fefefe; border: 1px dashed #ddd; padding: 0.8rem; border-radius: 6px; font-size: 0.95rem; margin-bottom: 1rem; }
        .match-status { font-size: 0.9rem; color: #555; }
        .hidden { display: none !important; }
        .alert { padding: 0.8rem; margin-bottom: 1rem; border-radius: 6px; font-weight: bold; }
        .alert-error { background: rgba(231, 76, 60, 0.1); color: var(--error); }
        .alert-success { background: rgba(143, 195, 31, 0.15); color: var(--accent-color); }
        footer {
            text-align: center;
            padding: 1rem;
            background: var(--white);
            margin-top: 2rem;
            border-top: 1px solid #eee;
        }
    </style>
</head>
<body>
<header>
    <div class="header-inner">
        <a class="logo" href="#" data-target="home">みんなの部活応援隊<span>Shimane</span></a>
        <nav>
            <ul>
                <li><a href="#" data-target="home">ホーム</a></li>
                <li><a href="#" data-target="list">部活動を探す</a></li>
                <li class="guest-only"><a href="#" data-target="register-club">部活動を登録</a></li>
                <li><a href="#" data-target="register-company">企業登録</a></li>
                <li class="guest-only"><a href="#" class="btn-nav-login" data-target="login">企業ログイン</a></li>
                <li class="user-only hidden"><a href="#" id="logout-link">ログアウト</a></li>
            </ul>
            <small id="user-name"></small>
        </nav>
    </div>
</header>
<main>
    <section id="home" class="active">
        <div class="hero">
            <h1>島根の部活動と企業をつなぐマッチングプラットフォーム</h1>
            <p>地域の未来を担う学生たちの挑戦を、企業の力で支えませんか？<br>島根県内の部活動と企業を繋ぎ、必要なサポートを素早く提供します。</p>
            <div class="hero-buttons">
                <button type="button" class="btn btn-primary" data-target="list">支援先を探す</button>
                <button type="button" class="btn btn-secondary" data-target="register-club">部活動として登録する</button>
            </div>
        </div>
        <div class="features">
            <div class="feature-card">
                <h3>1. ニーズを見える化</h3>
                <p>部活動ごとの課題・必要な支援内容を詳しく掲載。企業は自社の強みを活かした支援を選べます。</p>
            </div>
            <div class="feature-card">
                <h3>2. 申請はワンクリック</h3>
                <p>気になる部活動にはログイン後すぐにマッチング申請。メッセージ機能でやりとりもスムーズ。</p>
            </div>
            <div class="feature-card">
                <h3>3. 島根に特化</h3>
                <p>県内の学校・クラブ情報を集約。地域密着の支援活動を実現できます。</p>
            </div>
        </div>
    </section>
    <section id="list">
        <h2>支援先を探す</h2>
        <div class="info-box">
            <strong>ログイン状況:</strong> <span id="list-login-state">ゲスト（ログインするとマッチング申請できます）</span>
        </div>
        <div id="club-list-container" class="club-list"></div>
    </section>
    <section id="register-club">
        <h2>部活動の新規登録</h2>
        <form id="form-club">
            <div class="form-group">
                <label for="club-name">部活動名</label>
                <input type="text" id="club-name" name="name" required>
            </div>
            <div class="form-group">
                <label for="club-email">連絡先メールアドレス</label>
                <input type="email" id="club-email" name="email" required>
            </div>
            <div class="form-group">
                <label for="club-area">活動エリア</label>
                <select id="club-area" name="area" required>
                    <option value="出雲市">出雲市</option>
                    <option value="松江市">松江市</option>
                    <option value="浜田市">浜田市</option>
                    <option value="益田市">益田市</option>
                    <option value="隠岐の島町">隠岐の島町</option>
                </select>
            </div>
            <div class="form-group">
                <label for="club-category">カテゴリ</label>
                <select id="club-category" name="category" required>
                    <option value="球技">球技</option>
                    <option value="文化">文化</option>
                    <option value="吹奏楽">吹奏楽</option>
                    <option value="科学・技術">科学・技術</option>
                    <option value="その他">その他</option>
                </select>
            </div>
            <div class="form-group">
                <label for="club-needs">必要なサポート内容</label>
                <textarea id="club-needs" name="needs" required></textarea>
            </div>
            <button class="btn btn-primary" type="submit">登録する</button>
            <p id="club-message" class="alert hidden"></p>
        </form>
    </section>
    <section id="register-company">
        <h2>企業サポーター登録</h2>
        <form id="form-company">
            <div class="form-group">
                <label for="company-name">企業名</label>
                <input type="text" id="company-name" name="company_name" required>
            </div>
            <div class="form-group">
                <label for="contact-name">担当者名</label>
                <input type="text" id="contact-name" name="contact_name" required>
            </div>
            <div class="form-group">
                <label for="company-email">メールアドレス</label>
                <input type="email" id="company-email" name="email" required>
            </div>
            <div class="form-group">
                <label for="support-menu">提供できるサポート内容</label>
                <textarea id="support-menu" name="support_menu" required></textarea>
            </div>
            <button class="btn btn-primary" type="submit">登録する</button>
            <p id="company-message" class="alert hidden"></p>
        </form>
    </section>
    <section id="login">
        <h2>企業ログイン</h2>
        <form id="form-login">
            <div class="form-group">
                <label for="login-email">メールアドレス</label>
                <input type="email" id="login-email" name="email" required>
            </div>
            <div class="form-group">
                <label for="login-pass">パスワード</label>
                <input type="password" id="login-pass" name="password" required>
            </div>
            <button class="btn btn-primary" type="submit">ログイン</button>
            <p id="login-error" class="alert alert-error hidden">メールアドレスまたはパスワードが正しくありません。</p>
        </form>
    </section>
</main>
<footer>
    <small>© {{ date('Y') }} みんなの部活応援隊 Shimane</small>
</footer>
<script>
    const app = {
        state: {
            isLoggedIn: Boolean(@json($sessionUser ? true : false)),
            currentUser: @json($sessionUser ?? null),
            clubs: @json($initialClubs ?? []),
            csrfToken: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        init() {
            document.querySelectorAll('nav a, .hero button, .logo').forEach(link => {
                link.addEventListener('click', (e) => {
                    const target = e.currentTarget.getAttribute('data-target');
                    if (target) {
                        e.preventDefault();
                        this.navigate(target);
                    }
                });
            });

            document.getElementById('form-login').addEventListener('submit', (e) => this.handleLogin(e));
            document.getElementById('logout-link').addEventListener('click', (e) => {
                e.preventDefault();
                this.logout();
            });
            document.getElementById('form-club').addEventListener('submit', (e) => this.handleClubRegister(e));
            document.getElementById('form-company').addEventListener('submit', (e) => this.handleCompanyRegister(e));

            this.renderNav();
            this.renderClubList();
        },
        buildJsonOptions(method, payload = null) {
            const options = {
                method,
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': this.state.csrfToken,
                },
            };
            if (payload) {
                options.body = JSON.stringify(payload);
            }
            return options;
        },
        navigate(pageId) {
            document.querySelectorAll('section').forEach(sec => sec.classList.remove('active'));
            const target = document.getElementById(pageId);
            if (target) {
                target.classList.add('active');
            }
            if (pageId === 'list') {
                this.refreshClubs();
            }
            window.scrollTo({ top: 0, behavior: 'smooth' });
        },
        renderNav() {
            const guestLinks = document.querySelectorAll('.guest-only');
            const userLinks = document.querySelectorAll('.user-only');
            const userNameSpan = document.getElementById('user-name');
            const listLoginState = document.getElementById('list-login-state');

            if (this.state.isLoggedIn) {
                guestLinks.forEach(el => el.classList.add('hidden'));
                userLinks.forEach(el => el.classList.remove('hidden'));
                userNameSpan.textContent = `${this.state.currentUser.name} さんとしてログイン中`;
                listLoginState.textContent = `${this.state.currentUser.name} さんとしてログイン中`;
            } else {
                guestLinks.forEach(el => el.classList.remove('hidden'));
                userLinks.forEach(el => el.classList.add('hidden'));
                userNameSpan.textContent = '';
                listLoginState.textContent = 'ゲスト（ログインするとマッチング申請できます）';
            }
        },
        async refreshClubs() {
            const response = await fetch('/clubs');
            if (response.ok) {
                const json = await response.json();
                this.state.clubs = json.data;
                this.renderClubList();
            }
        },
        renderClubList() {
            const container = document.getElementById('club-list-container');
            container.innerHTML = '';
            if (!this.state.clubs.length) {
                container.innerHTML = '<p>登録されている部活動がまだありません。</p>';
                return;
            }
            this.state.clubs.forEach(club => {
                const card = document.createElement('div');
                card.className = 'club-card';
                const disabledText = this.state.isLoggedIn ? '' : 'disabled';
                const buttonLabel = this.state.isLoggedIn ? 'マッチング申請する' : 'ログインして申請';
                card.innerHTML = `
                    <div>
                        <div class="club-header">${club.name}</div>
                        <div class="club-meta">
                            <span class="tag">📍 ${club.area}</span>
                            <span class="tag">🏷 ${club.category}</span>
                        </div>
                        <div class="club-needs">
                            <strong>求む支援：</strong><br>${club.needs}
                        </div>
                    </div>
                    <div class="match-status">
                        <button type="button" class="btn btn-primary" data-club="${club.id}" ${disabledText}>${buttonLabel}</button>
                    </div>
                `;
                container.appendChild(card);
            });
            container.querySelectorAll('button[data-club]').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const clubId = e.currentTarget.getAttribute('data-club');
                    this.applyMatch(clubId);
                });
            });
        },
        extractError(json) {
            if (!json) {
                return '不明なエラーが発生しました。';
            }
            if (json.message) {
                return json.message;
            }
            if (json.errors) {
                const first = Object.values(json.errors)[0];
                if (first && first.length) {
                    return first[0];
                }
            }
            return '処理に失敗しました。時間を置いて再度お試しください。';
        },
        async handleLogin(event) {
            event.preventDefault();
            const form = event.target;
            const payload = {
                email: form.email.value,
                password: form.password.value,
            };
            const response = await fetch('/login', this.buildJsonOptions('POST', payload));
            const messageBox = document.getElementById('login-error');
            if (response.ok) {
                const json = await response.json();
                this.state.isLoggedIn = true;
                this.state.currentUser = json.user;
                messageBox.classList.add('hidden');
                form.reset();
                this.renderNav();
                alert('ログインしました！');
                this.navigate('list');
            } else {
                const json = await response.json();
                messageBox.textContent = this.extractError(json);
                messageBox.classList.remove('hidden');
            }
        },
        async logout() {
            const response = await fetch('/logout', this.buildJsonOptions('POST'));
            if (response.ok) {
                this.state.isLoggedIn = false;
                this.state.currentUser = null;
                this.renderNav();
                alert('ログアウトしました。');
                this.navigate('home');
            }
        },
        async handleClubRegister(event) {
            event.preventDefault();
            const form = event.target;
            const formData = new FormData(form);
            const payload = Object.fromEntries(formData.entries());
            const response = await fetch('/clubs', this.buildJsonOptions('POST', payload));
            const message = document.getElementById('club-message');
            message.classList.remove('alert-error', 'alert-success', 'hidden');
            if (response.ok) {
                const json = await response.json();
                message.textContent = json.message;
                message.classList.add('alert-success');
                form.reset();
                this.refreshClubs();
                alert(json.message);
                message.textContent = '';
                message.classList.add('hidden');
                message.classList.remove('alert-success');
                this.navigate('list');
            } else {
                const json = await response.json();
                message.textContent = this.extractError(json);
                message.classList.add('alert-error');
            }
        },
        async handleCompanyRegister(event) {
            event.preventDefault();
            const form = event.target;
            const payload = Object.fromEntries(new FormData(form).entries());
            const response = await fetch('/companies', this.buildJsonOptions('POST', payload));
            const message = document.getElementById('company-message');
            message.classList.remove('hidden', 'alert-error', 'alert-success');
            if (response.ok) {
                const json = await response.json();
                form.reset();
                alert(json.message);
                message.textContent = '';
                message.classList.add('hidden');
                message.classList.remove('alert-success');
                this.navigate('home');
            } else {
                const json = await response.json();
                message.textContent = this.extractError(json);
                message.classList.add('alert-error');
            }
        },
        async applyMatch(clubId) {
            if (!this.state.isLoggedIn) {
                alert('マッチング申請をするにはログインしてください。');
                this.navigate('login');
                return;
            }
            const response = await fetch(`/clubs/${clubId}/apply`, this.buildJsonOptions('POST'));
            if (response.ok) {
                const json = await response.json();
                alert(json.message);
            } else {
                const json = await response.json();
                alert(this.extractError(json));
            }
        }
    };

    document.addEventListener('DOMContentLoaded', () => app.init());
</script>
</body>
</html>
