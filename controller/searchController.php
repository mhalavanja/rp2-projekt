<?php


class searchController extends BaseController
{
    function index()
    {
        $this->registry->template->starProducts = isset($_SESSION["starProducts"]) ? $_SESSION["starProducts"] : null;
        $_SESSION["starProducts"] = null;
        $this->registry->template->show("search");
    }

    function processSearch()
    {
        $searchTerm = isset($_POST["search"]) ? $_POST["search"] : null;
        $searchTerm = "%" . $searchTerm . "%";
        $products = Product::like("name", $searchTerm);
        $starProducts = $this->getAvgRatingForProducts($products);
        $_SESSION["starProducts"] = $starProducts;
        header('Location: ' . __SITE_URL . '/index.php?rt=search');
    }

    function searchDetails()
    {
        $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : null;

        if (!$product_id || !preg_match('/^product_[0-9]+$/', $product_id)) {
            exit();
        }

        $canBuy = true;
        $userId = $_SESSION["user"]->getId();
        $productId = substr($product_id, 8);
        $product = Product::find($productId);
        //ako je kupac vec kupio to ne moze vise ili ako je to produkt koji on prodaje
        $sales = Sale::where("id_product", $productId);
        $reviews = [];
        if ( $product->getId_user() === $userId) $canBuy = false;
        $numOfSoldProducts = sizeof($sales);

        foreach ($sales as $sale) {
            $review = [];
            $buyerId = $sale->getId_user();
            $buyer = User::find($buyerId);
            $rating = $sale->getRating();
            $comment = $sale->getComment();
            $totalRating = 0;
            $numOfRatings = 0;

            if ($buyerId === $userId) {
                $canBuy = false;
                continue;
            }
            if ($rating === null && $comment === null) continue;
            $totalRating += $rating;
            $numOfRatings += 1;

            $review["username"] = $buyer->getUsername();
            $review["rating"] = $rating;
            $review["comment"] = $comment;
            $reviews[] = $review;
        }
        $avgRating = $numOfRatings !== 0 ? round(($totalRating / $numOfRatings) * 2) / 2 : 0;
        $this->registry->template->reviews = $reviews;
        $this->registry->template->canBuy = $canBuy;
        $this->registry->template->product = $product;
        $this->registry->template->avgRating = $avgRating;
        $this->registry->template->numOfSoldProducts = $numOfSoldProducts;
        $this->registry->template->show("product");
    }
}