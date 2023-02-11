        <!-- Start your code with two indents (each indent should have 4 spaces) -->
        <header class="page--width">
            <div class="multi--nav">
                <a href="/">Village88 Merch 🧢</a>
                <a href="/dashboard">Dashboard</a>
                <a href="<?= base_url('users/edit') ?>">Profile</a>
            </div>
            <a href="/logout">Logout</a>
        </header>

        <div class="success message"><?=$this->session->flashdata('success');?></div>
        <div class="error message"><?=$this->session->flashdata('input_errors');?></div>

        <section class="page--width profile__wrapper">
            <h1>Edit Profile</h1>
            <form action="<?= base_url('users/update-info'); ?>" class="form--block" method="POST">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash()?>">
                <fieldset>
                    <legend>Edit Information</legend>
                    <span>Email address:</span>
                    <input type="email" name="email" class="input--default" placeholder="i.e. johndoe@gmail.com">
                    <span>First Name:</span>
                    <input type="text" name="first_name" class="input--default" placeholder="John">
                    <span>Last Name:</span>
                    <input type="text" name="last_name" class="input--default" placeholder="Doe">
                    <input type="submit" value="Save" class="primary--btn">
                </fieldset>
            </form>
            
            <form action="<?= base_url('users/update-password'); ?>" class="form--block" method="POST">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash()?>">
                <fieldset>
                    <legend>Change Password</legend>
                    <span>Old Password:</span>
                    <input type="password" name="old_password" class="input--default" placeholder="123456789">
                    <span>New Password:</span>
                    <input type="password" name="new_password" class="input--default" placeholder="new123456789">
                    <span>Confirm Password:</span>
                    <input type="password" name="confirm_new_password" class="input--default" placeholder="new123456789">
                    <input type="submit" value="Save" class="primary--btn">
                </fieldset>
            </form>
        </section>