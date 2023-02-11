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

        <section class="page--width">
            <h1>All Products</h1>
            <table>
                <thead>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>INVENTORY COUNT</th>
                    <th>QUANTITY SOLD</th>
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
                        </tr>
                    <?php } ?>
                    <!-- <tr>
                        <td>2.</td>
                        <td>Gucci</td>
                        <td>100</td>
                        <td>500</td>
                    </tr>
                    <tr>
                        <td>3.</td>
                        <td>Prada</td>
                        <td>25</td>
                        <td>2500</td>
                    </tr>
                    <tr>
                        <td>4.</td>
                        <td>Versace</td>
                        <td>75</td>
                        <td>3500</td>
                    </tr> -->
                </tbody>
            </table>
        </section>