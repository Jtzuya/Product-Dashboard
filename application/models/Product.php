<?php
class Product extends CI_Model {
    public function create_product($product_data) {
        $cols = "product_name, product_description, product_price, product_stock, created_at";
        $query = "INSERT INTO products ($cols) VALUES (?,?,?,?,?)";
        $values = array(
            $this->security->xss_clean($product_data['product_name']),
            $this->security->xss_clean($product_data['product_description']),
            $this->security->xss_clean($product_data['product_price']),
            $this->security->xss_clean($product_data['product_stock']),
            date('Y-m-d, H:i:s'),
        );

        return $this->db->query($query, $values);
    }

    public function get_all_products() {
        $query = "SELECT * FROM products";
        return $this->db->query($query)->result_array();
    }

    public function get_product_by_id($product_id) {
        $query = "SELECT * FROM products WHERE id=?";
        $sanitize_id = $this->security->xss_clean($product_id);
        return $this->db->query($query, $sanitize_id)->result_array()[0];
    }

    public function update_product_by_id($product_id, $product_details) {
        $data = array();

        foreach($product_details as $key => $detail) {
            if($detail !== '') {
                $data[$key] = $this->security->xss_clean($detail);
            }
        }

        $data['updated_at'] = date('Y-m-d, H:i:s');

        $this->db->where('id', $product_id);
        return $this->db->update('products', $data);
    }

    public function delete_product_by_id($product_id) {
        $query = "DELETE FROM products WHERE id=?";
        return $this->db->query($query, $product_id);
    }

    public function post_review($review_data) {
        $data = array();

        foreach($review_data as $key => $review) {
            $data[$key] = $this->security->xss_clean($review);
        }

        if($data['message'] !== '') {
            $cols = "product_id, user_id, message, created_at";
            $query = "INSERT INTO reviews ($cols) VALUES (?,?,?,?)";
            $values = array(
                $this->security->xss_clean(intval($data['product_id'])),
                $this->security->xss_clean(intval($data['user_id'])),
                $this->security->xss_clean($data['message']),
                date('Y-m-d, H:i:s'),
            );
            
            return $this->db->query($query, $values);
        } else {
            return 'nodata';
        }
    }

    public function get_reviews_by($product_id) {
        $cols = "reviews.*, users.first_name, users.last_name";
        $join1 = "LEFT JOIN users ON reviews.user_id = users.id";
        $query = "SELECT $cols FROM reviews $join1 WHERE product_id=? ORDER BY created_at DESC";
        $id = $this->security->xss_clean($product_id);
        return $this->db->query($query, $id)->result_array();
    }

    public function post_reply($reply_data) {
        $data = array();

        foreach($reply_data as $key => $reply) {
            $data[$key] = $reply;
        }

        if($data['message'] !== '') {
            $data['created_at'] = date('Y-m-d, H:i:s');
            $cols = "user_id, review_id, message, created_at";
            $query = "INSERT INTO replies ($cols) VALUES (?,?,?,?)";
            $values = array(
                $this->security->xss_clean(intval($data['user_id'])),
                $this->security->xss_clean(intval($data['review_id'])),
                $this->security->xss_clean($data['message']),
                date('Y-m-d, H:i:s')
            );

            return $this->db->query($query, $values);
        } else {
            return 'nodata';
        }
    }
    
    public function get_replies($product_id) {
        $cols = "replies.*, users.first_name, users.last_name";
        $join1 = "LEFT JOIN users ON replies.user_id = users.id";
        $join2 = "LEFT JOIN reviews ON replies.review_id = reviews.id";
        $join3 = "LEFT JOIN products ON reviews.product_id = products.id";
        $query = "SELECT $cols FROM replies $join1 $join2 $join3 WHERE product_id=? ORDER BY replies.created_at DESC";
        $id = $this->security->xss_clean($product_id);
        return $this->db->query($query, $id)->result_array();
    }
}
