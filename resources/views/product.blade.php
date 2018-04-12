@extends('layouts.headAndFoot')

@section('content')
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show col-sm-6 offset-3 text-center" style="z-index: 1; position: absolute">
            <i class="fa fa-times" aria-hidden="true"></i>
            {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show col-sm-6 offset-3 text-center" style="z-index: 1; position: absolute">
            <i class="fa fa-check" aria-hidden="true"></i>
            {{ session('success') }}
            <a href="{{route('cart')}}">Cliquez ici pour accèder a votre panier</a>
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif
<section class="jumbotron text-center">
    <div class="container">
        <h1 class="jumbotron-heading">{{$produit->name}}</h1>
    </div>
</section>

<div class="container">
    <div class="row">
        <div class="col">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route("shop")}}">Ces'ESport Goodies</a></li>
                    <li class="breadcrumb-item"><a href="{{route("category")}}">Catégorie</a></li>
                    <li class="breadcrumb-item"><a href="{{route("category")}}">{{$produit->category->name}}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{$produit->name}}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <!-- Image -->
        <div class="col-12 col-lg-6">
            <div class="card bg-light mb-3">
                <div class="card-body">
                    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                        </ol>
                        <div class="carousel-inner">
                            @foreach($produit->pictures()->get() as $pict)
                            <div class="carousel-item active">
                                <img class="d-block w-100" src="{{$pict->url}}" alt="First slide">
                            </div>
                            @endforeach
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add to cart -->
        <div class="col-12 col-lg-6 add_to_cart_block">
            <div class="card bg-light mb-3">
                <div class="card-body">
                    <p class="price">{{$produit->price}} $</p>
                    <p class="price_discounted">{{$remise}} $</p>
                    <form method="POST" action="{{route('addtocart', $produit->id)}}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Quantité :</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <button type="button" class="quantity-left-minus btn btn-danger btn-number"  data-type="minus" data-field="">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                </div>
                                <input type="text" class="form-control" id="quantity" name="quantity" min="1" max="10" value="1">
                                <div class="input-group-append">
                                    <button type="button" class="quantity-right-plus btn btn-success btn-number" data-type="plus" data-field="">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                        @if($produit->stock > 0)
                            <button type="submit" class="btn btn-success btn-lg btn-block text-uppercase">
                                <i class="fa fa-cart-plus"></i> Ajouter au panier
                            </button>
                        @else
                            <a href="{{route('category')}}" class="btn btn-danger btn-lg btn-block text-uppercase">
                                <i class="fa fa-frown-o" aria-hidden="true"></i> Produit victime de son succès
                            </a>
                        @endif
                    </form>
                    <div class="product_rassurance">
                        <ul class="list-inline">
                            <li class="list-inline-item"><i class="fa fa-truck fa-2x"></i><br/>Livraison au Cesi</li>
                            <li class="list-inline-item"><i class="fa fa-money fa-2x" aria-hidden="true"></i></i><br/>Paiement Espèce</li>
                            <li class="list-inline-item"><i class="fa fa-cc-paypal fa-2x" aria-hidden="true"></i></i></i><br/>Paiement Paypal</li>
                        </ul>
                    </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Description -->
        <div class="col-12">
            <div class="card border-light mb-3">
                <div class="card-header bg-primary text-white text-uppercase"><i class="fa fa-align-justify"></i> Description</div>
                <div class="card-body">
                    <p class="card-text">
                        {{$produit->description}}
                    </p>
                </div>
            </div>
        </div>

        <!-- Reviews -->
        @if($yes)
        <div class="col-12" id="reviews">
            <div class="card border-light mb-3">
                <div class="card-header bg-primary text-white text-uppercase"><i class="fa fa-comment"></i> Avis</div>
                <div class="card-body">
                    @foreach($picture as $pict)
                        @foreach($pict->comments()->get() as $comment)
                            <div class="review">
                                <span class="glyphicon glyphicon-calendar" aria-hidden="true"></span>
                                <meta itemprop="datePublished" content="01-01-2016">{{ $comment->created_at->format('d M Y - H:i') }}
                                par {{$comment->writer->name}}
                                <p class="blockquote">
                                <p class="mb-0">{{$comment->content}}</p>
                                </p>
                                <hr>
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="productModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="productModalLabel">Product title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <img class="img-fluid" src="https://dummyimage.com/1200x1200/55595c/fff" />
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@endsection