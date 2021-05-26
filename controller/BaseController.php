<?php


// Bazna apstraktna klasa za sve controllere
abstract class BaseController
{
    // controller sve podatke koje odhvati iz modela i koje će proslijediti view-u čuva u registry-ju.
    protected $registry;

    function __construct( $registry )
    {
        $this->registry = $registry;
    }

    // Svaki kontroller mora imati barem funkciju index.
    abstract function index();

    function getAvgRatingForProducts($products)
    {
        $starProducts = [];
        foreach ($products as $product){
            $avgRating = $this->getAvgRatingForProduct($product->getId());
            $starProduct = new StarProduct();
            $starProduct->setAvgRating($avgRating);
            $starProduct->setProduct($product);
            $starProducts[] = $starProduct;
        }
        return $starProducts;
    }

    function getAvgRatingForProduct($id)
    {
        $totalRating = 0;
        $numOfRatings = 0;
        $sales = Sale::where("id_product", $id);
        foreach ($sales as $sale){
            $rating = $sale->getRating();
            if ($rating !== null){
                $numOfRatings++;
                $totalRating += $rating;
            }
        }
        $avgRating = $numOfRatings !== 0 ? round(($totalRating / $numOfRatings) * 2) / 2 : 0;
        return $avgRating;
    }
}
