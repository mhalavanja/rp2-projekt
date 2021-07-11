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
}
