        <!-- Start your code with two indents (each indent should have 4 spaces) -->
        <header class="page--width">
            <a href="/">Village88 Merch 🧢</a>
            <a href="/register">Register</a>
        </header>

        <div class="error message"><?= $this->session->flashdata('input_errors'); ?></div>

        <section class="page--width">
            <h1>Login</h1>
            <form action="login/validate" class="form--block" method="POST">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>" />
                <span>Email address:</span>
                <input type="email" name="email" class="input--default" value="wtf@gmail.com">
                <span>Password:</span>
                <input type="password" name="password" class="input--default" value="jlaksdasldjkasldaksjdl">
                <input type="submit" value="Login" class="primary--btn">
            </form>    
            <a href="/register" class="a--default">Don't have an account? Register</a>
        </section>