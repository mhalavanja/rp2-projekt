<?php
require_once __SITE_PATH . '/util/starProductUtil.php';
require_once __SITE_PATH . '/util/reviewUtil.php';


class hotelsController extends BaseController
{
    function index()
    {
        $user = $_SESSION["user"];
        $products = Hotel::where("id_user", $user->getId());
        $this->registry->template->user = $user;
        $this->registry->template->starProducts = getStarProducts($products);
        $this->registry->template->show("my-products");
    }

    function product()
    {
        $userId = $_SESSION["user"]->getId();
        $product_id = null;
        if (isset($_POST['product_id'])) $product_id = $_POST['product_id'];
        elseif (isset($_SESSION['product_id'])) {
            $product_id = $_SESSION['product_id'];
            $_SESSION['product_id'] = null;
        }

        if (!$product_id || !preg_match('/^product_[0-9]+$/', $product_id)) {
            exit();
        }

        $productId = substr($product_id, 8);
        $product = Hotel::find($productId);
        $sales = Booking::where("id_product", $productId);
        $saleId = getSaleIdForUserIfTheyCanReview($userId, $sales);

        $this->registry->template->canReview = (bool)$saleId;
        $this->registry->template->reviews = getReviewsForProduct($sales);
        $this->registry->template->saleId = $saleId;
        $this->registry->template->starProduct = getStarProduct($product);
        $this->registry->template->numOfSoldProducts = sizeof($sales);
        $this->registry->template->show("product");
    }

    function newProduct()
    {
        $this->registry->template->show("new-product");
    }

    function processNewProduct()
    {
        if (!isset($_POST['name']) || !isset($_POST['description']) || !isset($_POST['price']) ||
            empty($_POST['name']) || empty($_POST['description']) || empty($_POST['price'])) {
            $this->registry->template->error = true;
            $this->registry->template->show("new-product");
            return;
        }
        $product = new Hotel();
        $product->setName($_POST['name']);
        $product->setDescription($_POST['description']);
        $product->setPrice($_POST['price']);
        $product->setId_user($_SESSION["user"]->getId());
        Hotel::save($product);
        header('Location: ' . __SITE_URL . '/index.php?rt=products');
    }

    function shoppingHistory()
    {
        $sales = Booking::where("id_user", $_SESSION["user"]->getId());
        $products = [];
        foreach ($sales as $sale) {
            $product = Hotel::find($sale->getId_product());
            $products[] = $product;
        }
        $this->registry->template->starProducts = getStarProducts($products);
        $this->registry->template->show("shopping-history");
    }

    function processReview()
    {
        $rating = $_POST["rating"] ?? null;
        $comment = $_POST["comment"] ?? null;
        $sale = new Booking();
        $sale->setId_user($_SESSION["user"]->getId());
        $sale->setId($_POST["saleId"]);
        $sale->setId_product($_POST["product_id"]);
        $sale->setRating($rating);
        $sale->setComment($comment);
        $_SESSION["product_id"] = "product_" . $_POST["product_id"];
        Booking::save($sale);
        header('Location: ' . __SITE_URL . '/index.php?rt=products/product');
    }

    function processBuy()
    {
        $productId = $_POST["productId"] ?? null;
        $userId = $_SESSION["user"]->getId();
        if (!$userId) header('Location: ' . __SITE_URL . '/index.php');
        if (!$productId) exit();
        $sale = new Booking();
        $sale->setId_product($productId);
        $sale->setId_user($userId);
        Booking::save($sale);
        header('Location: ' . __SITE_URL . '/index.php?rt=search');
    }
}