        <!-- Start your code with two indents (each indent should have 4 spaces) -->
        <header class="page--width">
            <div class="multi--nav">
                <a href="/">Village88 Merch 🧢</a>
                <a href="/dashboard" class="active--path">Dashboard</a>
                <a href="<?= base_url('users/edit') ?>">Profile</a>
            </div>
            <a href="/logout">Logout</a>
        </header>

        <div class="success message"><?=$this->session->flashdata('success');?></div>

        <section class="page--width">
            <div class="admin">
                <h1>Edit Product #<?= $id ?></h1>
                <div>
                    <a href="/" class="secondary--btn">Return to Dashboard</a>
                </div>
            </div>
            <form action='<?= base_url("products/updating-product/{$id}"); ?>' class="form--block" method="POST">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                <span>Name:</span>
                <input type="text" name="product_name" class="input--default" placeholder="(product name)">
                <span>Description:</span>
                <textarea name="product_description" class="input--default" cols="30" rows="10" placeholder="(product description)"></textarea>
                <span>Price:</span>
                <input type="number" step="any" name="product_price" class="input--default" placeholder="(product price i.e $19.99)">
                <span>Inventory Count:</span>
                <input type="number" name="product_stock" class="input--default" placeholder="3">
                <input type="submit" value="Save" class="primary--btn">
            </form>
        </section>