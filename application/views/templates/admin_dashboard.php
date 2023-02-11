        <!-- Start your code with two indents (each indent should have 4 spaces) -->
        <header class="page--width">
            <div class="multi--nav">
                <a href="/">Village88 Merch 🧢</a>
                <a href="/dashboard" class="active--path">Dashboard</a>
                <a href="<?= base_url('users/edit') ?>">Profile</a>
            </div>
            <a href="/logout">Logout</a>
        </header>

        <div class="error message"><?=$this->session->flashdata('input_errors');?></div>
        <div class="success message"><?=$this->session->flashdata('success');?></div>

        <section class="page--width">
            <div class="admin">
                <h1>All Products</h1>
                <div>
                    <a href="/products/new" class="secondary--btn">Add Products</a>
                </div>
            </div>
            <table>
                <thead>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>INVENTORY COUNT</th>
                    <th>QUANTITY SOLD</th>
                    <th>ACTION</th>
                </thead>
                <tbody>
                    <?php foreach($datas as $data) { ?>
                        <tr>
                            <td><?= $data['id'] ?></td>
                            <td>
                                <a href='<?= base_url("products/show/{$data['id']}"); ?>' >
                                    <?= $data['product_name'] ?>
                                </a>
                            </td>
                            <td><?= $data['product_stock'] ?></td>
                            <td>0</td>
                            <td>
                                <a href='<?= base_url("products/edit/{$data['id']}"); ?>'>edit</a>
                                <span class="delete--product" data-product-id="<?= $data['id'] ?>" data-url='<?= base_url("products/delete/{$data['id']}") ?>'>remove</span>
                                <div class="popup_modal">
                                    <p></p>
                                </div>
                            </td>
                        </tr>
                    <?php } ?>
                    <!-- <tr>
                        <td>2.</td>
                        <td>Gucci</td>
                        <td>100</td>
                        <td>500</td>
                        <td>
                            <a href="<?= base_url('products/edit/1'); ?>">edit</a>
                            <a href="/">remove</a>
                        </td>
                    </tr>-->
                </tbody>
            </table>
        </section>