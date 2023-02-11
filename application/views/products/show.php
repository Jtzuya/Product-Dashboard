        <!-- Start your code with two indents (each indent should have 4 spaces) -->
        <header class="page--width">
            <div class="multi--nav">
                <a href="/">Village88 Merch 🧢</a>
<?php if($active_user !== NULL) { ?>
                <a href="/dashboard">Dashboard</a>
                <a href="<?= base_url('users/edit') ?>">Profile</a>
<?php } ?>
            </div>
<?php if($active_user !== NULL) { ?>
                <a href="/logout">Logout</a>
<?php } ?>
        </header>

        <div class="error message"><?=$this->session->flashdata('input_errors');?></div>
        <div class="success message"><?=$this->session->flashdata('success');?></div>

        <section class="page--width show">
            <h1><?= $product['product_name']; ?> ($<?= $product['product_price']; ?>)</h1>
            <p>Added since: <?= $product['custom_date']; ?></p>
            <p>Product ID: # <?= $id ?></p>
            <p>Description: <?= $product['product_description']; ?></p>
            <p>Total Sold: 0</p>
            <p>Number of Available stocks: <?= $product['product_stock']; ?></p>

            <!-- If no user logged in, do not let them post a review/comment -->
            <?php if($active_user !== NULL) { ?>
                <form action="<?= base_url('') ?>products/create-review/<?= $id ?>" class="form--block" method="POST">
                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                    <i>Leave a review:</i>
                    <textarea name="review" id="" cols="30" rows="10" placeholder="Start writing here..."></textarea>
                    <div class="submit--btn__wrapper"><input type="submit" value="Post" class="primary--btn"></div>
                </form>
            <?php } else { ?>
                <!-- worst class naming 🤣 -->
                <a href="<?= base_url('/login') ?>" class="sign_in_to_add_review">Signin to post a review/comment</a> 
            <?php } ?>

            <?php if(is_array($reviews)) { ?>
                <div class="reviews">
                    <?php foreach($reviews as $review) { ?>
                        <section>
                            <div>
                                <p class="author"><?= $review['first_name'] ?> <?= $review['last_name'] ?> <span>wrote:</span></p>
                                <span class="date_published"><?= $review['custom_date'] ?></span>
                            </div>
                            <p><?= $review['message'] ?></p>

                            <?php if(count($replies) > 0) { ?>
                                <?php foreach($replies as $key => $reply) { ?>
                                    <?php if($reply['review_id'] == $review['id']) { ?>
                                        <section class="each_reply">
                                            <div>
                                                <p class="author"><?= $reply['first_name'] ?> <?= $reply['last_name'] ?> <span>wrote:</span></p>
                                                <span class="date_published"><?= custom_date($reply['created_at']); ?></span>
                                            </div>
                                            <p><?= $reply['message'] ?></p>
                                        </section>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                            
                            <?php if($active_user !== NULL) { ?>
                                <form action="<?= base_url('') ?>products/create-reply/<?= $id ?>/<?= $review['id'] ?>" class="form--block reply" method="POST">
                                    <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                                    <i>Write a comment:</i>
                                    <textarea name="reply" cols="30" rows="10" placeholder="For reply start writing here..."></textarea>
                                    <div class="submit--btn__wrapper"><input type="submit" value="Reply" class="primary--btn"></div>
                                </form>
                            <?php } ?>
                        </section>
                    <?php } ?>
                </div>
            <?php } ?>
        </section>