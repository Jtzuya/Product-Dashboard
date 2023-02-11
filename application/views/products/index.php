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
                <h1>Add a new Product</h1>
                <div>
                    <a href="/" class="secondary--btn">Return to Dashboard</a>
                </div>
            </div>
            <form action="<?= base_url('products/creating'); ?>" class="form--block" method="POST">
                <input type="hidden" name="<?=$this->security->get_csrf_token_name();?>" value="<?=$this->security->get_csrf_hash();?>" />
                <span>Name:</span>
                <input type="text" name="product_name" class="input--default" value="Versace 24k Chain-<?= bin2hex(openssl_random_pseudo_bytes(5)); ?>">
                <span>Description:</span>
                <textarea name="product_description" class="input--default" cols="30" rows="10">Quintessentially Versace, this chunky chain necklace is embellished with a bold Medusa medallion. All Versace Jewelry items are lead and nickel free. All materials are hypoallergenic.</textarea>
                <span>Price:</span>
                <input type="number" name="product_price" class="input--default" value="3999.99">
                <span>Inventory Count:</span>
                <input type="number" name="product_stock" class="input--default" value="100">
                <input type="submit" value="Create" class="primary--btn">
            </form>
        </section>