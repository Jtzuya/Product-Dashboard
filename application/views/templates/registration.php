        <!-- Start your code with two indents (each indent should have 4 spaces) -->
        <header class="page--width">
            <a href="/">Village88 Merch 🧢</a>
            <a href="/">Login</a>
        </header>

        <div class="error message"><?=$this->session->flashdata('input_errors');?></div>

        <section class="page--width">
            <h1>Register</h1>
            <form action="register/validate" class="form--block" method="POST">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                <span>Email address:</span>
                <input type="email" name="email" class="input--default" value="<?= bin2hex(openssl_random_pseudo_bytes(5)); ?>@gmail.com">
                <span>First Name:</span>
                <input type="text" name="first_name" class="input--default" value="<?= bin2hex(openssl_random_pseudo_bytes(5)); ?>">
                <span>Last Name:</span>
                <input type="text" name="last_name" class="input--default" value="<?= bin2hex(openssl_random_pseudo_bytes(5)); ?>">
                <span>Password:</span>
                <input type="password" name="password" class="input--default" value="123456789">
                <span>Confirm Password:</span>
                <input type="password" name="confirm_password" class="input--default" value="123456789">
                <input type="submit" value="Login" class="primary--btn">
            </form>    
            <a href="/" class="a--default">Already have an account? Login</a>
        </section>