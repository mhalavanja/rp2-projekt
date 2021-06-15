<?php

class SearchController extends BaseController
{
    function index()
    {
        $this->registry->template->starProducts = $_SESSION["starProducts"] ?? null;
        $_SESSION["starProducts"] = null;
        $this->registry->template->show("search");
    }

    function processSearch()
    {
        $searchTerm = $_POST["search"] ?? null;
        $searchTerm = "%" . $searchTerm . "%";
        $products = Hotel::like("name", $searchTerm);
        $starProducts = getStarProducts($products);
        $_SESSION["starProducts"] = $starProducts;
        header('Location: ' . __SITE_URL . 'search');
    }

    function searchDetails()
    {
        $product_id = $_POST['product_id'] ?? null;

        if (!$product_id || !preg_match('/^product_[0-9]+$/', $product_id)) {
            exit();
        }

        $userId = $_SESSION["user"]->getId();
        $productId = substr($product_id, 8);
        $product = Hotel::find($productId);
        $sales = Booking::where("id_product", $productId);

        $this->registry->template->reviews = getReviewsForProduct($sales);
        $this->registry->template->canBuy = !($product->getId_user() === $userId || alreadyBought($userId, $sales));
        $this->registry->template->starProduct = getStarProduct($product);
        $this->registry->template->numOfSoldProducts = sizeof($sales);
        $this->registry->template->show("product");
    }
}