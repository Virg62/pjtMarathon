@extends('layouts.app')
@section('title',$series->nom)

@section('content')
    <div>

        <p><strong>Nom : </strong>{{$series->nom}}</p>
    </div>
    <div>

        <p><strong>Resume : </strong>{!! html_entity_decode($series->resume)!!}</p>
    </div>
    <div>

        <p><strong>Langue : </strong>{{$series->langue}}</p>
    </div><div>

        <p><strong>Note : </strong>{{$series->note}}</p>
    </div>
    <div>

        <p><strong>Statut : </strong>{{$series->statut}}</p>
    </div>

    <div>
        <p><strong>Première : </strong>{{$series->premiere}}</p>
    </div>

    <div>
        <p><img src={{ $series->urlImage }} /></p>
    </div>

    @if($series->avis = null)
        <div>
            <p><strong>Avis de la rédaction: </strong>{{$series->avis}}</p>
        </div>
    @else
        <div>
            <p><strong>Avis de la rédaction : </strong> d'avis de la rédaction disponible</p>
        </div>
    @endif
    @if($series->urlAvis != null)
    <div>
        <p><strong>Vidéo critique : </strong>{{$series->urlAvis}}</p>
    </div>
    @else
        <div>
            <p><strong>Vidéo critique : </strong>Pas de vidéo critique de la rédaction disponible</p>
        </div>
    @endif

@endsection