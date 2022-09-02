<?php

class ReportModel extends CI_Model
{
    public function queryPurchase()
    {
        $this->db->select('products.name AS product_name, products.price, products.photo, supplier.name AS supplier_name, purchase_detail.qty, purchase_detail.total AS sub_total, purchase.code AS invoice');
        $this->db->from('products');
        $this->db->join('supplier', 'products.supplier_id = supplier.id');
        $this->db->join('purchase_detail', 'products.id = purchase_detail.product_id');
        $this->db->join('purchase', 'purchase_detail.purchase_id = purchase.id');
        $query = $this->db->get();
        return $query->result();
    }

    public function querySale()
    {
        $this->db->select('products.name AS product_name, products.price, products.photo, supplier.name AS supplier_name, transaction_detail.qty, transaction_detail.total AS sub_total, transactions.code AS invoice');
        $this->db->from('products');
        $this->db->join('supplier', 'products.supplier_id = supplier.id');
        $this->db->join('transaction_detail', 'products.id = transaction_detail.product_id');
        $this->db->join('transactions', 'transaction_detail.transaction_id = transactions.id');
        $query = $this->db->get();
        return $query->result();
    }
}